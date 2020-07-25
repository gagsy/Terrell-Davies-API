<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PropertyType;
use Faker\Generator as Faker;

$factory->define(PropertyType::class, function (Faker $faker) {
    return [
        'type_id' => $faker->randomDigit,
        'property_id' => $faker->randomDigit,
    ];
});
