<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\Notification;

class QueueUserMessage
{
    private $handlers =
    [
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

    private function feedbackChanged($event)
    {
        $user = $event->feedback->application->user;
        $feedback = $event->feedback;
        $change = $event->change;

        // Only notify users when feedback is initially created
        if($change['status'] == 'created')
        {
            // The feedback user is the judge that requested it
            $user_from = $event->feedback->user;
            $options =
            [
                'feedback' => $feedback->id,
                'event' => 'FeedbackCreated',
            ];

            Notification::queue($user, 'email', $options, $user_from);
        }
    }
}
