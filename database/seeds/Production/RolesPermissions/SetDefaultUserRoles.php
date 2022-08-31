<?php

use Illuminate\Database\Seeder;

use App\User;
use Illuminate\Support\Facades\Hash;

class SetDefaultUserRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where("email", "=", "mark@bigpxl.com")->first();
        if($user){
            $user->assignRole('admin');
        }

        $user2 = User::where("email", "=", "info@vixory.com")->first();
        if($user2){
            $user2->assignRole('admin');
        }
    }
}
