<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Property;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'slug' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->paragraph(),
        'location' => $faker->text(),
        'type' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'status' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'price' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'featuredImage' => $faker->image('public/FeaturedProperty_images',640,480, null, false),
        'galleryImage' => $faker->image('public/Gallery_images',640,480, null, false),
        'user_id' => $faker->randomDigit,
        'agent' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'feature' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'bedroom' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'bathroom' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'garage' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'toilet' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'views' => $faker->randomDigit,
        'metaDescription' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'visible' =>  $faker->randomDigit,
    ];
});
