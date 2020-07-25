<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PropertyFeature;
use Faker\Generator as Faker;

$factory->define(PropertyFeature::class, function (Faker $faker) {
    return [
        'feature_id' => $faker->randomDigit,
        'property_id' => $faker->randomDigit,
    ];
});
