<?php

use Faker\Generator as Faker;
use App\Models\UserData;

$factory->define(UserData::class, function (Faker $faker) {
    return [
        'burner_name' => $faker->firstName,
        'real_name' => $faker->name,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'user_id' => 1,
    ];
});
