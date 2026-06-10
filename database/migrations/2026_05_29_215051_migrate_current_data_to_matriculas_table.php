<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Criar o ano letivo de 2026
        $anoId = DB::table('anos_letivos')->insertGetId([
            'ano' => 2026,
            'status_ativo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Buscar todas as crianças com seus dados atuais
        $criancas = DB::table('criancas')->get();

        foreach ($criancas as $crianca) {
            // 3. Criar a matrícula para 2026
            DB::table('matriculas')->insert([
                'crianca_id' => $crianca->id,
                'ano_letivo_id' => $anoId,
                'turma_id' => $crianca->turma_id,
                'escola' => $crianca->escola,
                'tipo_escola' => $crianca->tipo_escola,
                'serie' => $crianca->serie,
                'periodo_escolar' => $crianca->periodo_escolar,
                'periodo_ong' => $crianca->periodo_ong,
                'status' => $crianca->status,
                'data_matricula' => $crianca->data_matricula,
                'data_evasao' => $crianca->data_evasao,
                'motivo_evasao' => $crianca->motivo_evasao,
                'observacao_evasao' => $crianca->observacao_evasao,
                'data_desligamento' => $crianca->data_desligamento,
                'motivo_desligamento' => $crianca->motivo_desligamento,
                'created_at' => $crianca->created_at,
                'updated_at' => $crianca->updated_at,
            ]);

            // 4. Atualizar a anamnese se existir
            DB::table('anamnese')
                ->where('crianca_id', $crianca->id)
                ->update(['ano_letivo_id' => $anoId]);
        }
    }

    public function down(): void
    {
        // Para reverter, bastaria limpar as tabelas, mas como as tabelas serão dropadas 
        // nas migrações anteriores, não é estritamente necessário um rollback complexo aqui.
        DB::table('matriculas')->truncate();
        DB::table('anos_letivos')->truncate();
        DB::table('anamnese')->update(['ano_letivo_id' => null]);
    }
};
