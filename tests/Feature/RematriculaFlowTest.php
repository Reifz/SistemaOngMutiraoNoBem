<?php

namespace Tests\Feature;

use App\Models\AnoLetivo;
use App\Models\Crianca;
use App\Models\Matricula;
use App\Models\Responsavel;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RematriculaFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_start_rematricula_for_next_school_year(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $responsavel = Responsavel::create([
            'nome' => 'Maria Silva',
            'email' => 'maria@example.com',
            'telefone' => '11999999999',
            'consentimento_lgpd' => true,
            'data_consentimento' => now(),
            'acesso_local' => 'Facil',
        ]);
        $turma = Turma::create([
            'nome' => 'Turma 2026 A',
            'turno' => 'Tarde',
            'capacidade' => 20,
            'ativa' => true,
        ]);
        $anoAtual = AnoLetivo::where('ano', 2026)->firstOrFail();
        $anoAtual->update([
            'data_virada' => '2027-01-01',
            'status_ativo' => true,
        ]);
        $anoDestino = AnoLetivo::create([
            'ano' => 2027,
            'data_virada' => '2027-01-01',
            'status_ativo' => false,
        ]);
        $crianca = Crianca::create([
            'responsavel_id' => $responsavel->id,
            'turma_id' => $turma->id,
            'nome' => 'Joao Silva',
            'data_nascimento' => '2018-05-10',
            'idade' => 8,
            'escola' => 'Escola Atual',
            'tipo_escola' => 'Publica',
            'serie' => '3 Ano',
            'periodo_escolar' => 'Manha',
            'periodo_ong' => 'Tarde',
            'data_inscricao' => '2026-01-10',
            'status' => 'EM_TURMA',
        ]);

        Matricula::create([
            'crianca_id' => $crianca->id,
            'ano_letivo_id' => $anoAtual->id,
            'turma_id' => $turma->id,
            'escola' => 'Escola Atual',
            'tipo_escola' => 'Publica',
            'serie' => '3 Ano',
            'periodo_escolar' => 'Manha',
            'periodo_ong' => 'Tarde',
            'status' => 'EM_TURMA',
            'data_matricula' => '2026-02-01',
        ]);

        $response = $this
            ->actingAs($admin)
            ->from(route('rematricula.index'))
            ->post(route('rematricula.iniciar', $crianca->id), [
                'ano_letivo_id' => $anoDestino->id,
            ]);

        $response->assertRedirect(route('rematricula.index'));

        $novaMatricula = Matricula::where('crianca_id', $crianca->id)
            ->where('ano_letivo_id', $anoDestino->id)
            ->firstOrFail();

        $this->assertNull($novaMatricula->turma_id);
        $this->assertSame('Escola Atual', $novaMatricula->escola);
        $this->assertSame('3 Ano', $novaMatricula->serie);
        $this->assertSame('PENDENTE_REMATRICULA_MATRICULA', $novaMatricula->status);
        $this->assertDatabaseHas('logs_auditoria', [
            'registro_id' => $crianca->id,
            'tabela_afetada' => 'criancas',
        ]);
    }

    public function test_admin_cannot_start_duplicate_rematricula_for_same_year(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $responsavel = Responsavel::create([
            'nome' => 'Maria Silva',
            'email' => 'maria@example.com',
            'telefone' => '11999999999',
        ]);
        $anoDestino = AnoLetivo::create([
            'ano' => 2027,
            'data_virada' => '2027-01-01',
            'status_ativo' => true,
        ]);
        $crianca = Crianca::create([
            'responsavel_id' => $responsavel->id,
            'nome' => 'Joao Silva',
            'data_nascimento' => '2018-05-10',
            'status' => 'EM_TURMA',
        ]);

        Matricula::create([
            'crianca_id' => $crianca->id,
            'ano_letivo_id' => $anoDestino->id,
            'status' => 'PENDENTE_REMATRICULA_MATRICULA',
        ]);

        $response = $this
            ->actingAs($admin)
            ->from(route('rematricula.index'))
            ->post(route('rematricula.iniciar', $crianca->id), [
                'ano_letivo_id' => $anoDestino->id,
            ]);

        $response
            ->assertRedirect(route('rematricula.index'))
            ->assertSessionHas('error');

        $this->assertSame(
            1,
            Matricula::where('crianca_id', $crianca->id)
                ->where('ano_letivo_id', $anoDestino->id)
                ->count()
        );
    }

    public function test_complete_rematricula_flow_until_new_turma_allocation(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $responsavel = Responsavel::create([
            'nome' => 'Maria Silva',
            'email' => 'maria@example.com',
            'telefone' => '11999999999',
            'consentimento_lgpd' => true,
            'data_consentimento' => now(),
            'acesso_local' => 'Facil',
        ]);
        $turmaAnterior = Turma::create([
            'nome' => 'Turma 2026 A',
            'turno' => 'Tarde',
            'capacidade' => 20,
            'ativa' => true,
        ]);
        $anoAtual = AnoLetivo::where('ano', 2026)->firstOrFail();
        $anoAtual->update([
            'data_virada' => '2027-01-01',
            'status_ativo' => true,
        ]);
        $anoDestino = AnoLetivo::create([
            'ano' => 2027,
            'data_virada' => '2027-01-01',
            'status_ativo' => false,
        ]);
        $crianca = Crianca::create([
            'responsavel_id' => $responsavel->id,
            'turma_id' => $turmaAnterior->id,
            'nome' => 'Joao Silva',
            'data_nascimento' => '2018-05-10',
            'idade' => 8,
            'sexo' => 'Masculino',
            'cor_raca' => 'Parda',
            'escola' => 'Escola Atual',
            'tipo_escola' => 'Publica',
            'serie' => '3 Ano',
            'periodo_escolar' => 'Manha',
            'periodo_ong' => 'Tarde',
            'data_inscricao' => '2026-01-10',
            'status' => 'EM_TURMA',
        ]);

        Matricula::create([
            'crianca_id' => $crianca->id,
            'ano_letivo_id' => $anoAtual->id,
            'turma_id' => $turmaAnterior->id,
            'escola' => 'Escola Atual',
            'tipo_escola' => 'Publica',
            'serie' => '3 Ano',
            'periodo_escolar' => 'Manha',
            'periodo_ong' => 'Tarde',
            'status' => 'EM_TURMA',
            'data_matricula' => '2026-02-01',
        ]);

        $this->actingAs($admin)
            ->from(route('rematricula.index'))
            ->post(route('rematricula.iniciar', $crianca->id), [
                'ano_letivo_id' => $anoDestino->id,
            ])
            ->assertRedirect(route('rematricula.index'));

        $this->actingAs($admin)
            ->from(route('rematricula.anos.index'))
            ->post(route('rematricula.ano.ativar', $anoDestino->id))
            ->assertRedirect(route('rematricula.anos.index'));

        $crianca->refresh();
        $this->assertSame('PENDENTE_REMATRICULA_MATRICULA', $crianca->status);
        $this->assertNull($crianca->turma_id);

        $this->actingAs($admin)
            ->get(route('matricula.formulario', $crianca->id))
            ->assertOk();

        $file = UploadedFile::fake()->create('document.pdf', 100);
        $matriculaData = [
            'crianca_nome' => 'Joao Silva',
            'crianca_idade' => 9,
            'crianca_sexo' => 'Masculino',
            'crianca_cor_raca' => 'Parda',
            'crianca_data_nascimento' => '2018-05-10',
            'crianca_data_inscricao' => '2026-01-10',
            'crianca_data_matricula' => '2027-02-01',
            'crianca_esta_na_escola' => '1',
            'crianca_escola' => 'Escola Atualizada',
            'crianca_tipo_escola' => 'Publica',
            'crianca_serie' => '4 Ano',
            'crianca_periodo_escolar' => 'Manha',
            'crianca_certidao_nascimento' => '123456',
            'responsavel_nome' => 'Maria Silva',
            'responsavel_parentesco' => 'MAE',
            'responsavel_estado_civil' => 'Solteira',
            'responsavel_data_nascimento' => '1990-01-01',
            'responsavel_idade' => 37,
            'responsavel_grau_instrucao' => 'Ensino Medio',
            'responsavel_cpf' => '12345678901',
            'responsavel_rg' => '12345678',
            'contato_celular' => '11999999999',
            'moradia_endereco' => 'Rua Teste, 123',
            'moradia_bairro' => 'Centro',
            'moradia_cep' => '01001000',
            'moradia_situacao_habitacional' => 'Alugada',
            'moradia_numero_comodos' => 3,
            'moradia_numero_moradores' => 2,
            'moradia_condicao_moradia' => 'Alvenaria',
            'anexo_rg_responsavel' => $file,
            'anexo_certidao' => $file,
        ];

        $this->actingAs($admin)
            ->post(route('matricula.store', $crianca->id), $matriculaData)
            ->assertRedirect(route('matricula.index'));

        $crianca->refresh();
        $this->assertSame('PENDENTE_REMATRICULA_APROVACAO', $crianca->status);

        $this->actingAs($admin)
            ->post(route('matricula.aprovar', $crianca->id), [
                'detalhes' => 'Rematricula conferida e aprovada',
            ])
            ->assertRedirect(route('matricula.show', $crianca->id));

        $crianca->refresh();
        $this->assertSame('PENDENTE_REMATRICULA_ANAMNESE', $crianca->status);

        $this->actingAs($admin)
            ->post(route('anamnese.store', $crianca->id), [
                'historico_doencas' => 'Sem alteracoes',
            ])
            ->assertRedirect(route('anamnese.index'));

        $crianca->refresh();
        $this->assertSame('REMATRICULADA', $crianca->status);

        $novaTurma = Turma::create([
            'nome' => 'Turma 2027 A',
            'turno' => 'Tarde',
            'capacidade' => 20,
            'ativa' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('turmas.show', $novaTurma->id))
            ->assertOk()
            ->assertSee('Joao Silva');

        $this->actingAs($admin)
            ->post(route('turmas.alocar', $novaTurma->id), [
                'crianca_id' => $crianca->id,
            ])
            ->assertRedirect();

        $crianca->refresh();
        $this->assertSame('EM_TURMA', $crianca->status);
        $this->assertSame($novaTurma->id, $crianca->turma_id);

        $matriculaAtual = Matricula::where('crianca_id', $crianca->id)
            ->where('ano_letivo_id', $anoDestino->id)
            ->firstOrFail();

        $this->assertSame('EM_TURMA', $matriculaAtual->status);
        $this->assertSame($novaTurma->id, $matriculaAtual->turma_id);
        $this->assertSame('4 Ano', $matriculaAtual->serie);
    }
}
