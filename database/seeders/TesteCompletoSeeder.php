<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crianca;
use App\Models\Responsavel;
use App\Models\Turma;
use App\Models\AnoLetivo;
use App\Models\Moradia;
use App\Models\Familiar;
use App\Models\Anamnese;
use App\Models\Matricula;
use App\Models\Inscricao;
use App\Models\LogAuditoria;
use App\Models\Contato;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TesteCompletoSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $tabelas = [
            'criancas', 'responsaveis', 'crianca_responsavel', 'moradias', 
            'contatos', 'familiares', 'turmas', 'inscricoes', 
            'anamnese', 'logs_auditoria', 'mensagens', 'anos_letivos', 'matriculas'
        ];

        foreach ($tabelas as $tabela) {
            DB::table($tabela)->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminId = 2;

        $ano2025 = AnoLetivo::create([
            'ano' => 2025,
            'data_virada' => Carbon::parse('2025-01-01'),
            'status_ativo' => false
        ]);

        $ano2026 = AnoLetivo::create([
            'ano' => 2026,
            'data_virada' => Carbon::parse('2026-01-01'),
            'status_ativo' => true
        ]);

        $turmaManha = Turma::create([
            'nome' => 'Alfabetização I - Manhã',
            'capacidade' => 15,
            'ativa' => true,
        ]);

        $turmaTarde = Turma::create([
            'nome' => 'Reforço Escolar - Tarde',
            'capacidade' => 20,
            'ativa' => true,
        ]);


        
        $this->criarCriancaCompleta($ano2026, 'Gabriel Santos Pereira', 'PREENCHER', $adminId);
        $this->criarCriancaCompleta($ano2026, 'Mariana Oliveira Lima', 'PREENCHER', $adminId);
        $this->criarCriancaCompleta($ano2026, 'Thiago Rocha Neto', 'PREENCHER', $adminId, null, true); // Alerta triagem (>7 dias)

        $this->criarCriancaCompleta($ano2026, 'Lucas Henrique Rocha', 'PENDENTE_MATRICULA', $adminId);
        $this->criarCriancaCompleta($ano2026, 'Ana Beatriz silva', 'PENDENTE_MATRICULA', $adminId);

        $this->criarCriancaCompleta($ano2026, 'Enzo Gabriel Gomes', 'PENDENTE_APROVACAO', $adminId);

        $this->criarCriancaCompleta($ano2026, 'Isabella Ferreira', 'APROVADA', $adminId);

        $this->criarCriancaCompleta($ano2026, 'Rafael Souza Martins', 'ANAMNESE_CONCLUIDA', $adminId);

        $this->criarCriancaCompleta($ano2026, 'Pedro Augusto Almeida', 'EM_TURMA', $adminId, $turmaManha);
        $this->criarCriancaCompleta($ano2026, 'Sophia Regina Duarte', 'EM_TURMA', $adminId, $turmaTarde);

        $this->criarEvasao($ano2026, 'Beatriz silva Costa', 'Manhã', 'Mudança de Bairro', $adminId, $turmaManha);
        $this->criarEvasao($ano2026, 'Joaquim Silva Santos', 'Tarde', 'Inadaptação', $adminId, $turmaTarde);
        $this->criarEvasao($ano2026, 'Laura Oliveira Ramos', 'Manhã', 'Horário Escolar Conflitante', $adminId, $turmaManha);
        $this->criarEvasao($ano2026, 'Matheus Henrique Lima', 'Tarde', 'Trabalho do Responsável', $adminId, $turmaTarde);

        
        $this->criarVeteranoSemMatricula($ano2025, 'Vitor Hugo Mendes', $adminId, $turmaManha);
        $this->criarVeteranoSemMatricula($ano2025, 'Luiza Meirelles', $adminId, $turmaTarde);
        $this->criarVeteranoSemMatricula($ano2025, 'Rodrigo Ferreira dos Santos', $adminId, $turmaManha);

        $this->criarCriancaRematricula($ano2025, $ano2026, 'Catarina Maria Silva', 'PENDENTE_REMATRICULA_MATRICULA', $adminId);

        $this->criarCriancaRematricula($ano2025, $ano2026, 'Arthur Miguel Oliveira', 'PENDENTE_REMATRICULA_APROVACAO', $adminId);

        $this->criarCriancaRematricula($ano2025, $ano2026, 'Heloísa Helena Castro', 'PENDENTE_REMATRICULA_ANAMNESE', $adminId);

        $this->criarCriancaRematricula($ano2025, $ano2026, 'Benjamin Rocha', 'REMATRICULADA', $adminId);

        $this->criarCasoComplexo($ano2026, 'Manuel Ferraz (Caso Real)', 'APROVADA', $adminId);

        $this->criarAniversarianteHoje($ano2026, 'Juliana Festa de Aniversário', 'EM_TURMA', $adminId, $turmaManha);
    }

    private function criarAniversarianteHoje($anoLetivo, $nome, $status, $adminId, $turma)
    {
        $hoje = Carbon::now();
        $dataNascimento = Carbon::create($hoje->year - 8, $hoje->month, $hoje->day);
        
        $this->criarCriancaCompleta($anoLetivo, $nome, $status, $adminId, $turma);
        $crianca = Crianca::where('nome', $nome)->first();
        $crianca->update([
            'data_nascimento' => $dataNascimento,
            'idade' => 8
        ]);

        LogAuditoria::create([
            'usuario_id' => $adminId,
            'acao' => "Sistema: Aniversário Detectado",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Criança completando 8 anos hoje!",
            'data_hora' => now(),
        ]);
    }

    private function criarCriancaCompleta($anoLetivo, $nome, $status, $adminId, $turma = null, $atrasada = false)
    {
        $createdAt = $atrasada ? now()->subDays(rand(10, 15)) : now()->subDays(rand(1, 5));
        $dataNascimento = Carbon::now()->subYears(rand(6, 11))->subMonths(rand(1, 11));
        
        $responsavel = Responsavel::create([
            'nome' => "Responsável de " . explode(' ', $nome)[0],
            'email' => strtolower(str_replace(' ', '.', $nome)) . "@email.com",
            'telefone' => '(11) 9' . rand(7000, 9999) . '-' . rand(1000, 9999),
            'cpf' => rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(10, 99),
            'consentimento_lgpd' => true,
            'data_consentimento' => $createdAt,
            'parentesco' => 'MAE',
            'estado_civil' => 'Solteira',
            'data_nascimento' => '1988-02-10',
            'idade' => 38,
            'grau_instrucao' => 'Ensino Médio',
            'profissao' => 'Atendente',
            'desempregado' => false,
        ]);

        Contato::create(['responsavel_id' => $responsavel->id, 'tipo' => 'CELULAR', 'numero' => $responsavel->telefone]);
        Contato::create(['responsavel_id' => $responsavel->id, 'tipo' => 'RECADO', 'numero' => '(11) 98877-6655', 'pessoa_contato' => 'Vizinha Maria']);

        $crianca = Crianca::create([
            'responsavel_id' => $responsavel->id,
            'nome' => $nome,
            'data_nascimento' => $dataNascimento,
            'idade' => $dataNascimento->age,
            'sexo' => rand(0, 1) ? 'Masculino' : 'Feminino',
            'cor_raca' => 'Parda',
            'naturalidade' => 'São Paulo - SP',
            'data_inscricao' => $createdAt,
            'status' => $status,
            'escola' => 'Escola Municipal de Testes',
            'serie' => '4º Ano',
            'periodo_escolar' => 'Manhã',
            'periodo_ong' => 'Tarde',
            'esta_na_escola' => true,
            'turma_id' => $turma ? $turma->id : null,
            'created_at' => $createdAt,
            'cpf' => rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(10, 99),
            'rg' => rand(10, 99) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(0, 9),
            'certidao_nascimento' => 'Livre-1234',
        ]);

        $crianca->responsaveis()->attach($responsavel->id, ['parentesco' => 'MAE', 'principal' => true]);

        Inscricao::create([
            'crianca_id' => $crianca->id,
            'status' => $status,
            'consentimento_lgpd' => true,
            'data_criacao' => $createdAt
        ]);

        $matricula = Matricula::create([
            'crianca_id' => $crianca->id,
            'ano_letivo_id' => $anoLetivo->id,
            'status' => $status,
            'turma_id' => $crianca->turma_id,
            'escola' => $crianca->escola,
            'serie' => $crianca->serie,
            'periodo_escolar' => $crianca->periodo_escolar,
            'periodo_ong' => $crianca->periodo_ong,
            'created_at' => $createdAt
        ]);

        $this->criarLogsPadrao($crianca, $adminId, $status);

        if ($status !== 'PREENCHER') {
            Moradia::create([
                'crianca_id' => $crianca->id,
                'endereco' => 'Rua do Teste, ' . rand(1, 1000),
                'bairro' => 'Centro',
                'cep' => '01000-000',
                'situacao_habitacional' => 'Própria',
                'numero_comodos' => 4,
                'numero_moradores' => 3
            ]);

            Familiar::create([
                'crianca_id' => $crianca->id,
                'nome' => 'Irmão do ' . $nome,
                'grau_parentesco' => 'Irmão',
                'idade' => 5,
                'estuda' => true
            ]);
        }

        if (in_array($status, ['ANAMNESE_CONCLUIDA', 'EM_TURMA'])) {
            Anamnese::create([
                'crianca_id' => $crianca->id,
                'ano_letivo_id' => $anoLetivo->id,
                'dados_json' => ['saude' => 'Perfeita', 'alergias' => 'Nenhuma']
            ]);
        }
    }

    private function criarEvasao($anoLetivo, $nome, $periodo, $motivo, $adminId, $turma)
    {
        $this->criarCriancaCompleta($anoLetivo, $nome, 'EM_TURMA', $adminId, $turma);
        $crianca = Crianca::where('nome', $nome)->first();
        
        $dataEvasao = now()->subDays(rand(1, 10));
        $crianca->update([
            'status' => 'EVADIDA',
            'periodo_escolar' => $periodo, // Para bater com o RelatorioController que usa periodo_escolar
            'periodo_ong' => ($periodo == 'Manhã' ? 'Tarde' : 'Manhã'), 
            'data_evasao' => $dataEvasao,
            'motivo_evasao' => $motivo,
            'observacao_evasao' => "Desistência por $motivo registrada pelo responsável.",
            'turma_id' => null
        ]);

        $matricula = $crianca->matriculaAtual();
        if ($matricula) {
            $matricula->update([
                'status' => 'EVADIDA',
                'periodo_escolar' => $periodo,
                'periodo_ong' => ($periodo == 'Manhã' ? 'Tarde' : 'Manhã'),
                'data_evasao' => $dataEvasao,
                'motivo_evasao' => $motivo,
                'turma_id' => null
            ]);
        }

        LogAuditoria::create([
            'usuario_id' => $adminId,
            'acao' => "Evasão: Registro ($periodo)",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Criança desligada. Motivo: $motivo. Período: $periodo.",
            'data_hora' => $dataEvasao,
        ]);
    }

    private function criarVeteranoSemMatricula($anoAnterior, $nome, $adminId, $turma)
    {
        $this->criarCriancaCompleta($anoAnterior, $nome, 'EM_TURMA', $adminId, $turma);
        $crianca = Crianca::where('nome', $nome)->first();
        
        $crianca->update(['status' => 'EM_TURMA', 'turma_id' => null]); 
    }

    private function criarCriancaRematricula($anoAnterior, $anoAtual, $nome, $status, $adminId)
    {
        $this->criarCriancaCompleta($anoAnterior, $nome, 'EM_TURMA', $adminId);
        $crianca = Crianca::where('nome', $nome)->first();
        
        Matricula::create([
            'crianca_id' => $crianca->id,
            'ano_letivo_id' => $anoAtual->id,
            'status' => $status,
            'escola' => $crianca->escola,
            'serie' => '5º Ano', // Subiu de série
            'periodo_escolar' => $crianca->periodo_escolar,
            'periodo_ong' => $crianca->periodo_ong,
        ]);

        $crianca->update(['status' => $status]);

        LogAuditoria::create([
            'usuario_id' => $adminId,
            'acao' => "Rematrícula: Iniciada",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Ciclo anual {$anoAtual->ano} iniciado.",
            'data_hora' => now()->subDays(2),
        ]);
    }

    private function criarCasoComplexo($anoLetivo, $nome, $status, $adminId)
    {
        $this->criarCriancaCompleta($anoLetivo, $nome, $status, $adminId);
        $crianca = Crianca::where('nome', 'like', "%$nome%")->first();

        for ($i = 1; $i <= 5; $i++) {
            Familiar::create([
                'crianca_id' => $crianca->id,
                'nome' => "Familiar $i de " . $nome,
                'idade' => rand(10, 70),
                'grau_parentesco' => 'Outro',
                'renda' => rand(0, 1500),
                'fatores_risco' => 'Nenhum identificado no momento.'
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => "Ação Complexa $i",
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Registro de auditoria detalhado número $i para o caso complexo.",
                'data_hora' => now()->subHours($i),
            ]);
        }
    }

    private function criarLogsPadrao($crianca, $adminId, $status)
    {
        LogAuditoria::create([
            'usuario_id' => null,
            'acao' => 'Pré-inscrição: Recebida',
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Dados iniciais capturados pelo site.",
            'data_hora' => $crianca->created_at,
        ]);

        if ($status !== 'PREENCHER') {
            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => 'Triagem: Aprovada',
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Validado por Admin Multirão.",
                'data_hora' => $crianca->created_at->addHours(2),
            ]);
        }
    }
}
