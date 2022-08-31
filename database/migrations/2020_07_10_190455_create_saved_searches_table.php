<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_searches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id");
            $table->json("criteria")->nullable(); //json string which contains all of the search options
            $table->json("sports")->nullable();

            //Saved searches are run on the same day of the week that they were created.
            //This is done to space out the frequency that searches have to be re-run and 
            //has the added benefit of spacing out notifications to something resonable.
            $table->unsignedInteger("day_of_the_week"); 

            $table->unsignedInteger("recent_count")->nullable(); //the number of users which match the most recent search
            $table->unsignedInteger("previous_count")->nullable(); //the number of users which matched the previous search
            $table->dateTime("last_ran")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_searches');
    }
}
