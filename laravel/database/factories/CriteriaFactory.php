<?php

use Faker\Generator as Faker;
use App\Models\Criteria;

$factory->define(Criteria::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence(),
        'type' => (rand(0, 1) ? 'objective' : 'subjective'),
        'required' => rand(0, 1),
        'round_id' => 1,
    ];
});
