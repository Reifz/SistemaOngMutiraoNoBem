<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crianca_id');
            $table->unsignedBigInteger('ano_letivo_id');
            $table->unsignedBigInteger('turma_id')->nullable();
            
            // Dados escolares do ano
            $table->string('escola')->nullable();
            $table->string('tipo_escola', 50)->nullable();
            $table->string('serie', 100)->nullable();
            $table->string('periodo_escolar', 50)->nullable();
            $table->string('periodo_ong', 50)->nullable();
            
            // Status e Datas
            $table->string('status', 50)->default('PENDENTE_REMATRICULA_MATRICULA');
            $table->date('data_matricula')->nullable();
            
            // Campos de Evasão/Desligamento (Histórico)
            $table->date('data_evasao')->nullable();
            $table->string('motivo_evasao', 255)->nullable();
            $table->text('observacao_evasao')->nullable();
            $table->date('data_desligamento')->nullable();
            $table->text('motivo_desligamento')->nullable();

            $table->timestamps();

            // Relacionamentos
            $table->foreign('crianca_id')->references('id')->on('criancas')->onDelete('cascade');
            $table->foreign('ano_letivo_id')->references('id')->on('anos_letivos')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
