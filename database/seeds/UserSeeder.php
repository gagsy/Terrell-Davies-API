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
            'isActivated' => 1,


        ]);
    }
}
