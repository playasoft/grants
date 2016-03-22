<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Application;
use App\Models\Feedback;

class ApplicationFeedback extends Event
{
    use SerializesModels;

    public $application;
    public $feedback;
    public $change;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Application $application, Feedback $feedback, $change)
    {
        $this->application = $application;
        $this->feedback = $feedback;
        $this->change = $change;
    }
}
