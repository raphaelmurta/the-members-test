<?php

namespace App\Events;

use App\Models\MailingList;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mailingList;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\MailingList  $mailingList
     * @param  string  $message
     * @return void
     */
    public function __construct(MailingList $mailingList, $message)
    {
        $this->mailingList = $mailingList;
        $this->message = $message;
    }
}
