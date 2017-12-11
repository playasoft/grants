<?php

namespace App\Console\Commands;

use App\Models\Round;
use App\Models\Question;
use App\Models\Criteria;
use App\Models\Answer;
use App\Models\Feedback;
use App\Models\Score;
use Illuminate\Console\Command;

class FixRoundRelationships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:round-relationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy current questions and criteria to all existing rounds';

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
        // Get all data to be copied
        $rounds = Round::get();
        $questions = Question::get();
        $criteria = Criteria::get();

        foreach($rounds as $round)
        {
            // Skip the first round since all questions and criteria were assigned to it by default
            if($round->id == 1)
            {
                continue;
            }

            dump("Processing round {$round->name}");

            // Get a list of all applications that exist for this round
            $applications = $round->applications->pluck('id');

            // Check if this round already has questions or criteria before populating them
            if(!count($round->questions))
            {
                dump("This round has no questions, automatically populating...");

                foreach($questions as $question)
                {
                    $newQuestion = $question->replicate();
                    $newQuestion->round_id = $round->id;
                    $newQuestion->save();

                    // Update application data to reflect the new question ID
                    Answer::whereIn('application_id', $applications)->where('question_id', $question->id)->update(['question_id' => $newQuestion->id]);
                    Feedback::whereIn('application_id', $applications)->where('regarding_id', $question->id)->where('regarding_type', 'question')->update(['regarding_id' => $newQuestion->id]);
                }
            }

            if(!count($round->criteria))
            {
                dump("This round has no criteria, automatically populating...");

                foreach($criteria as $criterion)
                {
                    $newCriterion = $criterion->replicate();
                    $newCriterion->round_id = $round->id;
                    $newCriterion->save();

                    Score::whereIn('application_id', $applications)->where('criteria_id', $criterion->id)->update(['criteria_id' => $newCriterion->id]);
                }
            }
        }

        dump("All done!");
    }
}
