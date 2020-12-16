<?php

use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int)$this->command->ask('How many properties do you need ?', 50);
        $this->command->info("Creating {$count} properties.");
        $genres = factory(App\Property::class, $count)->create();
        $this->command->info('Properties Created!');

    }
}
