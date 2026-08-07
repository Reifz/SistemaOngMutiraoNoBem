<?php

namespace Tests\Feature;

use App\Models\Crianca;
use App\Models\Responsavel;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TurmaIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_child_cannot_be_removed_through_another_class(): void
    {
        [$user, $child] = $this->eligibleChild();
        $originalClass = Turma::create(['nome' => 'Turma A', 'capacidade' => 10, 'ativa' => true]);
        $otherClass = Turma::create(['nome' => 'Turma B', 'capacidade' => 10, 'ativa' => true]);
        $child->update(['turma_id' => $originalClass->id, 'status' => 'EM_TURMA']);

        $this->actingAs($user)
            ->post(route('turmas.remover-crianca', $otherClass->id), ['crianca_id' => $child->id])
            ->assertNotFound();

        $this->assertSame($originalClass->id, $child->fresh()->turma_id);
        $this->assertSame('EM_TURMA', $child->fresh()->status);
    }

    public function test_child_already_in_a_class_cannot_be_reallocated(): void
    {
        [$user, $child] = $this->eligibleChild();
        $originalClass = Turma::create(['nome' => 'Turma A', 'capacidade' => 10, 'ativa' => true]);
        $otherClass = Turma::create(['nome' => 'Turma B', 'capacidade' => 10, 'ativa' => true]);
        $child->update(['turma_id' => $originalClass->id]);

        $this->actingAs($user)
            ->post(route('turmas.alocar', $otherClass->id), ['crianca_id' => $child->id])
            ->assertSessionHas('error');

        $this->assertSame($originalClass->id, $child->fresh()->turma_id);
    }

    public function test_child_cannot_be_allocated_to_inactive_class(): void
    {
        [$user, $child] = $this->eligibleChild();
        $class = Turma::create(['nome' => 'Turma inativa', 'capacidade' => 10, 'ativa' => false]);

        $this->actingAs($user)
            ->post(route('turmas.alocar', $class->id), ['crianca_id' => $child->id])
            ->assertSessionHas('error');

        $this->assertNull($child->fresh()->turma_id);
    }

    public function test_class_with_children_cannot_be_deleted(): void
    {
        [$user, $child] = $this->eligibleChild();
        $class = Turma::create(['nome' => 'Turma A', 'capacidade' => 10, 'ativa' => true]);
        $child->update(['turma_id' => $class->id, 'status' => 'EM_TURMA']);

        $this->actingAs($user)
            ->delete(route('turmas.destroy', $class->id))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('turmas', ['id' => $class->id]);
    }

    private function eligibleChild(): array
    {
        $user = User::factory()->create(['role' => 'matricula', 'ativo' => true]);
        $guardian = Responsavel::create([
            'nome' => 'Responsável',
            'email' => fake()->unique()->safeEmail(),
            'telefone' => '11999999999',
        ]);
        $child = Crianca::create([
            'responsavel_id' => $guardian->id,
            'nome' => 'Criança',
            'data_nascimento' => '2018-01-01',
            'idade' => 8,
            'status' => 'ANAMNESE_CONCLUIDA',
        ]);

        return [$user, $child];
    }
}
