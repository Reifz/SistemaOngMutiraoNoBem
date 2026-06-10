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
        Schema::table('turmas', function (Blueprint $table) {
            if (!Schema::hasColumn('turmas', 'turno')) {
                $table->string('turno')->nullable()->after('nome'); // Manhã, Tarde, Integral
            }
            if (!Schema::hasColumn('turmas', 'idade_minima')) {
                $table->integer('idade_minima')->nullable()->after('turno');
            }
            if (!Schema::hasColumn('turmas', 'idade_maxima')) {
                $table->integer('idade_maxima')->nullable()->after('idade_minima');
            }
            if (!Schema::hasColumn('turmas', 'descricao')) {
                $table->text('descricao')->nullable()->after('capacidade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->dropColumn(['turno', 'idade_minima', 'idade_maxima', 'descricao']);
        });
    }
};
