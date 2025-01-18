<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\Notification;

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
        $user_from = $event->application->user;
        $application = $event->application;
        $options =
        [
            'event' => 'ApplicationSubmitted',
            'application' => $application->id,
        ];

        // Loop through all judges and queue a notification for them
        $judges = User::whereIn('role', ['judge', 'kitten', 'observer'])->get();

        foreach($judges as $judge)
        {
            Notification::queue($judge, 'email', $options, $user_from);
        }
    }

    private function feedbackChanged($event)
    {
        $feedback = $event->feedback;
        $change = $event->change;
        $options =
        [
            'feedback' => $feedback->id,
        ];

        if($change['status'] == 'created')
        {
            // When the feedback is created, set "user_from" to be the judge that created the feedback
            $user_from = $event->feedback->user;
            $options['event'] = 'FeedbackCreated';
        }
        else
        {
            // When the feedback is updated, set "user_from" to be the user that responded
            $user_from = $event->feedback->application->user;
            $options['event'] = 'FeedbackUpdated';
        }

        // Loop through all judges and queue a notification for them
        $judges = User::whereIn('role', ['judge', 'kitten', 'observer'])->get();

        foreach($judges as $judge)
        {
            Notification::queue($judge, 'email', $options, $user_from);
        }
    }
}
