<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A coluna já é string. Este índice apoia as verificações e revisões de acesso.
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'ativo'], 'users_role_ativo_index');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_ativo_index');
        });
    }
};
