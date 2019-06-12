<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\TransactionCreated::class => [
            \App\Listeners\ReportCalculate::class,
        ],
        \App\Events\TransactionUpdated::class => [
            \App\Listeners\RegenerateSellLog::class
        ],
        \App\Events\TransactionDeleted::class => [
            \App\Listeners\RegenerateSellLog::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }
}
