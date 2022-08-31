<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Notifications\TestBroadcast;

class GenerateNewBroadcastNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new broadcast notification for the specified user.';

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
        $userId = $this->argument('user');
        $user = User::find($userId);
        $user->notify(new TestBroadcast());

        return 0;
    }
}
