<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\SavedSearch;
use App\Jobs\RunSavedSearch;

class ProcessSavedSearches implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Query DB to get a full list of jobs that need to be processed today.
        $day_of_week = date('N');

        $saved_searches = SavedSearch::where([
            "day_of_the_week"   =>  $day_of_week
        ])->get();

        //Iterate through jobs and call RunSavedSearch.
        foreach($saved_searches as $saved_search)
        {
            RunSavedSearch::dispatch($saved_search);
        }
    }
}
