<?php

use Faker\Generator as Faker;
use App\Models\User;

$factory->define(User::class, function (Faker $faker) {
    $isJudge = (rand(0,2) == 0); // 1/3 chance to be a judge
    return [
        'name' => $faker->unique()->UserName,
        'email' => $faker->unique()->Email,
        'password' => bcrypt($faker->password),
        'role' => ($isJudge ? 'judge' : 'applicant'),
    ];
});
