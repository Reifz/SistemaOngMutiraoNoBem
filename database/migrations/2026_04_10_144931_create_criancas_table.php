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
        Schema::create('criancas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsavel_id')->constrained('responsaveis')->onDelete('cascade');
            $table->string('nome');
            $table->date('data_nascimento');
            $table->integer('idade')->nullable();
            $table->string('sexo', 20)->nullable();
            $table->string('cor_raca', 50)->nullable();
            $table->string('naturalidade')->nullable();
            $table->date('data_inscricao')->nullable();
            $table->date('data_matricula')->nullable();
            $table->date('data_desligamento')->nullable();
            $table->string('motivo_desligamento')->nullable();
            $table->boolean('esta_na_escola')->default(true);
            $table->string('escola')->nullable();
            $table->string('tipo_escola')->nullable();
            $table->string('serie')->nullable();
            $table->string('periodo_escolar')->nullable();
            $table->string('certidao_nascimento')->nullable();
            $table->string('certidao_folha')->nullable();
            $table->string('certidao_livro')->nullable();
            $table->string('cpf', 20)->nullable();
            $table->string('rg', 20)->nullable();
            $table->string('anexo_excel_matricula')->nullable();
            $table->boolean('possui_deficiencia')->default(false);
            
            // Status do fluxo: PREENCHER, APROVADA, ANAMNESE, AVALIACAO_FINAL, EM_TURMA, REJEITADA
            $table->string('status')->default('PREENCHER');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criancas');
    }
};
