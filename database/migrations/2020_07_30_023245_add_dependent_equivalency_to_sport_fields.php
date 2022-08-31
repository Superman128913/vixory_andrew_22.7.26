<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDependentEquivalencyToSportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sport_fields', function (Blueprint $table) {
            $table->boolean("dependent_equivalency")->default(true);
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
            $table->dropColumn("dependent_equivalency");
        });
    }
}
