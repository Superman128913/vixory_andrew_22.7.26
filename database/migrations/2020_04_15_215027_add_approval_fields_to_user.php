<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalFieldsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean("approval")->default(true);
            $table->boolean("requires_approval")->default(false);
            $table->string("manual_college_entry");
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
            if (Schema::hasColumn('users', 'approval'))
            {
                $table->dropColumn("approval");
                $table->dropColumn("requires_approval");
                $table->dropColumn("manual_college_entry");
            }
        });
    }
}
