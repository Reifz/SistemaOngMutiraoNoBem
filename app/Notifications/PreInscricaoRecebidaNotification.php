<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PreInscricaoRecebidaNotification extends Notification
{
    use Queueable;

    protected $criancaNome;

    /**
     * Create a new notification instance.
     */
    public function __construct($criancaNome)
    {
        $this->criancaNome = $criancaNome;
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
        return (new MailMessage)
            ->subject('Pré-Inscrição Recebida - Mutirão no Bem')
            ->greeting('Olá, ' . $notifiable->nome . '!')
            ->line('Recebemos com sucesso o interesse de pré-inscrição para a criança: **' . $this->criancaNome . '**')
            ->line('Informamos que o preenchimento desta ficha manifesta o seu interesse. Nossa equipe de triagem analisará os dados e entrará em contato via telefone em breve.')
            ->line('Fique atento(a) às ligações e mensagens em seu telefone cadastrado.')
            // ->action('Visite nosso site', url('https://www.mutiraonobem.org.br'))
            ->line('Obrigado por confiar no trabalho do Mutirão no Bem!')
            ->salutation('**Atenciosamente, Equipe Mutirão no Bem**');
    }
}
