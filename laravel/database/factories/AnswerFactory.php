<?php

use Faker\Generator as Faker;
use App\Models\Answer;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'answer' => $faker->sentence(),
        'application_id' => 1,
        'question_id' => 1,
    ];
});
