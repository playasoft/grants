<?php

namespace App\Console\Commands;

use App\Models\Round;
use App\Models\Question;
use App\Models\Criteria;
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

            foreach($questions as $question)
            {
                $newQuestion = $question->replicate();
                $newQuestion->round_id = $round->id;
                $newQuestion->save();
            }

            foreach($criteria as $criterion)
            {
                $newCriterion = $criterion->replicate();
                $newCriterion->round_id = $round->id;
                $newCriterion->save();
            }

            dump("Copied questions and criteria into round - {$round->name}");
        }
    }
}
