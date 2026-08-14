<?php

namespace Tests\Feature;

use App\Models\AnoLetivo;
use App\Models\User;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EmptyDataPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_relatorio_renders_without_children_and_grouped_queries_have_no_inherited_date_order(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'ativo' => true]);
        $queries = [];

        DB::listen(function (QueryExecuted $query) use (&$queries): void {
            $queries[] = strtolower($query->sql);
        });

        $this->actingAs($admin)
            ->get(route('relatorios.evasao'))
            ->assertOk()
            ->assertSee('Nenhuma evasão registrada');

        $groupedQueries = collect($queries)
            ->filter(fn (string $sql): bool => str_contains($sql, 'group by') && str_contains($sql, 'motivo_evasao'));

        $this->assertNotEmpty($groupedQueries);
        $this->assertFalse(
            $groupedQueries->contains(fn (string $sql): bool => str_contains($sql, 'order by "data_evasao"')),
            'A ordenação da listagem não deve contaminar as consultas agrupadas.'
        );
    }

    public function test_rematricula_renders_when_active_year_has_no_transition_date(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'ativo' => true]);
        $anoAtual = AnoLetivo::where('ano', 2026)->firstOrFail();

        $this->assertNull($anoAtual->data_virada);

        $this->actingAs($admin)
            ->get(route('rematricula.index'))
            ->assertOk()
            ->assertSee('Data de virada não configurada');
    }

    public function test_empty_evasion_report_can_be_exported_as_pdf(): void
    {
        $this->withoutExceptionHandling();
        $admin = User::factory()->create(['role' => 'admin', 'ativo' => true]);

        $this->actingAs($admin)
            ->get(route('relatorios.evasao.pdf'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_authorized_user_can_update_transition_date(): void
    {
        $user = User::factory()->create(['role' => 'matricula', 'ativo' => true]);
        $anoAtual = AnoLetivo::where('ano', 2026)->firstOrFail();

        $this->actingAs($user)
            ->from(route('rematricula.anos.index'))
            ->patch(route('rematricula.ano.update', $anoAtual), [
                'data_virada' => '2026-12-01',
            ])
            ->assertRedirect(route('rematricula.anos.index'))
            ->assertSessionHas('success');

        $this->assertSame('2026-12-01', $anoAtual->fresh()->data_virada?->toDateString());
    }
}
