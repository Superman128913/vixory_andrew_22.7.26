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
        //Individual seeders
        $this->call(AddInitialFAQs::class);
        $this->call(DefaultNotificationSettings::class);
        $this->call(ImportCollegesTable::class);
        $this->call(PlanSeeder::class);
        $this->call(DefaultUsers::class);

        //Call the "group" seeders first
        $this->call(SeedRolesAndPermissions::class);
        $this->call(SportDataSeeder::class);

        //Individual seeders that should be after sports
        $this->call(AddCoverImages::class);
    }
}
