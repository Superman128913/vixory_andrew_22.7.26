<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePositionsFromUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('baseball_positions_played');
            $table->dropColumn('basketball_position');
            $table->dropColumn('football_position_offense');
            $table->dropColumn('football_position_defense');
            $table->dropColumn('soccer_position');
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
            $table->tinyInteger('baseball_positions_played')->nullable();
            $table->tinyInteger('basketball_position')->nullable();
            $table->tinyInteger('football_position_offense')->nullable();
            $table->tinyInteger('football_position_defense')->nullable();
            $table->tinyInteger('soccer_position')->nullable();
        });
    }
}
