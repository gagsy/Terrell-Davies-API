<?php

use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
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
            App\Blog::create([
                'title' => $faker->name,
                'content' => $faker->text,
                'url' => $faker->url,
                'image' => $faker->image('public/Blog_images',640,480, null, false),
            ]);
        }
    }
}
