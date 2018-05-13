<?php

use Faker\Generator as Faker;
use App\Models\Judged;

$factory->define(Judged::class, function (Faker $faker) {
    return [
        'status' => 'judged',
    ];
});
