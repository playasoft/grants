<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Round;
use App\Models\Judged;
use App\Models\Application;
use App\Models\Criteria;
use App\Models\Score;
use App\Models\Question;
use App\Models\Feedback;

class JudgmentDay extends Seeder
{
    private function giveFeedback(User $judge, Application $application)
    {
        echo "Feedback\n";

        $questions = Question::where(['round_id' => $application->round_id])->get();

        //TODO: better name for this variable
        $chance = rand(0, count($questions));

        if ($chance == count($questions)) {
            factory(Feedback::class)
                ->create([
                    'application_id' => $application->id,
                    'user_id' => $judge->id,
                    'regarding_type' => 'general',
                ]);
        } else {
            factory(Feedback::class)
                ->create([
                    'application_id' => $application->id,
                    'user_id' => $judge->id,
                    'regarding_type' => 'question',
                    'regarding_id' => $questions[$chance]->id,
                ]);
        }
    }

    private function giveScore(User $judge, Application $application)
    {
        // 1/10 chance that the judge abstains from judging
        if (rand(1, 10) == 1) {
            echo "Abstained\n";
            factory(Judged::class)
                ->create([
                    'status' => 'abstain',
                    'application_id' => $application->id,
                    'user_id' => $judge->id,
                ]);
        }

        else {
            echo "Judgement\n";
            $criterias = Criteria::where("round_id", "=", $application->round_id)->get();

            foreach ($criterias as $criteria) {
                if ($criteria->type == 'subjective') {
                    $scoreChances = [-2, -1, 0, 1, 2];
                } else {
                    $scoreChances = [-1, 1];
                }

                factory(Score::class)
                    ->create([
                        'score' => $scoreChances[array_rand($scoreChances)],
                        'application_id' => $application->id,
                        'criteria_id' => $criteria->id,
                        'user_id' => $judge->id,
                    ]);
            }

            factory(Judged::class)
                ->create([
                    'application_id' => $application->id,
                    'user_id' => $judge->id,
                ]);

            Score::calculateTotals($application);
        }
    }

    private function checkIfJudged($judgeId, $appId)
    {
        try {
            $judgements = Judged::where('application_id', '=', $appId)
                                ->where('user_id', '=', $judgeId)
                                ->firstOrFail();
            return False;
        } catch (Exception $e) {
            return True;
        }
    }

    /**
     *
     * Run the database seeds. Each time this is ran,
     * there is a 50% chance that each application will
     * get judged. To judge all of them, keep running
     * seed until all applications are judged.
     *
     * Usage: php artisan db:seed --class=JudgmentDay
     *
     * @return void
     */
    public function run()
    {
        $judges = User::where('role', '=', 'judge')->get();

        $judgeRounds = Round::where('end_date', '<', Carbon::now())->get();

        // Each Judge goes through each round and judges/gives feedback to each application 
        foreach ($judges as $judge) {
            foreach ($judgeRounds as $round) {
                foreach ($round->applications as $application) {
                    if ($this->checkIfJudged($judge->id, $application->id)) {
                        if (rand(0, 1)) {
                            $this->giveFeedback($judge, $application);
                        } else {
                            $this->giveScore($judge, $application);
                        }
                    }
                }
            }
        }
    }
}
