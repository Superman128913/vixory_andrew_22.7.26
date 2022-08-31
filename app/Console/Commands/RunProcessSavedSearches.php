<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessSavedSearches;

class RunProcessSavedSearches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process-saved-search:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all of the saved searches for today.';

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
        ProcessSavedSearches::dispatch();
        return 0;
    }
}
