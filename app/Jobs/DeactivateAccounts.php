<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Mail\ReviewRequested;
use Mail;

class DeactivateAccounts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $auto_deactivate;
    private $auto_deactivate_days;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auto_deactivate = config("app.auto_deactivate");
        $this->auto_deactivate_days = config("app.auto_deactivate_days");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->auto_deactivate)
        {
            //Deactivate all users with a last_login of more than 60 days ago.
            $users = User::whereDate("last_login", "<", Carbon::now()->subDays($this->auto_deactivate_days))->get();
            foreach($users as $user)
            {
                //Deactivate user
                $user->is_deactivated = true;
                $user->save();

                //Send user review email
                Mail::to($user)->send(new ReviewRequested());
            }
        }
    }
}
