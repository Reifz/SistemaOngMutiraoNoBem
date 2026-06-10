<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Crianca;
use App\Models\AnoLetivo;
use App\Models\Matricula;

class ViradaAnoLetivoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:virada-ano-letivo {--force : Executa a virada mesmo que não seja a data configurada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Incrementa automaticamente a série escolar e cria as novas matrículas na virada do ano.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = now()->toDateString();
        $anoParaVirada = AnoLetivo::where('data_virada', $hoje)->first();

        if (!$anoParaVirada && !$this->option('force')) {
            $this->warn("Hoje ($hoje) não há nenhum Ano Letivo configurado para virada.");
            $this->info("Configure a data de virada na tela de Gestão de Períodos.");
            return;
        }

        if (!$anoParaVirada && $this->option('force')) {
            $proximoAnoNum = now()->year + 1;
            $anoParaVirada = AnoLetivo::where('ano', $proximoAnoNum)->first();
            
            if (!$anoParaVirada) {
                $this->error("Nenhum Ano Letivo futuro encontrado para forçar a virada.");
                return;
            }
        }

        $this->info("Executando virada para o Ano Letivo: " . $anoParaVirada->ano);

        $mapping = [
            'Pré' => '1º ano',
            '1º ano' => '2º ano',
            '2º ano' => '3º ano',
            '3º ano' => '4º ano',
            '4º ano' => '5º ano',
            '5º ano' => '6º ano',
            '6º ano' => '7º ano',
            '7º ano' => '8º ano',
            '8º ano' => '9º ano',
            '9º ano' => '1º ano EM',
            '1º ano EM' => '2º ano EM',
            '2º ano EM' => '3º ano EM',
            '1º Ano' => '2º ano',
            '2º Ano' => '3º ano',
            '3º Ano' => '4º ano',
            '4º Ano' => '5º ano',
            '5º Ano' => '6º ano',
            '6º Ano' => '7º ano',
        ];

        $anoAnteriorNum = $anoParaVirada->ano - 1;
        $anoAnterior = AnoLetivo::where('ano', $anoAnteriorNum)->first();

        $query = Crianca::query();
        if ($anoAnterior) {
            $query->whereHas('matriculas', function($q) use ($anoAnterior) {
                $q->where('ano_letivo_id', $anoAnterior->id)
                  ->whereNotIn('status', ['EVADIDA', 'REJEITADA', 'DESLIGADA']);
            });
        }

        $criancas = $query->get();
        $total = 0;

        foreach ($criancas as $crianca) {
            $ultimaMat = $crianca->matriculas()->orderBy('id', 'desc')->first();
            $jaTem = Matricula::where('crianca_id', $crianca->id)
                ->where('ano_letivo_id', $anoParaVirada->id)
                ->exists();

            if (!$jaTem) {
                $novaSerie = ($ultimaMat && isset($mapping[$ultimaMat->serie])) 
                    ? $mapping[$ultimaMat->serie] 
                    : ($crianca->serie ? ($mapping[$crianca->serie] ?? $crianca->serie) : null);

                Matricula::create([
                    'crianca_id' => $crianca->id,
                    'ano_letivo_id' => $anoParaVirada->id,
                    'turma_id' => null,
                    'escola' => $ultimaMat ? $ultimaMat->escola : $crianca->escola,
                    'tipo_escola' => $ultimaMat ? $ultimaMat->tipo_escola : $crianca->tipo_escola,
                    'serie' => $novaSerie,
                    'periodo_escolar' => $ultimaMat ? $ultimaMat->periodo_escolar : $crianca->periodo_escolar,
                    'periodo_ong' => $ultimaMat ? $ultimaMat->periodo_ong : $crianca->periodo_ong,
                    'status' => 'PENDENTE_REMATRICULA_MATRICULA',
                ]);

                $this->line("Criança #{$crianca->id} ({$crianca->nome}): Matriculada para {$anoParaVirada->ano} na série {$novaSerie}");
                $total++;
            }
        }

        // Ativa o ano da virada e sincroniza
        $this->call('app:set-active-year', ['id' => $anoParaVirada->id]);

        $this->info("Sucesso! {$total} crianças foram migradas para o ciclo {$anoParaVirada->ano}.");
    }
}
