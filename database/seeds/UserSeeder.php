<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Terrell Davies',
            'email' => 'admin@terrelldavies.com',
            'password' => bcrypt('admin'),
            'phone' => '08165983685',
            'userType' => 'admin',
            'isActivated' => 'yes',


        ]);
        // $faker = Faker\Factory::create();

        // for($i = 0; $i < 50; $i++) {
        //     App\User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->email,
        //         'password' => bcrypt('password'),
        //         'phone' => $faker->phoneNumber,
        //         'userType' => 'user',
        //         'isActivated' => 1,
        //     ]);
        // }
        $faker = Faker\Factory::create();

        for($i = 0; $i < 50; $i++) {
            App\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'phone' => $faker->phoneNumber,
                'userType' => 'individual',
                'isActivated' => 'active',
            ]);
        }
    }
}
