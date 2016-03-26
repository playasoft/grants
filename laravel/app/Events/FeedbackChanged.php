<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Feedback;

class FeedbackChanged extends Event
{
    use SerializesModels;

    public $feedback;
    public $change;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Feedback $feedback, $change)
    {
        $this->feedback = $feedback;
        $this->change = $change;
    }
}
