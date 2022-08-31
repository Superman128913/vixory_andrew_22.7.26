<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlastToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('baseball_blast_member')->nullable();
            $table->text('baseball_rapsodo_member')->nullable()->change();
            $table->text('baseball_trackman_member')->nullable()->change();
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
            $table->dropColumn('baseball_blast_member');
            $table->string('baseball_rapsodo_member')->nullable()->change();
            $table->string('baseball_trackman_member')->nullable()->change();
        });
    }
}
