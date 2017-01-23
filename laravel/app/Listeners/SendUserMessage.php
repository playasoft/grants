<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\Notification;

class SendUserMessage
{
    private $handlers =
    [
        'App\Events\UserRegistered' => 'userRegistered',
        'App\Events\ApplicationSubmitted' => 'applicationSubmitted',
        'App\Events\ApplicationChanged' => 'applicationChanged',
        'App\Events\ForgotPassword' => 'forgotPassword',
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

    private function userRegistered($event)
    {
        $user = $event->user;
        $options =
        [
            'template' => 'emails/user-welcome',
            'subject' => 'Welcome to Weightlifter!'
        ];

        Notification::send($user, 'email', $options);
    }

    private function applicationSubmitted($event)
    {
        $user = $event->application->user;
        $application = $event->application;
        $options =
        [
            'template' => 'emails/user-application-submitted',
            'template-vars' => compact('application'),
            'subject' => 'You Submitted an Application',
        ];

        Notification::send($user, 'email', $options);
    }

    private function applicationChanged($event)
    {
        $user = $event->application->user;
        $application = $event->application;
        $subject = false;

        if($application->status == 'accepted')
        {
            $subject = "Your Art Grant is approved!";
        }
        elseif($application->status == 'rejected')
        {
            $subject = "Your Art Grant was not approved";
        }

        if($subject)
        {
            $options =
            [
                'template' => 'emails/user-application-' . $application->status,
                'template-vars' => compact('application'),
                'subject' => $subject,
            ];

            Notification::send($user, 'email', $options);
        }
    }

    private function forgotPassword($event)
    {
        $user = $event->user;
        $options =
        [
            'template' => 'emails/forgot-password',
            'subject' => 'Your Password Reset Code'
        ];

        Notification::send($user, 'email', $options);
    }
}
