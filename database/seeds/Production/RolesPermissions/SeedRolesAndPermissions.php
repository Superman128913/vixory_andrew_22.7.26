<?php

use Illuminate\Database\Seeder;

class SeedRolesAndPermissions extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AddRolesSeeder::class);
        $this->call(CreatePermissions::class);
        $this->call(AssignPermissions::class);
        $this->call(SetDefaultUserRoles::class);
    }
}
