<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,5),
        'category_id' => rand(1,10),
        'type_id' => rand(1,10),
        'location_id' => rand(1,20),
        'location' => $faker->address,
        'title' => $faker->sentence(5),
        'description' => $faker->realText(rand(80,600)),
        'state' => $faker->state,
        'area' => $faker->city,
        'total_area' => rand(20,40),
        'market_status' => $faker->randomElement(['available', 'rented']),
        'parking' => $faker->randomElement(['yes', 'no']),
        'locality' => $faker->locale,
        'budget' => $faker->randomDigit,
        'other_images' => "https://via.placeholder.com/350x150,https://via.placeholder.com/350x150,https://via.placeholder.com/350x150",
        'image' => "https://via.placeholder.com/350x150",
        'bedroom' => rand(1,5),
        'bathroom' => rand(1,5),
        'toilet' => rand(1,5),
        'video_link' => $faker->url,
        'status' => $faker->randomElement(['yes','no']),
        'feature' =>$faker->text(200),
        'ref_no' => str_shuffle($faker->realText(20)),
        'user' => rand(1,5),
    ];
});
