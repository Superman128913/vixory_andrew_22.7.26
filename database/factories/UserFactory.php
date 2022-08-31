<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Enums\StateCode;
use App\Enums\SchoolType;
use App\Enums\SchoolDivision;
use App\Enums\UserData\UserDataSex;
use App\Enums\UserData\UserDataSchoolYear;

use App\Enums\SportData\BaseballBatOptions;
use App\Enums\SportData\BaseballOutfieldPosition;
use App\Enums\SportData\BaseballPositionsPlayed;
use App\Enums\SportData\BaseballStartRelieve;
use App\Enums\SportData\BaseballThrowOptions;
use App\Enums\SportData\BasketballPosition;
use App\Enums\SportData\BasketballThrowOptions;
use App\Enums\SportData\FootballPositionDefense;
use App\Enums\SportData\FootballPositionOffense;
use App\Enums\SportData\FootballSpecialTeams;
use App\Enums\SportData\TennisStarRecruit;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('password'), // password
        'remember_token' => Str::random(10),

        //Basic Information
        'show_info'                 => $faker->randomElement([true, false]),
        'first_name'                => $faker->firstName,
        'last_name'                 => $faker->lastName,
        'phone_number'              => $faker->phoneNumber,
        'age'                       => $faker->numberBetween(18, 37),
        'date_of_birth'             => $faker->dateTimeThisCentury,
        'profile_description'       => $faker->paragraph,
        'sex'                       => $faker->randomElement(UserDataSex::toValueArray()),
        'height'                    => '89',
        'weight'                    => $faker->numberBetween(80, 700),
        'school_year'               => $faker->randomElement(UserDataSchoolYear::toValueArray()),
        'highschool_gpa'            => $faker->numberBetween(0, 5),
        'sat'                       => $faker->numberBetween(400, 1600),
        'act'                       => $faker->numberBetween(1, 36),
        'city'                      => Str::random(10),
        'country'                   => $faker->country,
        'hometown'                  => Str::random(10),
        'highschool'                => Str::random(10),
        'credit_hours_completed'    => $faker->numberBetween(18, 37),
        'consent_given'             => true,
        
        'social_media_facebook'     => "https://facebook.com/" . Str::random(10),
        'social_media_twitter'      => "https://twitter.com/" . Str::random(10),
        'social_media_instagram'    => "https://instagram.com/" . Str::random(10),
        'social_media_linkedin'     => "https://linkedin.com/" . Str::random(10),

        'profile_status_complete'   => true,
        'profile_status_verified'   => true,
        'profile_status_basic'      => true,
        'profile_status_sports'     => true,

        //Sports Data
        'baseball_60_yard_dash'             => $faker->numberBetween(10, 100),
        'baseball_bat_options'              => $faker->randomElement(BaseballBatOptions::toValueArray()),
        'baseball_batting_average'          => $faker->numberBetween(10, 100),
        'baseball_change_up_velo'           => $faker->numberBetween(10, 100),
        'baseball_curve_ball_velo'          => $faker->numberBetween(10, 100),
        'baseball_era'                      => $faker->numberBetween(10, 100),
        'baseball_exit_velo'                => $faker->numberBetween(10, 100),
        'baseball_fast_ball_velo'           => $faker->numberBetween(10, 100),
        'baseball_holds'                    => $faker->numberBetween(10, 100),
        'baseball_hrs'                      => $faker->numberBetween(10, 100),
        'baseball_innings_pitched'          => $faker->numberBetween(10, 100),
        'baseball_losses'                   => $faker->numberBetween(10, 100),
        'baseball_obp'                      => $faker->numberBetween(10, 100),
        'baseball_outfield_position'        => $faker->randomElement(BaseballOutfieldPosition::toValueArray()),
        'baseball_pitcher_other'            => $faker->numberBetween(10, 100),
        'baseball_pop_time'                 => $faker->numberBetween(10, 100),
        //'baseball_positions_played'         => $faker->randomElement(BaseballPositionsPlayed::toValueArray()),
        'baseball_rapsodo_member'           => "",
        'baseball_trackman_member'          => "",
        'baseball_blast_member'          => "",
        'baseball_saves'                    => $faker->numberBetween(10, 100),
        'baseball_so'                       => $faker->numberBetween(10, 100),
        'baseball_start_relieve'            => $faker->randomElement(BaseballStartRelieve::toValueArray()),
        'baseball_stolen_bases'             => $faker->numberBetween(10, 100),
        'baseball_strike_outs'              => $faker->numberBetween(10, 100),
        'baseball_throw_options'            => $faker->randomElement(BaseballThrowOptions::toValueArray()),
        'baseball_walks'                    => $faker->numberBetween(10, 100),

        'basketball_assists_per_game'       => $faker->numberBetween(10, 100),
        'basketball_blocks_per_game'        => $faker->numberBetween(10, 100),
        'basketball_field_throw_percentage' => $faker->numberBetween(10, 100),
        'basketball_points_per_game'        => $faker->numberBetween(10, 100),
        //'basketball_position'               => $faker->randomElement(BasketballPosition::toValueArray()),
        'basketball_rebounds_per_game'      => $faker->numberBetween(10, 100),
        'basketball_standing_reach'         => $faker->numberBetween(10, 100),
        'basketball_steals_per_game'        => $faker->numberBetween(10, 100),
        'basketball_vertical'               => $faker->numberBetween(10, 100),
        'basketball_wingspan'               => $faker->numberBetween(10, 100),

        'football_40_time'                 => $faker->numberBetween(10, 100),
        'football_bench_press'              => $faker->numberBetween(10, 100),
        'football_field_goal_percentage'  => $faker->numberBetween(10, 100),
        //'football_position_defense'         => $faker->randomElement(FootballPositionDefense::toValueArray()),
        //'football_position_offense'         => $faker->randomElement(FootballPositionOffense::toValueArray()),
        'football_special_teams'            => $faker->randomElement(FootballSpecialTeams::toValueArray()),
        'football_three_cone_drill'         => $faker->numberBetween(10, 100),
        'football_twenty_yard_shuttle'      => $faker->numberBetween(10, 100),
        'football_vertical'                 => $faker->numberBetween(10, 100),

        'tennis_left_handed'                => false,
        'tennis_right_handed'               => true,
        'tennis_star_recruit'               => $faker->randomElement(TennisStarRecruit::toValueArray()),
        'tennis_usta_ranking'               => $faker->numberBetween(2, 7),

        //'soccer_position'                   => $faker->numberBetween(10, 100),
    ];
});
