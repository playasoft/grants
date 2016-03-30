<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Models\User;

class SendUserMessage
{
    private $handlers =
    [
        "App\Events\UserRegistered" => "userRegistered",
        "App\Events\ApplicationSubmitted" => "applicationSubmitted",
        "App\Events\ApplicationChanged" => "applicationChanged",
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

        Mail::send('emails/user-welcome', compact('user'), function ($message) use ($user)
        {
            $message->to($user->email, $user->name)->subject('Welcome to Weightlifter!');
        });
    }

    private function applicationSubmitted($event)
    {
        // todo
    }

    private function applicationChanged($event)
    {
        // todo
    }
}
