<?php

use Illuminate\Database\Seeder;
use App\Plan;
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([

            'name' => 'basic',
            'price' => 0.0,
            'duration' => '100',
            'discount_month1' => '',
            'discount_month2' =>  '',
            'maximum_listings' => 5,
            'maximum_premium_listings' =>0,
            'max_featured_ad_listings' => 0,
            'gateway_id'=> 123

        ]);
    }
}
