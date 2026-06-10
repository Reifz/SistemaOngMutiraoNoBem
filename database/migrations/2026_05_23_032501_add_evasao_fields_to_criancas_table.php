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
            $table->date('data_evasao')->nullable()->after('status');
            $table->string('motivo_evasao')->nullable()->after('data_evasao');
            $table->text('observacao_evasao')->nullable()->after('motivo_evasao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criancas', function (Blueprint $table) {
            $table->dropColumn(['data_evasao', 'motivo_evasao', 'observacao_evasao']);
        });
    }
};
