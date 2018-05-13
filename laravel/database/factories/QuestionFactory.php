<?php

use Faker\Generator as Faker;
use App\Models\Question;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'round_id' => 1,
        'question' => $faker->sentence(),
        'type' => 'input', // Need to randomly generate what type of input
        'options' => '',
        'required' => rand(0,1),
        'help' => $faker->sentence(),
    ];
});
