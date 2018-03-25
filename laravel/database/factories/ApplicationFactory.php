<?php

use Faker\Generator as Faker;
use App\Model\Application;

$factory->define(Application::class, function (Faker $faker, $budget) {
    return [
        'name' => $faker->words(2, $asText=true),
        'desciption' => $faker->paragraph(),
        'budget' => $budget,
    ];
});
