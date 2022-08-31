<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToSportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sport_fields', function (Blueprint $table) {
            $table->string("mask")->nullable();
            $table->string("suffix")->nullable();
            $table->string("step")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sport_fields', function (Blueprint $table) {
            $table->dropColumn("mask");
            $table->dropColumn("suffix");
            $table->dropColumn("step");
        });
    }
}
