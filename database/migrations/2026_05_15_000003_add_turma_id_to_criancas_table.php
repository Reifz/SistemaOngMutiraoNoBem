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
            if (!Schema::hasColumn('criancas', 'turma_id')) {
                $table->unsignedBigInteger('turma_id')->nullable()->after('responsavel_id');
                // Adicionando a FK para turmas
                // Nota: se turmas.id for INT em vez de BIGINT, ajuste aqui.
                // Na migration original era $table->id() que é BIGINT.
                $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criancas', function (Blueprint $table) {
            $table->dropForeign(['turma_id']);
            $table->dropColumn('turma_id');
        });
    }
};
