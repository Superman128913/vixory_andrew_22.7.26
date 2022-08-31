<?php

use Illuminate\Database\Seeder;

class SportDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SportsSeeder::class);
        $this->call(SportPositionSeeder::class);
        $this->call(SportFieldSeeder::class);
    }
}
