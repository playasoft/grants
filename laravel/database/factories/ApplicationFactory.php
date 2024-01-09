<?php

use Faker\Generator as Faker;
use App\Models\Application;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, $asText=true),
        'description' => $faker->paragraph(),
        'requested_budget' => 30000,
        'status' => 'submitted',
        'user_id' => 1,
        'round_id' => 1,
    ];
});
