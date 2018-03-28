<?php

use Faker\Generator as Faker;
use App\Models\Application;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, $asText=true),
        'description' => $faker->paragraph(),
        'budget' => 30000,
        'user_id' => 1,
        'round_id' => 1,
    ];
});
