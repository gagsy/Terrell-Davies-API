<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PropertyStatus;
use Faker\Generator as Faker;

$factory->define(PropertyStatus::class, function (Faker $faker) {
    return [
        'status_id' => $faker->randomDigit,
        'property_id' => $faker->randomDigit,
    ];
});
