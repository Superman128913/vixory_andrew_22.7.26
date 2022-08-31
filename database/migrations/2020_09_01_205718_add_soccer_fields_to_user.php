<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoccerFieldsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger("soccer_starter_or_non_starter");
            $table->unsignedInteger("soccer_goals");
            $table->unsignedInteger("soccer_assists");
            $table->unsignedInteger("soccer_shots_on_goal");
            $table->unsignedInteger("soccer_shots_on_goal_percentage");
            $table->unsignedInteger("soccer_pass_completion");
            $table->unsignedInteger("soccer_5050_balls_won");
            $table->unsignedInteger("soccer_saves");
            $table->unsignedInteger("soccer_save_percentage");
            $table->unsignedInteger("soccer_shutouts");
            $table->unsignedInteger("soccer_time_played");
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
            $table->dropColumn('soccer_starter_or_non_starter');
            $table->dropColumn('soccer_goals');
            $table->dropColumn('soccer_assists');
            $table->dropColumn('soccer_shots_on_goal');
            $table->dropColumn('soccer_shots_on_goal_percentage');
            $table->dropColumn('soccer_pass_completion');
            $table->dropColumn('soccer_5050_balls_won');
            $table->dropColumn('soccer_saves');
            $table->dropColumn('soccer_save_percentage');
            $table->dropColumn('soccer_shutouts');
            $table->dropColumn('soccer_time_played');
        });
    }
}
