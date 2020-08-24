<?php

use Illuminate\Database\Seeder;

class SubscriptionplansSeeder extends Seeder
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
            App\SubscriptionPlans::create([
                'name' => $faker->name,
                'price' => $faker->randomFloat(3, 887, 888),
                'duration' => $faker->randomDigit,
                'maximum_listings' => $faker->randomDigit,
                'maximum_premium_listings' => $faker->randomDigit,
                'max_featured_ad_listings' => $faker->randomDigit,
            ]);
        }
    }
}
