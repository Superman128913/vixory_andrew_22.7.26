<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger("baseball_so_k9")->nullable()->change();
            $table->smallInteger('tennis_dominate_hand')->tinyInteger('tennis_dominate_hand')->nullable(true)->unsigned()->change();
            $table->unsignedInteger("soccer_starter_or_non_starter")->nullable()->change();
            $table->unsignedInteger("soccer_goals")->nullable()->change();
            $table->unsignedInteger("soccer_assists")->nullable()->change();
            $table->unsignedInteger("soccer_shots_on_goal")->nullable()->change();
            $table->unsignedInteger("soccer_shots_on_goal_percentage")->nullable()->change();
            $table->unsignedInteger("soccer_pass_completion")->nullable()->change();
            $table->unsignedInteger("soccer_5050_balls_won")->nullable()->change();
            $table->unsignedInteger("soccer_saves")->nullable()->change();
            $table->unsignedInteger("soccer_save_percentage")->nullable()->change();
            $table->unsignedInteger("soccer_shutouts")->nullable()->change();
            $table->unsignedInteger("soccer_time_played")->nullable()->change();
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
            $table->unsignedInteger("baseball_so_k9")->change();
            $table->smallInteger('tennis_dominate_hand')->tinyInteger('tennis_dominate_hand')->nullable(true)->unsigned()->change();
            $table->unsignedInteger("soccer_starter_or_non_starter")->change();
            $table->unsignedInteger("soccer_goals")->change();
            $table->unsignedInteger("soccer_assists")->change();
            $table->unsignedInteger("soccer_shots_on_goal")->change();
            $table->unsignedInteger("soccer_shots_on_goal_percentage")->change();
            $table->unsignedInteger("soccer_pass_completion")->change();
            $table->unsignedInteger("soccer_5050_balls_won")->change();
            $table->unsignedInteger("soccer_saves")->change();
            $table->unsignedInteger("soccer_save_percentage")->change();
            $table->unsignedInteger("soccer_shutouts")->change();
            $table->unsignedInteger("soccer_time_played")->change();
        });
    }
}
