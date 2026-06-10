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
        if (!Schema::hasTable('inscricoes')) {
            Schema::create('inscricoes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('crianca_id')->constrained('criancas')->onDelete('cascade');
                $table->string('status')->default('PREENCHER');
                $table->boolean('consentimento_lgpd')->default(true);
                $table->timestamp('data_criacao')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};
