<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Type;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Type::class, function (Faker $faker) {
    return [
        'typeName' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
