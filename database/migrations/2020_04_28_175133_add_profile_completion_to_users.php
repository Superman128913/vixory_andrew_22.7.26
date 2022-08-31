<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileCompletionToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean("profile_status_complete")->default(false);
            $table->boolean("profile_status_verified")->default(false);
            $table->boolean("profile_status_basic")->default(false);
            $table->boolean("profile_status_sports")->default(false);
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
            $table->dropColumn("profile_status_complete");            
            $table->dropColumn("profile_status_verified");
            $table->dropColumn("profile_status_basic");
            $table->dropColumn("profile_status_sports");            
        });
    }
}
