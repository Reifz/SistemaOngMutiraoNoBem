<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('criancas', function (Blueprint $table) {
            if (!Schema::hasColumn('criancas', 'anexo_rg')) {
                $table->string('anexo_rg')->nullable()->after('rg');
            }
            if (!Schema::hasColumn('criancas', 'anexo_cpf')) {
                $table->string('anexo_cpf')->nullable()->after('cpf');
            }
            if (!Schema::hasColumn('criancas', 'anexo_comprovante_residencia')) {
                $table->string('anexo_comprovante_residencia')->nullable()->after('anexo_excel_matricula');
            }
            if (!Schema::hasColumn('criancas', 'anexo_comprovante_escolaridade')) {
                $table->string('anexo_comprovante_escolaridade')->nullable()->after('anexo_comprovante_residencia');
            }
            if (!Schema::hasColumn('criancas', 'anexo_comprovante_renda')) {
                $table->string('anexo_comprovante_renda')->nullable()->after('anexo_comprovante_escolaridade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criancas', function (Blueprint $table) {
            $table->dropColumn([
                'anexo_rg',
                'anexo_cpf',
                'anexo_comprovante_residencia',
                'anexo_comprovante_escolaridade',
                'anexo_comprovante_renda'
            ]);
        });
    }
};
