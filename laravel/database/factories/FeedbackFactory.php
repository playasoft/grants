<?php

use Faker\Generator as Faker;
use App\Models\Feedback;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence(),
        'type' => 'text',
    ];
});
