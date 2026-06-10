<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log detalhado de início de envio de e-mail
        Event::listen(MessageSending::class, function (MessageSending $event) {
            $to = collect($event->message->getTo())->map(fn($addr) => $addr->getAddress())->implode(', ');
            Log::info('Tentando enviar e-mail:', [
                'para' => $to,
                'assunto' => $event->message->getSubject()
            ]);
        });

        // Log detalhado de e-mail enviado com sucesso
        Event::listen(MessageSent::class, function (MessageSent $event) {
            try {
                // Em algumas versões do Laravel o objeto message está em $event->message, 
                // em outras o objeto SentMessage está em $event->sentMessage.
                $message = $event->message ?? ($event->sentMessage ? $event->sentMessage->getOriginalMessage() : null);
                
                if ($message) {
                    $to = collect($message->getTo())->map(fn($addr) => $addr->getAddress())->implode(', ');
                    Log::info('E-mail enviado com sucesso!', [
                        'para' => $to,
                        'assunto' => $message->getSubject(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Falha ao logar e-mail enviado: ' . $e->getMessage());
            }
        });
    }
}
