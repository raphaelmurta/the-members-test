<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\EmailNotification;
use App\Listeners\SendEmailNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EmailNotification::class => [
            SendEmailNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
