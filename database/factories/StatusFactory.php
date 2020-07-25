<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Status;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'statusName' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
