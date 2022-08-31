<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sport_fields', function (Blueprint $table) {
            $table->boolean("search_visible")->default(true);
            $table->integer("filter_type")->default(11);
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
            $table->dropColumn("search_visible");
            $table->dropColumn("filter_type");
        });
    }
}
