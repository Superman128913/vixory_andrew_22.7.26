<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class AddRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //1. Delete all the existing roles
        $roles = Role::all();
        foreach($roles as $role)
        {
            $role->delete();
        }

        //2. Create all the new roles
        /*
        Roles based on the type of user.
            Admin
            Coach
            Athlete
        */
        $athlete = Role::create(['name' => 'athlete']);
        $coach = Role::create(['name' => 'coach']);
        $pro_scout = Role::create(['name' => 'pro_scout']);
        $admin = Role::create(['name' => 'admin']);

        /*
        Roles based on the subscription.
            gold
            bronze
            silver
            founder
        */
        $role = Role::create(['name' => 'gold']);
        $role = Role::create(['name' => 'bronze']);
        $role = Role::create(['name' => 'silver']);
        $role = Role::create(['name' => 'founder']);

        //Reassign the super admin user to the correct role
        $user = User::where("email", "mark@bigpxl.com")->first();
        $user->assignRole('admin');
    }
}
