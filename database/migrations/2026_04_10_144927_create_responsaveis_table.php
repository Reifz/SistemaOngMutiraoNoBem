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
        Schema::create('responsaveis', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone');
            $table->string('telefone_secundario')->nullable();
            $table->string('acesso_local', 50)->nullable();
            $table->string('parentesco', 50)->nullable();
            $table->string('estado_civil', 50)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->integer('idade')->nullable();
            $table->string('grau_instrucao')->nullable();
            $table->string('cpf', 20)->nullable();
            $table->string('rg', 20)->nullable();
            $table->boolean('tem_cadastro_unico')->default(false);
            $table->boolean('recebe_transferencia_renda')->default(false);
            $table->boolean('recebe_bpc')->default(false);
            $table->string('profissao')->nullable();
            $table->boolean('desempregado')->default(false);
            
            // LGPD: Registro de consentimento explícito
            $table->boolean('consentimento_lgpd')->default(false);
            $table->timestamp('data_consentimento')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsaveis');
    }
};
