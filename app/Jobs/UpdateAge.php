<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;
use App\User;

class UpdateAge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($date = null)
    {
        if(! $date) {
            $this->date = Carbon::now();
        }
        else {
            $this->date = Carbon::createFromFormat('d/m/Y', $date); //11/06/1990
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Get all users of the specified date (or today if not specified).
        $users = User::whereDate('date_of_birth', $this->date)->get();

        foreach($users as $user)
        {
            $age = $user->date_of_birth->age;
            $user->age = $age;
            $user->update();
        }
    }
}
