<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:list-users')]
#[Description('Lista todos os usuários cadastrados')]
class ListUsers extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::all(['id', 'name', 'email', 'role']);
        $this->table(['ID', 'Nome', 'Email', 'Role'], $users->toArray());
    }
}
