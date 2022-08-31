<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateAge;

class TestAgeJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:age';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the age of all the users with a date of birth of xxxxxxx';

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
        UpdateAge::dispatch("16/11/1992");
    }
}
