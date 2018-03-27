<?php

use Faker\Generator as Faker;
use App\Models\Round;
use Carbon\Carbon;

$factory->define(Round::class, function (Faker $faker, $date_info) 
{
    $budget = (rand(5, 15) * 50000); // between 250k and 750k 
    $min_request = ($budget / 20); // 5% of budget
    $max_request = (($budget * 3) / 20); // 15% of budget
    $start_date = (isset($date_info['start_date']) ? $date_info['start_date'] : Carbon::now());
    $end_date = $start_date->addWeeks(4);
    return [
        'name' => $faker->sentence(2),
        'description' => $faker->paragraph(),
        'budget' => $budget,
        'min_request_amount' => $min_request,
        'max_request_amount' => $max_request,
        'start_date' => $start_date,
        'end_date' => $end_date,
    ];
});
