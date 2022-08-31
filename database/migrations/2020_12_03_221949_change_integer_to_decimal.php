<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIntegerToDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal("baseball_60_yard_dash", 8, 2)->nullable()->change();
            $table->decimal("baseball_batting_average", 8, 3)->nullable()->change();
            $table->decimal("baseball_change_up_velo", 8, 2)->nullable()->change();
            $table->decimal("baseball_curve_ball_velo", 8, 2)->nullable()->change();
            $table->decimal("baseball_era", 8, 2)->nullable()->change();
            $table->decimal("baseball_exit_velo", 8, 2)->nullable()->change();
            $table->decimal("baseball_fast_ball_velo", 8, 2)->nullable()->change();
            $table->decimal("baseball_holds", 8, 2)->nullable()->change();
            $table->decimal("baseball_hrs", 8, 2)->nullable()->change();
            $table->decimal("baseball_innings_pitched", 8, 2)->nullable()->change();
            $table->decimal("baseball_losses", 8, 2)->nullable()->change();
            $table->decimal("baseball_obp", 8, 4)->nullable()->change();
            $table->decimal("baseball_pop_time", 8, 2)->nullable()->change();
            $table->decimal("baseball_saves", 8, 2)->nullable()->change();
            $table->decimal("baseball_wins", 8, 2)->nullable()->change();
            $table->decimal("baseball_so", 8, 2)->nullable()->change();
            $table->decimal("baseball_so_k9", 8, 2)->nullable()->change();
            $table->decimal("baseball_stolen_bases", 8, 2)->nullable()->change();
            $table->decimal("baseball_walks", 8, 2)->nullable()->change();

            $table->decimal("basketball_assists_per_game", 8, 2)->nullable()->change();
            $table->decimal("basketball_blocks_per_game", 8, 2)->nullable()->change();
            $table->decimal("basketball_field_throw_percentage", 8, 2)->nullable()->change();
            $table->decimal("basketball_points_per_game", 8, 2)->nullable()->change();
            $table->decimal("basketball_rebounds_per_game", 8, 2)->nullable()->change();
            $table->decimal("basketball_standing_reach", 8, 2)->nullable()->change();
            $table->decimal("basketball_steals_per_game", 8, 2)->nullable()->change();
            $table->decimal("basketball_vertical", 8, 2)->nullable()->change();
            $table->decimal("basketball_wingspan", 8, 2)->nullable()->change();

            $table->decimal("football_40_time", 8, 2)->nullable()->change();
            $table->decimal("football_bench_press", 8, 2)->nullable()->change();
            $table->decimal("football_special_teams", 8, 2)->nullable()->change();
            $table->decimal("football_three_cone_drill", 8, 2)->nullable()->change();
            $table->decimal("football_twenty_yard_shuttle", 8, 2)->nullable()->change();
            $table->decimal("football_vertical", 8, 2)->nullable()->change();
            $table->decimal("football_field_goal_percentage", 8, 2)->nullable()->change();

            $table->decimal("tennis_star_recruit", 8, 2)->nullable()->change();

            $table->decimal("soccer_goals", 8, 2)->nullable()->change();
            $table->decimal("soccer_assists", 8, 2)->nullable()->change();
            $table->decimal("soccer_shots_on_goal", 8, 2)->nullable()->change();
            $table->decimal("soccer_shots_on_goal_percentage", 8, 2)->nullable()->change();
            $table->decimal("soccer_pass_completion", 8, 2)->nullable()->change();
            $table->decimal("soccer_5050_balls_won", 8, 2)->nullable()->change();
            $table->decimal("soccer_time_played", 8, 2)->nullable()->change();
            $table->decimal("soccer_saves", 8, 2)->nullable()->change();
            $table->decimal("soccer_save_percentage", 8, 2)->nullable()->change();
            $table->decimal("soccer_shutouts", 8, 2)->nullable()->change();
            $table->decimal("soccer_time_played", 8, 2)->nullable()->change();
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
            $table->integer("baseball_60_yard_dash")->nullable()->change();
            $table->integer("baseball_batting_average")->nullable()->change();
            $table->integer("baseball_change_up_velo")->nullable()->change();
            $table->integer("baseball_curve_ball_velo")->nullable()->change();
            $table->integer("baseball_era")->nullable()->change();
            $table->integer("baseball_exit_velo")->nullable()->change();
            $table->integer("baseball_fast_ball_velo")->nullable()->change();
            $table->integer("baseball_holds")->nullable()->change();
            $table->integer("baseball_hrs")->nullable()->change();
            $table->integer("baseball_innings_pitched")->nullable()->change();
            $table->integer("baseball_losses")->nullable()->change();
            $table->integer("baseball_obp")->nullable()->change();
            $table->integer("baseball_pop_time")->nullable()->change();
            $table->integer("baseball_saves")->nullable()->change();
            $table->integer("baseball_wins")->nullable()->change();
            $table->integer("baseball_so")->nullable()->change();
            $table->integer("baseball_so_k9")->nullable()->change();
            $table->integer("baseball_stolen_bases")->nullable()->change();
            $table->integer("baseball_walks")->nullable()->change();
            $table->integer("basketball_assists_per_game")->nullable()->change();
            $table->integer("basketball_blocks_per_game")->nullable()->change();
            $table->integer("basketball_field_throw_percentage")->nullable()->change();
            $table->integer("basketball_points_per_game")->nullable()->change();
            $table->integer("basketball_rebounds_per_game")->nullable()->change();
            $table->integer("basketball_standing_reach")->nullable()->change();
            $table->integer("basketball_steals_per_game")->nullable()->change();
            $table->integer("basketball_vertical")->nullable()->change();
            $table->integer("basketball_wingspan")->nullable()->change();
            $table->integer("football_40_time")->nullable()->change();
            $table->integer("football_bench_press")->nullable()->change();
            $table->integer("football_special_teams")->nullable()->change();
            $table->integer("football_three_cone_drill")->nullable()->change();
            $table->integer("football_twenty_yard_shuttle")->nullable()->change();
            $table->integer("football_vertical")->nullable()->change();
            $table->integer("football_field_goal_percentage")->nullable()->change();
            $table->integer("tennis_star_recruit")->nullable()->change();
            $table->integer("soccer_goals")->nullable()->change();
            $table->integer("soccer_assists")->nullable()->change();
            $table->integer("soccer_shots_on_goal")->nullable()->change();
            $table->integer("soccer_shots_on_goal_percentage")->nullable()->change();
            $table->integer("soccer_pass_completion")->nullable()->change();
            $table->integer("soccer_5050_balls_won")->nullable()->change();
            $table->integer("soccer_time_played")->nullable()->change();
            $table->integer("soccer_saves")->nullable()->change();
            $table->integer("soccer_save_percentage")->nullable()->change();
            $table->integer("soccer_shutouts")->nullable()->change();
            $table->integer("soccer_time_played")->nullable()->change();
        });
    }
}
