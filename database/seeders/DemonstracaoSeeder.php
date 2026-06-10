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
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DemonstracaoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpar dados existentes
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Crianca::truncate();
        Responsavel::truncate();
        Turma::truncate();
        AnoLetivo::truncate();
        Moradia::truncate();
        Familiar::truncate();
        Anamnese::truncate();
        Matricula::truncate();
        Inscricao::truncate();
        LogAuditoria::truncate(); // Limpar logs antigos para reconstruir
        DB::table('crianca_responsavel')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;

        // 2. Ano Letivo Ativo
        $anoAtual = AnoLetivo::create([
            'ano' => 2026,
            'data_virada' => Carbon::parse('2026-01-01'),
            'status_ativo' => true
        ]);

        // 3. Turmas
        $turmaManha = Turma::create([
            'nome' => 'Turma A - Manhã',
            'turno' => 'Manhã',
            'idade_minima' => 6,
            'idade_maxima' => 10,
            'capacidade' => 20,
            'ativa' => true,
            'descricao' => 'Turma de alfabetização e reforço escolar (Manhã)'
        ]);

        $turmaTarde = Turma::create([
            'nome' => 'Turma B - Tarde',
            'turno' => 'Tarde',
            'idade_minima' => 6,
            'idade_maxima' => 10,
            'capacidade' => 20,
            'ativa' => true,
            'descricao' => 'Turma de artes e esportes (Tarde)'
        ]);

        // 4. Inserção de dados estratégicos

        // ANIVERSARIANTES DE HOJE
        $this->criarCenario($anoAtual, 'João Aniversariante', 'PREENCHER', $adminId, false, false, null, false, true);
        $this->criarCenario($anoAtual, 'Maria Festa', 'EM_TURMA', $adminId, true, true, $turmaTarde, false, true);

        // ALERTAS DE TRIAGEM (Atrasados > 7 dias)
        $this->criarCenario($anoAtual, 'Pedro Atrasado', 'PREENCHER', $adminId, false, false, null, false, false, true);
        $this->criarCenario($anoAtual, 'Ana Pendente Antiga', 'PREENCHER', $adminId, false, false, null, false, false, true);

        // AGUARDANDO ANAMNESE (Status: APROVADA)
        $this->criarCenario($anoAtual, 'Lucas Esperando Saude', 'APROVADA', $adminId, true);
        $this->criarCenario($anoAtual, 'Carla Pronta Anamnese', 'APROVADA', $adminId, true);

        // EVADIDAS POR TURNO (Para o Relatório de Evasão)
        $this->criarCenario($anoAtual, 'Gabriel Evadido Manhã', 'EVADIDA', $adminId, true, true, $turmaManha, true, false, false, 'Manhã');
        $this->criarCenario($anoAtual, 'Beatriz Evadida Tarde', 'EVADIDA', $adminId, true, true, $turmaTarde, true, false, false, 'Tarde');

        // REGISTRO MANUEL FERRAZ (Caso Real)
        $this->criarCenario($anoAtual, 'Manuel Ferraz', 'PENDENTE_APROVACAO', $adminId, true, false, null, false, false, false, 'Tarde', 'manhã');

        // OUTROS STATUS PARA COMPLETAR O FLUXO
        $this->criarCenario($anoAtual, 'Enzo Gabriel', 'PENDENTE_MATRICULA', $adminId);
        $this->criarCenario($anoAtual, 'Valentina Rosa', 'PENDENTE_APROVACAO', $adminId, true);
        $this->criarCenario($anoAtual, 'Thiago Rocha', 'ANAMNESE_CONCLUIDA', $adminId, true, true);
        $this->criarCenario($anoAtual, 'Camila Meireles', 'TURMA_PENDENTE', $adminId, true, true);
        $this->criarCenario($anoAtual, 'Mateus Henrique', 'EM_TURMA', $adminId, true, true, $turmaManha);
    }

    private function criarCenario($anoLetivo, $nomeCrianca, $status, $adminId, $comDetalhes = false, $comAnamnese = false, $turma = null, $evadida = false, $aniversarioHoje = false, $atrasada = false, $forcePeriodoOng = null, $forcePeriodoEscolar = null)
    {
        $responsavel = Responsavel::create([
            'nome' => "Responsável de $nomeCrianca",
            'email' => strtolower(str_replace(' ', '.', $nomeCrianca)) . "@email.com",
            'telefone' => '(11) 9' . rand(1000, 9999) . '-' . rand(1000, 9999),
            'cpf' => rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(10, 99),
            'consentimento_lgpd' => true,
            'data_consentimento' => now(),
            'parentesco' => 'MAE'
        ]);

        $nascimento = $aniversarioHoje 
            ? Carbon::now()->subYears(rand(7, 9)) 
            : Carbon::now()->subYears(rand(7, 9))->subDays(rand(10, 300));

        $createdAt = $atrasada ? now()->subDays(rand(8, 15)) : now()->subDays(rand(1, 5));

        $periodoEscolar = $forcePeriodoEscolar ?? (rand(0, 1) ? 'Manhã' : 'Tarde');
        $periodoOng = $forcePeriodoOng ?? ($periodoEscolar == 'Manhã' ? 'Tarde' : 'Manhã');

        $crianca = Crianca::create([
            'responsavel_id' => $responsavel->id,
            'nome' => $nomeCrianca,
            'data_nascimento' => $nascimento,
            'status' => $status,
            'sexo' => rand(0, 1) ? 'Masculino' : 'Feminino',
            'data_inscricao' => $createdAt->toDateString(),
            'periodo_escolar' => $periodoEscolar,
            'periodo_ong' => $periodoOng,
            'created_at' => $createdAt,
            'escola' => 'Escola Municipal de Teste',
            'serie' => '3º Ano',
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
            'periodo_escolar' => $periodoEscolar,
            'periodo_ong' => $periodoOng,
            'escola' => $crianca->escola,
            'serie' => $crianca->serie,
            'created_at' => $createdAt
        ]);

        // LOG: PRÉ-INSCRIÇÃO
        LogAuditoria::create([
            'usuario_id' => null, // Pré-inscrição é pública
            'acao' => 'Pré-inscrição: Recebida pelo sistema',
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Criança {$nomeCrianca} cadastrada via formulário público.",
            'data_hora' => $createdAt,
        ]);

        // SE AVANÇOU DA TRIAGEM
        if ($status != 'PREENCHER') {
            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => 'Triagem: Aprovada',
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Criança aprovada na triagem inicial. Aguardando preenchimento de matrícula.",
                'data_hora' => $createdAt->copy()->addHours(2),
            ]);
        }

        if ($comDetalhes || in_array($status, ['PENDENTE_APROVACAO', 'APROVADA', 'ANAMNESE', 'ANAMNESE_CONCLUIDA', 'TURMA_PENDENTE', 'EM_TURMA', 'EVADIDA'])) {
            Moradia::create([
                'crianca_id' => $crianca->id,
                'endereco' => 'Rua das Flores, ' . rand(1, 500),
                'bairro' => 'Centro',
                'cep' => '01234-567',
                'situacao_habitacional' => 'Alugada',
                'numero_comodos' => 4,
                'numero_moradores' => 3
            ]);

            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => 'Matrícula: Dados preenchidos',
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Todos os módulos de matrícula (Socioeconômico, Moradia, Família) foram preenchidos.",
                'data_hora' => $createdAt->copy()->addDays(1),
            ]);
        }

        if (in_array($status, ['APROVADA', 'ANAMNESE', 'ANAMNESE_CONCLUIDA', 'TURMA_PENDENTE', 'EM_TURMA', 'EVADIDA'])) {
            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => 'Matrícula: Aprovada',
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Documentação e dados de matrícula revisados e aprovados.",
                'data_hora' => $createdAt->copy()->addDays(1)->addHours(4),
            ]);
        }

        if ($comAnamnese || in_array($status, ['ANAMNESE_CONCLUIDA', 'TURMA_PENDENTE', 'EM_TURMA', 'EVADIDA'])) {
            Anamnese::create([
                'crianca_id' => $crianca->id,
                'ano_letivo_id' => $anoLetivo->id,
                'dados_json' => ['info' => 'Dados de saúde para demonstração']
            ]);

            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => 'Saúde: Anamnese preenchida',
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Informações de saúde e histórico familiar registrados.",
                'data_hora' => $createdAt->copy()->addDays(2),
            ]);
        }

        if (in_array($status, ['EM_TURMA', 'EVADIDA']) && $turma) {
            $matricula->turma_id = $turma->id;
            $matricula->save();
            $crianca->turma_id = $turma->id;
            $crianca->save();

            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => 'Turma: Alocação realizada',
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Criança alocada na turma: {$turma->nome}.",
                'data_hora' => $createdAt->copy()->addDays(3),
            ]);
        }

        if ($evadida) {
            $dataEvasao = now()->subDays(rand(1, 2));
            $matricula->status = 'EVADIDA';
            $matricula->data_evasao = $dataEvasao;
            $matricula->motivo_evasao = 'Mudança de endereço';
            $matricula->save();

            $crianca->status = 'EVADIDA';
            $crianca->data_evasao = $dataEvasao;
            $crianca->motivo_evasao = 'Mudança de endereço';
            $crianca->save();

            LogAuditoria::create([
                'usuario_id' => $adminId,
                'acao' => 'Evasão: Registro de saída',
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Criança evadida. Motivo: Mudança de endereço.",
                'data_hora' => $dataEvasao,
            ]);
        }
    }
}
