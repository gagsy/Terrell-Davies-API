<?php

use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 50; $i++) {
            App\Property::create([
                'prperty_cat_id' => $faker->randomDigit,
                'prperty_type_id' => $faker->randomDigit,
                'title' => $faker->sentence,
                'description' => $faker->text,
                'state' => $faker->sentence,
                'market_status' => $faker->sentence,
                'locality' => $faker->sentence,
                'budget' => $faker->randomFloat(3, 887, 888, 9999999),
                'featuredImage' => $faker->image('public/FeaturedProperty_images',640,480, null, false),
                'galleryImage' => $faker->image('public/Gallery_images',640,480, null, false),
                'agent' => $faker->name,
                'features' => $faker->sentence,
                'bedroom' => $faker->sentence,
                'bathroom' => $faker->sentence,
                'garage' => $faker->sentence,
                'toilet' => $faker->sentence,
                'totalarea' => $faker->sentence,
                'video_link' => $faker->url,
                'metaDescription' => $faker->text,
            ]);
        }
    }
}
