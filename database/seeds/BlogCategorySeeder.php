<?php

use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
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
            App\BlogCategory::create([
                'name' => $faker->name,
                'description' => $faker->text,
                'url' => $faker->url,
                'status' => 1,
            ]);
        }
    }
}
