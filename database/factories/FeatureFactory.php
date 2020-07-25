<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feature;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Feature::class, function (Faker $faker) {
    return [
        'featureName' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
