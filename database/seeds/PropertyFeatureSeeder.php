<?php

use Illuminate\Database\Seeder;

class PropertyFeatureSeeder extends Seeder
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
            App\PropertyFeature::create([
                'feature_id' => $faker->randomDigit,
                'property_id' => $faker->randomDigit,
            ]);
        }
    }
}
