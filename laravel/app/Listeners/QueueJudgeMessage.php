<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Models\User;

class QueueJudgeMessage
{
    private $handlers =
    [
        'App\Events\ApplicationSubmitted' => 'applicationSubmitted',
        'App\Events\FeedbackChanged' => 'feedbackChanged',
    ];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $class = get_class($event);

        if(isset($this->handlers[$class]))
        {
            call_user_func(array($this, $this->handlers[$class]), $event);
        }
    }

    private function applicationSubmitted($event)
    {
        $user = $event->application->user;
        $application = $event->application;
    }

    private function feedbackChanged($event)
    {
        $feedback = $event->feedback;
        $change = $event->change;
    }
}
