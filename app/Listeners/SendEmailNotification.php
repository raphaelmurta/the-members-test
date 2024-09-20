<?php

namespace App\Listeners;

use App\Events\EmailNotification;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\EmailNotification  $event
     * @return void
     */
    public function handle(EmailNotification $event)
    {
        $subscribers = $event->mailingList->subscribers; // Certifique-se de que 'subscribers' está retornando corretamente.

        if (!$subscribers || count($subscribers) === 0) {
            return; // Se não houver inscritos, saímos do método.
        }

        foreach ($subscribers as $subscriber) {
            Mail::raw($event->message, function ($mail) use ($subscriber) {
                $mail->to($subscriber->email)
                     ->subject('Notificação da Lista de E-mails');
            });
        }
    }
}
