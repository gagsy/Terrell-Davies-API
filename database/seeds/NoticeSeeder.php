<?php

use Illuminate\Database\Seeder;

use App\Notice;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i = 0; $i <= 10 ; $i++){

            Notice::create([

                'title'=> Str::random(10),
                'sender_id'=>5,
                'receiver_id'=>4,
                'content'=>Str::random(250)

                ]);

        }

    }
}
