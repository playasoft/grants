<?php

namespace App\Console\Commands\Notifications;

use Illuminate\Console\Command;
use DB;
use App\Models\Notification;
use App\Models\User;
use App\Models\Feedback;

class Send extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send queued notifications';

    // Map of notification events and their handler functions
    private $eventHandler =
    [
        'FeedbackCreated' => 'dailyDigest',
        'FeedbackUpdated' => 'dailyDigest'
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all users that have queued notifications
        $users = DB::table('notifications')->select('user_to')->where('type', 'email')->where('status', 'new')->groupBy('user_to')->pluck('user_to');

        foreach($users as $user_id)
        {
            $user = User::find($user_id);
            
            // Get all notifications for this user
            $notifications = Notification::where('user_to', $user_id)->where('type', 'email')->where('status', 'new')->get();
            $this->dispatchToHandler($user, $notifications);
        }
    }

    // Helper function which dispatches notifications to their handler functions
    private function dispatchToHandler($user, $notifications)
    {
        $queue = [];

        // Determine which event handler should handle these notifications
        foreach($notifications as $notification)
        {
            $metadata = json_decode($notification->metadata);

            if(isset($this->eventHandler[$metadata->event]))
            {
                $handler = $this->eventHandler[$metadata->event];

                if(!isset($queue[$handler]))
                {
                    $queue[$handler] = [];
                }
                
                $queue[$handler][] = $notification;
            }
        }

        // Now loop through the queue and call the handler functions
        foreach($queue as $function => $data)
        {
            $this->{$function}($user, $data);
        }
    }

    private function dailyDigest($user, $notifications)
    {
        $applications = [];
        $notification_ids = [];

        // Loop through all notifications and find the associated feedback
        foreach($notifications as $notification)
        {
            $metadata = json_decode($notification->metadata);
            $feedback = Feedback::find($metadata->feedback);

            // Group all feedback by what application it belongs to
            if(!isset($applications[$feedback->application->id]))
            {
                $applications[$feedback->application->id] = ['application' => $feedback->application, 'feedback' => []];
            }

            $applications[$feedback->application->id]['feedback'][] = $feedback;
            $notification_ids[] = $notification->id;
        }

        // Send daily digest email with different templates based on the user it's being sent to
        if(in_array($user->role, ['judge', 'observer'])
        {
            Mail::send("emails/judge-daily-digest", compact('applications'), function ($message) use ($user)
            {
                $message->to($user->email, $user->name)->subject('Weightlifter Daily Digest - ' . date('m/d/Y'));
            });
        }
        else
        {
            Mail::send("emails/user-daily-digest", compact('applications'), function ($message) use ($user)
            {
                $message->to($user->email, $user->name)->subject('We have some questions about your application!');
            });
        }

        // Update all notifications to sent
        Notification::whereIn('id', $notification_ids)->update(['status' => 'sent']);
    }
}
