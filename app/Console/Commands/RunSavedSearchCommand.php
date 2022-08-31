<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SavedSearch;
use App\Jobs\RunSavedSearch;

class RunSavedSearchCommand extends Command
{
    // e.g. php artisan saved-search:run 6

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // php artisan saved-search:run 7
    protected $signature = 'saved-search:run {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a specific saved search immiediately.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $saved_search_id = $this->argument('id');

        $saved_search = SavedSearch::findOrFail($saved_search_id);
        RunSavedSearch::dispatch($saved_search, true);

        return 0;
    }
}
