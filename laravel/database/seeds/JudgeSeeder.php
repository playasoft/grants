<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Round;
use App\Models\Judged;
use App\Models\Application;
use App\Models\Criteria;
use App\Models\Score;

class JudgeSeeder extends Seeder
{
    private function giveFeedback()
    {
        echo "Feedback - Nothing Happens\n";
    }

    private function giveScore(User $judge, Application $application)
    {
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
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $judges = User::where('role', '=', 'judge')->get();

        $judgeRounds = Round::where('end_date', '<', Carbon::now())->get();

        foreach ($judges as $judge) {
            foreach ($judgeRounds as $round) {
                foreach ($round->applications as $application) {
                    if ($this->checkIfJudged($judge->id, $application->id)) {
                        if (rand(0, 1)) {
                            $this->giveFeedback();
                        } else {
                            $this->giveScore($judge, $application);
                        }
                    }
                }
            }
        }
    }
}
