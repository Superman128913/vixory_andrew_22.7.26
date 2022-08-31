<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;

use Faker\Generator as Faker;
use Faker\Provider\en_US\Company;

class AddUnapprovedUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add a couple of users (coaches and athletes) who need approval.
        $users = [
            [
                "role" => "coach",
                "first_name" => "Johnny",
                "last_name" => "Rodgers",
                "manual_entry" => false
            ],
            [
                "role" => "coach",
                "first_name" => "Timmy",
                "last_name" => "Rodgers",
                "manual_entry" => false
            ],
            [
                "role" => "athlete",
                "first_name" => "Jimmy",
                "last_name" => "Rodgers",
                "manual_entry" => true
            ],
            [
                "role" => "athlete",
                "first_name" => "Sammy",
                "last_name" => "Rodgers",
                "manual_entry" => true
            ],
            [
                "role" => "athlete",
                "first_name" => "Bobby",
                "last_name" => "Rodgers",
                "manual_entry" => true
            ],
        ];

        foreach($users as $user_data)
        {
            $user = new User();
            $user->first_name = $user_data["first_name"];
            $user->last_name = $user_data["last_name"];
            $user->email = "mark+" . Str::uuid() . "@bigpxl.com";
            $user->password = Hash::make("temp01");
            $user->approval = false;
            $user->requires_approval = true;

            if($user_data["manual_entry"])
            {
                $user->manual_college_entry = Str::uuid();
            }

            $user->save();

            $user->assignRole($user_data["role"]);
        }
    }
}
