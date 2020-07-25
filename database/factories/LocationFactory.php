<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'locationName' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
