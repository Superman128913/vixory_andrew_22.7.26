<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\TestEmail;
use App\User;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to an admin.';

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
        $user = User::where("email", "mark@bigpxl.com")->first();
        Mail::to($user->email)->send(new TestEmail());
    }
}
