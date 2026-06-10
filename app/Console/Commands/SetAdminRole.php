<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:set-admin-role {email}')]
#[Description('Define o papel de administrador para um usuário específico')]
class SetAdminRole extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuário com e-mail {$email} não encontrado.");
            return;
        }

        $user->update(['role' => 'admin']);
        $this->info("Usuário {$email} agora é um administrador.");
    }
}
