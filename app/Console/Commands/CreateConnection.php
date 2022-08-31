<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Models\Connection;

class CreateConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:connection {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new connection.';

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
        //Get the specified user
        $user_id = $this->argument('id');
        $user = User::findOrFail($user_id);

        //Get a random coach 
        $coach = User::whereHas("roles", function($q){ $q->where("name", "coach"); })->inRandomOrder()->first();

        //Create a connection between the two
        $connection = Connection::create([
            "user_id" => $coach->id,
            "requested_user_id" => $user->id,
            "accepted" => false
        ]);
    }
}
