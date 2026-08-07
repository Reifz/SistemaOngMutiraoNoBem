<?php

namespace Tests\Feature;

use App\Models\Crianca;
use App\Models\Responsavel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_generic_user_cannot_access_sensitive_areas(): void
    {
        $user = User::factory()->create(['role' => 'user', 'ativo' => true]);

        $this->actingAs($user)->get('/triagem')->assertForbidden();
        $this->actingAs($user)->get('/matricula')->assertForbidden();
        $this->actingAs($user)->get('/anamnese')->assertForbidden();
        $this->actingAs($user)->get('/relatorios/evasao')->assertForbidden();
    }

    public function test_role_cannot_access_another_sensitive_area(): void
    {
        $user = User::factory()->create(['role' => 'triagem', 'ativo' => true]);

        $this->actingAs($user)->get('/anamnese')->assertForbidden();
        $this->actingAs($user)->get('/matricula')->assertForbidden();
    }

    public function test_private_attachment_requires_document_role_and_is_audited(): void
    {
        Storage::fake('local');

        $guardian = Responsavel::create([
            'nome' => 'Responsável',
            'email' => 'responsavel@example.test',
            'telefone' => '11999999999',
        ]);
        $child = Crianca::create([
            'responsavel_id' => $guardian->id,
            'nome' => 'Criança',
            'data_nascimento' => '2018-01-01',
            'anexo_cpf' => 'anexos/criancas/cpf.pdf',
        ]);
        Storage::disk('local')->put($child->anexo_cpf, 'arquivo privado');

        $unauthorized = User::factory()->create(['role' => 'saude', 'ativo' => true]);
        $this->actingAs($unauthorized)
            ->get(route('anexos.show', ['tipo' => 'crianca', 'id' => $child->id, 'campo' => 'anexo_cpf']))
            ->assertForbidden();

        $authorized = User::factory()->create(['role' => 'matricula', 'ativo' => true]);
        $this->actingAs($authorized)
            ->get(route('anexos.show', ['tipo' => 'crianca', 'id' => $child->id, 'campo' => 'anexo_cpf']))
            ->assertOk()
            ->assertHeader('cache-control', 'private, no-store, max-age=0');

        $this->assertDatabaseHas('logs_auditoria', [
            'usuario_id' => $authorized->id,
            'acao' => 'Documento: Download autorizado',
            'registro_id' => $child->id,
        ]);
    }

    public function test_inactive_admin_cannot_access_administration(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'ativo' => false]);

        $this->actingAs($admin)
            ->get(route('usuarios.index'))
            ->assertRedirect(route('home'));
    }
}
