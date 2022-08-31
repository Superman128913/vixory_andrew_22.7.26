<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSportDataToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('baseball_throw_options')->nullable();
            $table->tinyInteger('baseball_bat_options')->nullable();
            $table->tinyInteger('baseball_positions_played')->nullable();
            $table->tinyInteger('baseball_outfield_position')->nullable();
            $table->integer('baseball_fast_ball_velo')->nullable();
            $table->integer('baseball_curve_ball_velo')->nullable();
            $table->integer('baseball_change_up_velo')->nullable();
            $table->string('baseball_pitcher_other')->nullable();
            $table->tinyInteger('baseball_start_relieve')->nullable();
            $table->integer('baseball_innings_pitched')->nullable();
            $table->integer('baseball_holds')->nullable();
            $table->integer('baseball_saves')->nullable();
            $table->integer('baseball_wins')->nullable();
            $table->integer('baseball_losses')->nullable();
            $table->integer('baseball_era')->nullable();
            $table->integer('baseball_walks')->nullable();
            $table->integer('baseball_strike_outs')->nullable();
            $table->integer('baseball_pop_time')->nullable();
            $table->integer('baseball_exit_velo')->nullable();
            $table->integer('baseball_batting_average')->nullable();
            $table->integer('baseball_hrs')->nullable();
            $table->integer('baseball_obp')->nullable();
            $table->integer('baseball_so')->nullable();
            $table->integer('baseball_stolen_bases')->nullable();
            $table->integer('baseball_60_yard_dash')->nullable();
            $table->string('baseball_rapsodo_member')->nullable();
            $table->string('baseball_trackman_member')->nullable();
            $table->integer('basketball_wingspan')->nullable();
            $table->tinyInteger('basketball_position')->nullable();
            $table->integer('basketball_standing_reach')->nullable();
            $table->integer('basketball_vertical')->nullable();
            $table->integer('basketball_points_per_game')->nullable();
            $table->integer('basketball_assists_per_game')->nullable();
            $table->integer('basketball_rebounds_per_game')->nullable();
            $table->integer('basketball_steals_per_game')->nullable();
            $table->integer('basketball_blocks_per_game')->nullable();
            $table->integer('basketball_field_goal_percentage')->nullable();
            $table->integer('basketball_field_throw_percentage')->nullable();
            $table->tinyInteger('football_position_offense')->nullable();
            $table->tinyInteger('football_position_defense')->nullable();
            $table->tinyInteger('football_special_teams')->nullable();
            $table->integer('football_40_time')->nullable();
            $table->integer('football_bench_press')->nullable();
            $table->integer('football_vertical')->nullable();
            $table->integer('football_three_cone_drill')->nullable();
            $table->integer('football_twenty_yard_shuttle')->nullable();
            $table->boolean('tennis_right_handed')->nullable()->default(true);
            $table->boolean('tennis_left_handed')->nullable()->default(false);
            $table->integer('tennis_usta_ranking')->nullable();
            $table->tinyInteger('tennis_star_recruit')->nullable();
            $table->tinyInteger('soccer_position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('baseball_throw_options');
            $table->dropColumn('baseball_bat_options');
            $table->dropColumn('baseball_positions_played');
            $table->dropColumn('baseball_outfield_position');
            $table->dropColumn('baseball_fast_ball_velo');
            $table->dropColumn('baseball_curve_ball_velo');
            $table->dropColumn('baseball_change_up_velo');
            $table->dropColumn('baseball_pitcher_other');
            $table->dropColumn('baseball_start_relieve');
            $table->dropColumn('baseball_innings_pitched');
            $table->dropColumn('baseball_holds');
            $table->dropColumn('baseball_saves');
            $table->dropColumn('baseball_wins');
            $table->dropColumn('baseball_losses');
            $table->dropColumn('baseball_era');
            $table->dropColumn('baseball_walks');
            $table->dropColumn('baseball_strike_outs');
            $table->dropColumn('baseball_pop_time');
            $table->dropColumn('baseball_exit_velo');
            $table->dropColumn('baseball_batting_average');
            $table->dropColumn('baseball_hrs');
            $table->dropColumn('baseball_obp');
            $table->dropColumn('baseball_so');
            $table->dropColumn('baseball_stolen_bases');
            $table->dropColumn('baseball_60_yard_dash');
            $table->dropColumn('baseball_rapsodo_member');
            $table->dropColumn('baseball_trackman_member');
            $table->dropColumn('basketball_wingspan');
            $table->dropColumn('basketball_position');
            $table->dropColumn('basketball_standing_reach');
            $table->dropColumn('basketball_vertical');
            $table->dropColumn('basketball_points_per_game');
            $table->dropColumn('basketball_assists_per_game');
            $table->dropColumn('basketball_rebounds_per_game');
            $table->dropColumn('basketball_steals_per_game');
            $table->dropColumn('basketball_blocks_per_game');
            $table->dropColumn('basketball_field_goal_percentage');
            $table->dropColumn('basketball_field_throw_percentage');
            $table->dropColumn('football_position_offense');
            $table->dropColumn('football_position_defense');
            $table->dropColumn('football_special_teams');
            $table->dropColumn('football_40_time');
            $table->dropColumn('football_bench_press');
            $table->dropColumn('football_vertical');
            $table->dropColumn('football_three_cone_drill');
            $table->dropColumn('football_twenty_yard_shuttle');
            $table->dropColumn('tennis_right_handed');
            $table->dropColumn('tennis_left_handed');
            $table->dropColumn('tennis_usta_ranking');
            $table->dropColumn('tennis_star_recruit');
            $table->dropColumn('soccer_position');
        });
    }
}
