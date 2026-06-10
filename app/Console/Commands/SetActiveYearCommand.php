<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AnoLetivo;
use App\Models\Matricula;
use Illuminate\Support\Facades\DB;

class SetActiveYearCommand extends Command
{
    protected $signature = 'app:set-active-year {id : O ID do Ano Letivo para ativar}';
    protected $description = 'Define um ano letivo como ativo e sincroniza os dados na tabela de crianças.';

    public function handle()
    {
        $id = $this->argument('id');
        $ano = AnoLetivo::find($id);

        if (!$ano) {
            $this->error("Ano Letivo com ID #{$id} não encontrado.");
            return 1;
        }

        DB::beginTransaction();
        try {
            // Desativa todos
            AnoLetivo::where('status_ativo', true)->update(['status_ativo' => false]);
            
            // Ativa o selecionado
            $ano->status_ativo = true;
            $ano->save();

            // Sincronização Global
            $this->info("Sincronizando dados para o ano " . $ano->ano . "...");
            
            $matriculasDoAno = Matricula::where('ano_letivo_id', $ano->id)->get();
            
            foreach ($matriculasDoAno as $mat) {
                DB::table('criancas')->where('id', $mat->crianca_id)->update([
                    'status' => $mat->status,
                    'turma_id' => $mat->turma_id,
                    'escola' => $mat->escola,
                    'tipo_escola' => $mat->tipo_escola,
                    'serie' => $mat->serie,
                    'periodo_escolar' => $mat->periodo_escolar,
                    'periodo_ong' => $mat->periodo_ong,
                    'data_matricula' => $mat->data_matricula,
                    'data_evasao' => $mat->data_evasao,
                    'motivo_evasao' => $mat->motivo_evasao,
                    'observacao_evasao' => $mat->observacao_evasao,
                ]);
            }

            // Resetar crianças sem matrícula no ano ativo
            $idsComMatricula = $matriculasDoAno->pluck('crianca_id')->toArray();
            DB::table('criancas')->whereNotIn('id', $idsComMatricula)->update([
                'status' => 'PENDENTE_REMATRICULA_MATRICULA',
                'turma_id' => null
            ]);

            DB::commit();
            $this->info("Sucesso! Ano letivo {$ano->ano} agora é o ATIVO.");
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Erro na sincronização: " . $e->getMessage());
            return 1;
        }
    }
}
