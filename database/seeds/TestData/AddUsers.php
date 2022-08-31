<?php

use Illuminate\Database\Seeder;
use App\Models\Sport;
use Faker\Generator as Faker;

class AddUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sports = Sport::all();
        $sport_ids = $sports->pluck("id")->toArray();

        factory(App\User::class, 10)->create()->each(function($user) use (&$sport_ids) {
            $randomSports = array();
            $numOfSports = mt_rand(1, count($sport_ids)) - 1;
            for($i = 0; $i <= $numOfSports; $i++)
            {
                $randomSports[] = $sport_ids[$i];
            }

            $user->sports()->sync($randomSports);
        });
    }
}
