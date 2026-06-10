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
        // Tabela Pivot: Criança e Seus Responsáveis (Mãe, Pai, etc)
        Schema::create('crianca_responsavel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crianca_id')->constrained('criancas')->onDelete('cascade');
            $table->foreignId('responsavel_id')->constrained('responsaveis')->onDelete('cascade');
            $table->string('parentesco')->nullable(); // MAE, PAI, etc
            $table->boolean('principal')->default(false);
            $table->timestamps();
        });

        // Tabela: Contatos Múltiplos
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsavel_id')->constrained('responsaveis')->onDelete('cascade');
            $table->string('tipo')->nullable(); // Celular, Trabalho, Recado
            $table->string('numero');
            $table->string('pessoa_contato')->nullable();
            $table->timestamps();
        });

        // Tabela: Familiares Residentes
        Schema::create('familiares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crianca_id')->constrained('criancas')->onDelete('cascade');
            $table->string('nome');
            $table->date('data_nascimento')->nullable();
            $table->integer('idade')->nullable();
            $table->string('grau_parentesco')->nullable();
            $table->string('grau_instrucao')->nullable();
            $table->boolean('estuda')->default(false);
            $table->boolean('inserido_cca')->default(false);
            $table->string('profissao')->nullable();
            $table->string('ocupacao')->nullable();
            $table->decimal('renda', 10, 2)->default(0);
            $table->text('fatores_risco')->nullable();
            $table->timestamps();
        });

        // Tabela: Moradias (Garantir colunas extras)
        if (!Schema::hasTable('moradias')) {
            Schema::create('moradias', function (Blueprint $table) {
                $table->id();
                $table->foreignId('crianca_id')->constrained('criancas')->onDelete('cascade');
                $table->string('endereco')->nullable();
                $table->string('complemento')->nullable();
                $table->string('cep', 20)->nullable();
                $table->string('bairro')->nullable();
                $table->string('ponto_referencia')->nullable();
                $table->string('situacao_habitacional')->nullable();
                $table->integer('numero_comodos')->nullable();
                $table->integer('numero_moradores')->nullable();
                $table->string('condicao_moradia')->nullable();
                $table->timestamps();
            });
        }
        
        // Atualizar tabela Criancas com colunas faltantes conforme o mapeamento
        Schema::table('criancas', function (Blueprint $table) {
            if (!Schema::hasColumn('criancas', 'idade')) {
                $table->integer('idade')->nullable()->after('data_nascimento');
            }
            if (!Schema::hasColumn('criancas', 'sexo')) {
                $table->string('sexo', 20)->nullable();
            }
            if (!Schema::hasColumn('criancas', 'cor_raca')) {
                $table->string('cor_raca', 50)->nullable();
            }
            if (!Schema::hasColumn('criancas', 'naturalidade')) {
                $table->string('naturalidade')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'data_inscricao')) {
                $table->date('data_inscricao')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'data_matricula')) {
                $table->date('data_matricula')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'data_desligamento')) {
                $table->date('data_desligamento')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'motivo_desligamento')) {
                $table->string('motivo_desligamento')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'esta_na_escola')) {
                $table->boolean('esta_na_escola')->default(true);
            }
            if (!Schema::hasColumn('criancas', 'escola')) {
                $table->string('escola')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'tipo_escola')) {
                $table->string('tipo_escola')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'serie')) {
                $table->string('serie')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'periodo_escolar')) {
                $table->string('periodo_escolar')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'certidao_nascimento')) {
                $table->string('certidao_nascimento')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'certidao_folha')) {
                $table->string('certidao_folha')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'certidao_livro')) {
                $table->string('certidao_livro')->nullable();
            }
            if (!Schema::hasColumn('criancas', 'cpf')) {
                $table->string('cpf', 20)->nullable();
            }
            if (!Schema::hasColumn('criancas', 'rg')) {
                $table->string('rg', 20)->nullable();
            }
            if (!Schema::hasColumn('criancas', 'possui_deficiencia')) {
                $table->boolean('possui_deficiencia')->default(false);
            }
        });

        // Atualizar tabela Responsaveis com colunas socioeconômicas
        Schema::table('responsaveis', function (Blueprint $table) {
            if (!Schema::hasColumn('responsaveis', 'telefone_secundario')) {
                $table->string('telefone_secundario')->nullable()->after('telefone');
            }
            if (!Schema::hasColumn('responsaveis', 'acesso_local')) {
                $table->string('acesso_local', 50)->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'parentesco')) {
                $table->string('parentesco', 50)->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'estado_civil')) {
                $table->string('estado_civil', 50)->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'data_nascimento')) {
                $table->date('data_nascimento')->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'idade')) {
                $table->integer('idade')->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'grau_instrucao')) {
                $table->string('grau_instrucao')->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'cpf')) {
                $table->string('cpf', 20)->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'rg')) {
                $table->string('rg', 20)->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'tem_cadastro_unico')) {
                $table->boolean('tem_cadastro_unico')->default(false);
            }
            if (!Schema::hasColumn('responsaveis', 'recebe_transferencia_renda')) {
                $table->boolean('recebe_transferencia_renda')->default(false);
            }
            if (!Schema::hasColumn('responsaveis', 'recebe_bpc')) {
                $table->boolean('recebe_bpc')->default(false);
            }
            if (!Schema::hasColumn('responsaveis', 'profissao')) {
                $table->string('profissao')->nullable();
            }
            if (!Schema::hasColumn('responsaveis', 'desempregado')) {
                $table->boolean('desempregado')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familiares');
        Schema::dropIfExists('contatos');
        Schema::dropIfExists('crianca_responsavel');
    }
};
