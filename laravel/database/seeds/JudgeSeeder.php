<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Round;
use App\Models\Judged;

class JudgeSeeder extends Seeder
{
    private function giveFeedback()
    {

    }

    private function giveScore()
    {
        
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
            echo $judge->name . "\n";
            foreach ($judgeRounds as $round) {
                foreach ($round->applications as $application) {
                    if ($this->checkIfJudged($judge->id, $application->id)) {
                        echo "Not Judged\n";
                        if (rand(0, 1)) {
                            $this->giveFeedback();
                        } else {
                            $this->giveScore();
                        }
                    } else {
                        echo "Judged\n";
                    }
                }
            }
        }
    }
}
