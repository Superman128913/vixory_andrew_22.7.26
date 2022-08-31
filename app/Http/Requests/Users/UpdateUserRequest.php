<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Phone;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $coach = \Auth::user()->hasAnyRole(['coach', 'pro_scout']); //Also checks for pro_scouts
        $rules = [
            'profile_theme_id'          => ['nullable', 'integer'],
            'email'                     => ['required', 'string', 'max:255'],
            'first_name'                => ['nullable', 'string', 'max:255'],
            'last_name'                 => ['nullable', 'string', 'max:255'],
            'college_id'                => ['nullable'],
            'phone_number'              => ['nullable', new Phone($this->all()), 'string', 'max:255'],
            'age'                       => [$coach ? 'nullable' : 'required', 'integer', 'min:16', 'max:100'],
            'date_of_birth'             => ['nullable', 'string', 'max:255'],
            'profile_description'       => ['nullable', 'string'],
            'show_info'                 => ['nullable', 'boolean'],
            'sex'                       => [$coach ? 'nullable' : 'required', 'integer'],
            'height'                    => [$coach ? 'nullable' : 'required', 'string'],
            'weight'                    => [$coach ? 'nullable' : 'required', 'integer'],
            'school_year'               => ['nullable', 'integer'],
            'college_gpa'               => ['nullable', 'numeric'],
            'highschool_gpa'            => [$coach ? 'nullable' : 'required', 'numeric'],
            'sat'                       => ['nullable', 'integer'],
            'act'                       => ['nullable'],
            'address'                   => ['nullable', 'string', 'max:255'],
            'country'                   => ['nullable', 'string', 'max:255'],
            'city'                      => ['nullable', 'string', 'max:255'],
            'state'                     => ['nullable', 'integer', 'max:255'],
            'hometown'                  => ['nullable', 'string', 'max:255'],
            'highschool'                => [$coach ? 'nullable' : 'required', 'string', 'max:255'],
            'credit_hours_completed'    => ['nullable', 'integer'],
            'social_media_facebook'     => ['nullable', 'string', 'max:255'],
            'social_media_twitter'      => ['nullable', 'string', 'max:255'],
            'social_media_instagram'    => ['nullable', 'string', 'max:255'],
            'social_media_linkedin'     => ['nullable', 'string', 'max:255'],
            'playing_level'             => [$coach ? 'nullable' : 'required', 'integer'],
            'sports_selected'           => [$coach ? 'nullable' : 'required'],
            'notificationsettings'      => ['nullable'],

            //Relations
            'baseball_position'                 => ['nullable', 'array'],
            'basketball_position'               => ['nullable', 'array'],
            'football_position'                 => ['nullable', 'array'],
            'soccer_position'                   => ['nullable', 'array'],

            //Sport Data
            'baseball_60_yard_dash'             => ['nullable', 'numeric'],
            'baseball_bat_options'              => ['nullable', 'integer'],
            'baseball_batting_average'          => ['nullable', 'numeric'],
            'baseball_change_up_velo'           => ['nullable', 'numeric'],
            'baseball_curve_ball_velo'          => ['nullable', 'numeric'],
            'baseball_era'                      => ['nullable', 'numeric'], 
            'baseball_exit_velo'                => ['nullable', 'numeric'],
            'baseball_fast_ball_velo'           => ['nullable', 'numeric'],
            'baseball_holds'                    => ['nullable', 'numeric'],
            'baseball_hrs'                      => ['nullable', 'numeric'],
            'baseball_innings_pitched'          => ['nullable', 'numeric'],
            'baseball_losses'                   => ['nullable', 'numeric'],
            'baseball_obp'                      => ['nullable', 'numeric'],
            'baseball_pitcher_other'            => ['nullable', 'string'],
            'baseball_pop_time'                 => ['nullable', 'numeric'],
            'baseball_rapsodo_member'           => ['nullable', 'string'],
            'baseball_trackman_member'          => ['nullable', 'string'],
            'baseball_blast_member'             => ['nullable', 'string'],
            'baseball_saves'                    => ['nullable', 'numeric'],
            'baseball_wins'                     => ['nullable', 'numeric'],
            'baseball_so'                       => ['nullable', 'numeric'],
            'baseball_so_k9'                    => ['nullable', 'numeric'],
            'baseball_start_relieve'            => ['nullable', 'integer'],
            'baseball_stolen_bases'             => ['nullable', 'numeric'],
            'baseball_strike_outs'              => ['nullable', 'integer'],
            'baseball_throw_options'            => ['nullable', 'integer'],
            'baseball_walks'                    => ['nullable', 'numeric'],

            'basketball_assists_per_game'       => ['nullable', 'numeric'],
            'basketball_blocks_per_game'        => ['nullable', 'numeric'],
            'basketball_field_throw_percentage' => ['nullable', 'numeric'],
            'basketball_points_per_game'        => ['nullable', 'numeric'],
            'basketball_rebounds_per_game'      => ['nullable', 'numeric'],
            'basketball_standing_reach'         => ['nullable', 'numeric'],
            'basketball_steals_per_game'        => ['nullable', 'numeric'],
            'basketball_vertical'               => ['nullable', 'numeric'],
            'basketball_wingspan'               => ['nullable', 'numeric'],

            'football_40_time'                  => ['nullable', 'numeric'],
            'football_bench_press'              => ['nullable', 'numeric'],
            'football_special_teams'            => ['nullable', 'numeric'],
            'football_three_cone_drill'         => ['nullable', 'numeric'],
            'football_twenty_yard_shuttle'      => ['nullable', 'numeric'],
            'football_vertical'                 => ['nullable', 'numeric'],
            'football_field_goal_percentage'    => ['nullable', 'numeric'],

            'tennis_dominate_hand'              => ['nullable', 'integer'],
            'tennis_star_recruit'               => ['nullable', 'numeric'],
            'tennis_usta_ranking'               => ['nullable', 'integer'],

            'soccer_starter_or_non_starter'     => ['nullable', 'integer'],
            'soccer_goals'                      => ['nullable', 'numeric'],
            'soccer_assists'                    => ['nullable', 'numeric'],
            'soccer_shots_on_goal'              => ['nullable', 'numeric'],
            'soccer_shots_on_goal_percentage'   => ['nullable', 'numeric'],
            'soccer_pass_completion'            => ['nullable', 'numeric'],
            'soccer_5050_balls_won'             => ['nullable', 'numeric'],
            'soccer_time_played'                => ['nullable', 'numeric'],
            'soccer_saves'                      => ['nullable', 'numeric'],
            'soccer_save_percentage'            => ['nullable', 'numeric'],
            'soccer_shutouts'                   => ['nullable', 'numeric'],
            'soccer_time_played'                => ['nullable', 'numeric']
        ];
        return $rules;
    }
}
