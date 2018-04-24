<?php

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class ApplicantResponds extends Seeder
{
    /**
     * Iterate through every feedback and generate a response.
     * Everytime this is ran, each empty response has a 66% chance
     * of getting filled.
     *
     * Usage: php artisan db:seed --class=ApplicantResponds
     *
     * @return void
     */
    public function run()
    {
        $feedbacks = Feedback::where(['response' => ''])->get();
        $faker = Faker\Factory::create();

        foreach ($feedbacks as $feedback) {
            if (rand(0, 2) < 2) {
                $feedback->update(['response' => $faker->sentence()]);
                echo 'Responded to Feedback ID: ' . $feedback->id . "\n";
            } else {
                echo 'Ignored ' . $feedback->id . "\n";
            }
        }
    }
}
