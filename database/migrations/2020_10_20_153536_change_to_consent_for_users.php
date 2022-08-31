<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeToConsentForUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("policy_and_fulfillment_accepted");
            $table->dropColumn("age_accepted");
            $table->boolean("consent_given");
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
            $table->boolean("policy_and_fulfillment_accepted");
            $table->boolean("age_accepted");
            $table->dropColumn("consent_given");
        });
    }
}
