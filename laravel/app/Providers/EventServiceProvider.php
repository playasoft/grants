<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen =
    [
        'App\Events\UserRegistered' =>
        [
            'App\Listeners\SendUserMessage',
            'App\Listeners\QueueAdminMessage',
        ],

        'App\Events\ApplicationSubmitted' =>
        [
            'App\Listeners\SendUserMessage',
            'App\Listeners\QueueJudgeMessage',
            'App\Listeners\QueueAdminMessage',
        ],

        'App\Events\ApplicationChanged' =>
        [
            'App\Listeners\SendUserMessage',
            'App\Listeners\QueueJudgeMessage',
            'App\Listeners\QueueAdminMessage',
        ],

        'App\Events\FeedbackChanged' =>
        [
            'App\Listeners\QueueUserMessage',
            'App\Listeners\QueueJudgeMessage',
            'App\Listeners\QueueAdminMessage',
        ],
    ];


    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
