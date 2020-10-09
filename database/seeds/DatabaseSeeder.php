<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(FeatureSeeder::class);
         $this->call(LocationSeeder::class);
         //$this->call(PropertyCategorySeeder::class);
        // $this->call(PropertyFeatureSeeder::class);
         $this->call(PropertyLocationSeeder::class);
         $this->call(PropertySeeder::class);
         //$this->call(PropertyTypeSeeder::class);
         $this->call(TypeSeeder::class);
         $this->call(SubscriptionplansSeeder::class);
    }

}

