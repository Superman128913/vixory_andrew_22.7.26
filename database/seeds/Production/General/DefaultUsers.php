<?php

use Illuminate\Database\Seeder;
use App\User;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Hash;

class DefaultUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where("email", "=", "mark@bigpxl.com")->first();
        if(! $user)
        {
            $user = User::create([
                'first_name' => 'Mark',
                'last_name'  => 'Hill',
                'email'      => 'mark@bigpxl.com',
                'password'   => Hash::make('qYS6pDnNloyUeZRAD5SU'),
                'consent_given' => true
            ]);
            //Nova::createUser($user);
        }

        $user2 = User::where("email", "=", "info@vixory.com")->first();
        if(! $user2)
        {
            $user2 = User::create([
                'first_name' => 'Vixory',
                'last_name'  => 'LLC',
                'email'      => 'info@vixory.com',
                'password'   => Hash::make('qYS6pDnNloyUeZRAD5SU'),
                'consent_given' => true
            ]);
            //Nova::createUser($user2);
        }
    }
}
