<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anamnese', function (Blueprint $table) {
            $table->unsignedBigInteger('ano_letivo_id')->nullable()->after('crianca_id');
            $table->foreign('ano_letivo_id')->references('id')->on('anos_letivos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('anamnese', function (Blueprint $table) {
            $table->dropForeign(['ano_letivo_id']);
            $table->dropColumn('ano_letivo_id');
        });
    }
};
