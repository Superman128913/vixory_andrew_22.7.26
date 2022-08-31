<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBasicUserFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("phone_number")->nullable();
            $table->tinyInteger("age")->nullable();
            $table->date("date_of_birth")->nullable();
            $table->tinyInteger("sex")->nullable();
            $table->integer("height")->nullable(); //Input in inches, accessors and mutators to handle feet
            $table->integer("weight")->nullable();
            $table->tinyInteger("school_year")->nullable(); //Dynamic, Freshman, Sophomore, etc
            $table->decimal("gpa")->nullable(); //e.g. 3.4
            $table->decimal("act")->nullable(); //e.g. 20.8
            $table->integer("sat")->nullable(); //e.g. 750 
            $table->string("country")->nullable();
            $table->string("hometown")->nullable();
            $table->string("highschool")->nullable();
            $table->integer("credit_hours_completed")->nullable();
            $table->boolean("degree_received")->nullable();

            $table->string("social_media_facebook")->nullable();
            $table->string("social_media_twitter")->nullable();
            $table->string("social_media_instagram")->nullable();
            $table->string("social_media_linkedin")->nullable();
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
            $table->dropColumn("phone_number");
            $table->dropColumn("age");
            $table->dropColumn("date_of_birth");
            $table->dropColumn("sex");
            $table->dropColumn("height");
            $table->dropColumn("weight");
            $table->dropColumn("school_year");
            $table->dropColumn("gpa");
            $table->dropColumn("act");
            $table->dropColumn("sat");
            $table->dropColumn("country");
            $table->dropColumn("hometown");
            $table->dropColumn("highschool");
            $table->dropColumn("credit_hours_completed");
            $table->dropColumn("degree_received");
            $table->dropColumn("social_media_facebook");
            $table->dropColumn("social_media_twitter");
            $table->dropColumn("social_media_instagram");
            $table->dropColumn("social_media_linkedin");
        });
    }
}
