<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovaInscricaoAdminNotification extends Notification
{
    use Queueable;

    protected $crianca;
    protected $responsavel;

    /**
     * Create a new notification instance.
     */
    public function __construct($crianca, $responsavel)
    {
        $this->crianca = $crianca;
        $this->responsavel = $responsavel;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $telefone_responsavel = preg_replace('/\D/', '', $this->responsavel->telefone);
        $urlWaMe = "https://wa.me/55" . $telefone_responsavel . "?text=Olá,%20tudo%20bem?%20Somos%20da%20Ong%20Multirao%20no%20Bem";
        return (new MailMessage)
            ->subject('Nova Pré-Inscrição: ' . $this->crianca->nome)
            ->greeting('Olá!')
            ->line('Uma nova pré-inscrição foi recebida pelo sistema.')
            ->line('**Dados da Criança:**')
            ->line('Nome: ' . $this->crianca->nome)
            ->line('Idade: ' . $this->crianca->idade . ' anos')
            ->line('Escola: ' . $this->crianca->escola)
            ->line('Série/Período: ' . $this->crianca->serie . ' - ' . $this->crianca->periodo_escolar)
            ->line('Período na ONG: ' . $this->crianca->periodo_ong)
            ->line('**Dados do Responsável:**')
            ->line('Nome: ' . $this->responsavel->nome)
            ->line('Telefone: ' . $this->responsavel->telefone. ' [WhatsApp]( ' . $urlWaMe . ' )')
            ->line('E-mail: ' . $this->responsavel->email)
            ->line('Verifique a triagem para dar continuidade ao processo.')
            ->salutation('Sistema de Gestão - Mutirão no Bem');
    }
}
