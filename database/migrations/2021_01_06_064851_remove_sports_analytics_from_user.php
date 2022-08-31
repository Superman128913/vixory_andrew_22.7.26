<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSportsAnalyticsFromUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('baseball_rapsodo_member');
            $table->dropColumn('baseball_trackman_member');
            $table->dropColumn('baseball_blast_member');
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
            $table->text('baseball_rapsodo_member')->nullable();
            $table->text('baseball_trackman_member')->nullable();
            $table->text('baseball_blast_member')->nullable();
        });
    }
}
