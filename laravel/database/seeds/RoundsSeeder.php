<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Models\Round;
use App\Models\Question;
use App\Models\User;
use App\Models\UserData;
use App\Models\Answer;
use App\Models\Application;
use App\Models\Criteria;
use App\Models\Feedback;
use App\Models\Judged;
use App\Models\Score;

class RoundsSeeder extends Seeder
{
    private function seedRound($start_date = null, $end_date = null)
    {
        $user = factory(User::class)
            ->create();

        $user_data = factory(UserData::class)
            ->create(['user_id' => $user->id]);

        $round = factory(Round::class)
            ->create([
                'start_date' => $start_date ?: Carbon::now(),
                'end_date' => $end_date ?: Carbon::now()->addWeeks(4),
            ]);

        $questions = factory(Question::class, 3)
            ->create(['round_id' => $round->id]);

        $criterias = factory(Criteria::class, 3)
            ->create(['round_id' => $round->id]);

        $application = factory(Application::class)
            ->create([
                'user_id' => $user->id,
                'round_id' => $round->id,
            ]);

        $answerOne = factory(Answer::class)
            ->create([
                'application_id' => $application->id,
                'question_id' => $questions[0]->id,
            ]);

        $answerTwo = factory(Answer::class)
            ->create([
                'application_id' => $application->id,
                'question_id' => $questions[1]->id,
            ]);

        $answerThree = factory(Answer::class)
            ->create([
                'application_id' => $application->id,
                'question_id' => $questions[2]->id,
            ]);
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_future = Carbon::now()->addMonth();
        $end_future = Carbon::now()->addMonths(2);

        $start_past = Carbon::now()->subMonths(2);
        $end_past = Carbon::now()->subMonth();

        $this->seedRound();
        $this->seedRound($start_future, $end_future);
        $this->seedRound($start_past, $end_past);
    }
}
