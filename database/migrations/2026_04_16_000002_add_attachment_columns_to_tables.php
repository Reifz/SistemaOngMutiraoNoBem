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
            if (!Schema::hasColumn('criancas', 'anexo_certidao')) {
                $table->string('anexo_certidao')->nullable()->after('certidao_livro');
            }
        });

        Schema::table('responsaveis', function (Blueprint $table) {
            if (!Schema::hasColumn('responsaveis', 'anexo_rg')) {
                $table->string('anexo_rg')->nullable()->after('rg');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criancas', function (Blueprint $table) {
            $table->dropColumn('anexo_certidao');
        });
        Schema::table('responsaveis', function (Blueprint $table) {
            $table->dropColumn('anexo_rg');
        });
    }
};
