<?php

use Illuminate\Database\Seeder;

class PropertyCategorySeeder extends Seeder
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
            App\PropertyCategory::create([
                'category_id' => $faker->randomDigit,
                'property_id' => $faker->randomDigit,
            ]);
        }
    }
}
