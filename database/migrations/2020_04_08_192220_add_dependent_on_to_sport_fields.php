<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDependentOnToSportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sport_fields', function (Blueprint $table) {
            $table->string("dependent_on")->nullable();
            $table->string("dependent_on_value")->nullable();
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
            $table->dropColumn("dependent_on");
            $table->dropColumn("dependent_on_value");
        });
    }
}
