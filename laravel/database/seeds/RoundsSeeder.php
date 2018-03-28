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
use App\Models\Document;
use App\Models\Feedback;
use App\Models\Judged;
use App\Models\Notification;
use App\Models\Score;

class RoundsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($start_date = null)
    {
        $user = factory(User::class)
            ->create();

        $user_data = factory(UserData::class)
            ->create(['user_id' => $user->id]);

        $round = factory(Round::class)
            ->create(['start_date' => $start_date ?: Carbon::now()]);

        $question = factory(Question::class)
            ->create(['round_id' => $round->id]);

        $application = factory(Application::class)
            ->create([
                'user_id' => $user->id,
                'round_id' => $round->id,
            ]);
    }
}
