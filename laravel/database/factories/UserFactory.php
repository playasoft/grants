<?php

use Faker\Generator as Faker;
use App\Models\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->UserName,
        'email' => $faker->unique()->Email,
        'password' => bcrypt($faker->password),
        'role' => 'applicant',
    ];
});
