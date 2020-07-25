<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PropertyLocation;
use Faker\Generator as Faker;

$factory->define(PropertyLocation::class, function (Faker $faker) {
    return [
        'location_id' => $faker->randomDigit,
        'property_id' => $faker->randomDigit,
    ];
});
