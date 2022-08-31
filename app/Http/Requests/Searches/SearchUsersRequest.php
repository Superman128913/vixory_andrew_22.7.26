<?php

namespace App\Http\Requests\Searches;

use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        //If the user doesn't require approval or it's already approved.
        if($user && (!$user->requires_approval || $user->approval)) 
        {
            //If the user is a coach or a pro_scout (athletes cant search)
            if($user->hasRole(['coach', 'pro_scout'])) 
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //Sports Selected
            'sports_selected'            => ['nullable'],
            'sports_selected.key'        => ['nullable'],
            'sports_selected.value'      => ['nullable'],

            //User Fields
            'sex'                        => ['nullable'],
            'age_min'                    => ['nullable'],
            'age_max'                    => ['nullable'],
            'highschool_gpa_min'         => ['nullable'],
            'highschool_gpa_max'         => ['nullable'],
            'college_gpa_min'            => ['nullable'],
            'college_gpa_max'            => ['nullable'],
            'height_min'                 => ['nullable'],
            'height_max'                 => ['nullable'],
            'weight_min'                 => ['nullable'],
            'weight_max'                 => ['nullable'],
            'school_year'                => ['nullable'],
            'sat_min'                    => ['nullable'],
            'sat_max'                    => ['nullable'],
            'act_min'                    => ['nullable'],
            'act_max'                    => ['nullable'],
            'country'                    => ['nullable'],
            'city'                       => ['nullable'],
            'state'                      => ['nullable'],
            'hometown'                   => ['nullable'],
            'highschool'                 => ['nullable'],
            'credit_hours_completed_max' => ['nullable'],
            'credit_hours_completed_min' => ['nullable'],
            'playing_level'              => ['nullable'],
        
            //Baseball Fields
            'baseball_positions'                => ['nullable'],   
            'baseball_throw_options'            => ['nullable'],            
            'baseball_bat_options'              => ['nullable'],
            'baseball_positions_played'         => ['nullable'],
            'baseball_outfield_position'        => ['nullable'],            
            'baseball_fast_ball_velo_min'       => ['nullable'],        
            'baseball_fast_ball_velo_max'       => ['nullable'], 
            'baseball_curve_ball_velo_min'      => ['nullable'],        
            'baseball_curve_ball_velo_max'      => ['nullable'],    
            'baseball_change_up_velo_min'       => ['nullable'],       
            'baseball_change_up_velo_max'       => ['nullable'],    
            'baseball_start_relieve_min'        => ['nullable'], 
            'baseball_start_relieve_max'        => ['nullable'],
            'baseball_innings_pitched_min'      => ['nullable'],
            'baseball_innings_pitched_max'      => ['nullable'],
            'baseball_holds_min'                => ['nullable'],
            'baseball_holds_max'                => ['nullable'],
            'baseball_saves_min'                => ['nullable'],
            'baseball_saves_max'                => ['nullable'],
            'baseball_wins_min'                 => ['nullable'],
            'baseball_wins_max'                 => ['nullable'],
            'baseball_losses_min'               => ['nullable'],
            'baseball_losses_max'               => ['nullable'],
            'baseball_era_min'                  => ['nullable'],
            'baseball_era_max'                  => ['nullable'],
            'baseball_walks_min'                => ['nullable'],
            'baseball_walks_max'                => ['nullable'],
            'baseball_pop_time_min'             => ['nullable'],
            'baseball_pop_time_max'             => ['nullable'],
            'baseball_exit_velo_min'            => ['nullable'],
            'baseball_exit_velo_max'            => ['nullable'],
            'baseball_batting_average_min'      => ['nullable'],
            'baseball_batting_average_max'      => ['nullable'],
            'baseball_hrs_min'                  => ['nullable'],
            'baseball_hrs_max'                  => ['nullable'],
            'baseball_obp_min'                  => ['nullable'],
            'baseball_obp_max'                  => ['nullable'],
            'baseball_so_min'                   => ['nullable'],
            'baseball_so_max'                   => ['nullable'],
            'baseball_so_k9_min'                => ['nullable'],
            'baseball_so_k9_max'                => ['nullable'],
            'baseball_stolen_bases_min'         => ['nullable'],
            'baseball_stolen_bases_max'         => ['nullable'],
            'baseball_60_yard_dash_min'         => ['nullable'],
            'baseball_60_yard_dash_min'         => ['nullable'],

            //Basketball Fields
            'basketball_wingspan_min'               => ['nullable'],
            'basketball_wingspan_max'               => ['nullable'],
            'basketball_position'                   => ['nullable'],
            'basketball_standing_reach_min'         => ['nullable'],
            'basketball_standing_reach_max'         => ['nullable'],
            'basketball_vertical_min'               => ['nullable'],
            'basketball_vertical_max'               => ['nullable'],
            'basketball_points_per_game_min'        => ['nullable'],
            'basketball_points_per_game_max'        => ['nullable'],
            'basketball_assists_per_game_min'       => ['nullable'],
            'basketball_assists_per_game_max'       => ['nullable'],
            'basketball_rebounds_per_game_min'      => ['nullable'],
            'basketball_rebounds_per_game_max'      => ['nullable'],
            'basketball_steals_per_game_min'        => ['nullable'],
            'basketball_steals_per_game_max'        => ['nullable'],
            'basketball_blocks_per_game_min'        => ['nullable'],
            'basketball_blocks_per_game_max'        => ['nullable'],
            'basketball_field_throw_percentage_min' => ['nullable'],
            'basketball_field_throw_percentage_max' => ['nullable'],

            //Football Fields
            'football_position_offense'         => ['nullable'],
            'football_position_defense'         => ['nullable'],
            'football_special_teams'            => ['nullable'],
            'football_40_time_min'              => ['nullable'],
            'football_40_time_max'              => ['nullable'],
            'football_bench_press_min'          => ['nullable'],
            'football_bench_press_max'          => ['nullable'],
            'football_vertical_min'             => ['nullable'],
            'football_vertical_max'             => ['nullable'],
            'football_three_cone_drill_min'     => ['nullable'],
            'football_three_cone_drill_max'     => ['nullable'],
            'football_twenty_yard_shuttle_min'  => ['nullable'],
            'football_twenty_yard_shuttle_max'  => ['nullable'],
            'football_field_goal_percentage_min'  => ['nullable'],
            'football_field_goal_percentage_max'  => ['nullable'],

            //Tennis Fields
            'tennis_dominate_hand'                  => ['nullable'],
            'tennis_usta_ranking_min'               => ['nullable'],
            'tennis_usta_ranking_max'               => ['nullable'],
            'tennis_star_recruit'                   => ['nullable'],

            //Soccer Fields
            'soccer_position'                       => ['nullable'],
            'soccer_starter_or_non_starter_min'     => ['nullable'],
            'soccer_starter_or_non_starter_max'     => ['nullable'],
            'soccer_goals_min'                      => ['nullable'],
            'soccer_goals_max'                      => ['nullable'],
            'soccer_assists_min'                    => ['nullable'],
            'soccer_assists_max'                    => ['nullable'],
            'soccer_shots_on_goal_min'              => ['nullable'],
            'soccer_shots_on_goal_max'              => ['nullable'],
            'soccer_shots_on_goal_percentage_min'   => ['nullable'],
            'soccer_shots_on_goal_percentage_max'   => ['nullable'],
            'soccer_pass_completion_min'            => ['nullable'],
            'soccer_pass_completion_max'            => ['nullable'],
            'soccer_5050_balls_won_min'             => ['nullable'],
            'soccer_5050_balls_won_max'             => ['nullable'],
            'soccer_time_played_min'                => ['nullable'],
            'soccer_time_played_max'                => ['nullable'],
            'soccer_saves_min'                      => ['nullable'],
            'soccer_saves_max'                      => ['nullable'],
            'soccer_save_percentage_min'            => ['nullable'],
            'soccer_save_percentage_max'            => ['nullable'],
            'soccer_shutouts_min'                   => ['nullable'],
            'soccer_shutouts_max'                   => ['nullable'],
            'soccer_time_played_min'                => ['nullable'],
            'soccer_time_played_max'                => ['nullable'],
        ];
    }
}
