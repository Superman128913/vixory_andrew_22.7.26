<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SplitGpaInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("gpa");
            $table->decimal("highschool_gpa")->nullable();
            $table->decimal("college_gpa")->nullable();
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
            $table->decimal("gpa")->nullable();
            $table->dropColumn("college_gpa");
            $table->dropColumn("highschool_gpa");
        });
    }
}
