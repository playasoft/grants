<?php

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class ApplicantResponds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feedbacks = Feedback::where(['response' => ''])->get();
        $faker = Faker\Factory::create();

        foreach ($feedbacks as $feedback) {
            if (rand(0, 1)) {
                $feedback->update(['response' => $faker->sentence()]);
                echo 'Responded to Feedback ID: ' . $feedback->id . "\n";
            } else {
                echo 'Ignored ' . $feedback->id . "\n";
            }
        }
    }
}
