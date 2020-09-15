<?php

use Illuminate\Database\Seeder;

class PropertyRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 10; $i++) {
            App\PropertyRequest::create([
                'name' => $faker->name,
                'user_type' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'category' => $faker->name,
                'type' => $faker->name,
                'state' => $faker->name,
                'locality' => $faker->name,
                'area' => $faker->name,
                'bedrooms' => $faker->name,
                'budget' => $faker->name,
                'comment' => $faker->text,
            ]);
        }
    }
}
