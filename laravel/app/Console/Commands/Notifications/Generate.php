<?php

namespace App\Console\Commands\Notifications;

use Illuminate\Console\Command;
use App\Models\Round;
use App\Models\Application;
use App\Events\FeedbackChanged;

class Generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:generate {round}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate retroactive feedback notifications for a specific grant round.';

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
        $round_id = $this->argument('round');
        $round = Round::findOrFail($round_id);

        echo "Generating feedback notifications for all submitted applications in the '{$round->name}' grant round.\n";

        $applications = Application::where('round_id', $round_id)->where('status', 'submitted')->get();

        foreach($applications as $application)
        {
            echo "==========================================\n";
            echo "Processing application: {$application->name}\n";
            foreach($application->feedback as $feedback)
            {
                echo "------------------------------------------\n";
                echo "Feedback: {$feedback->message}\n";
                event(new FeedbackChanged($feedback, ['status' => 'created']));

                if($feedback->response)
                {
                    echo "Response: {$feedback->response}\n";
                    event(new FeedbackChanged($feedback, ['status' => 'updated']));
                }
            }
        }
    }
}
