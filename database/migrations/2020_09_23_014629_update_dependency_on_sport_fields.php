<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDependencyOnSportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sport_fields', function (Blueprint $table) {
            $table->dropColumn("dependent_on_value");
            $table->dropColumn("dependent_on");

            $table->bigInteger("dependent_on_id")->nullable();
            $table->string("dependent_on_key")->nullable();
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
            $table->string("dependent_on_value")->nullable();
            $table->string("dependent_on")->nullable()->change();

            $table->dropColumn("dependent_on_id");
            $table->dropColumn("dependent_on_key");
        });
    }
}
