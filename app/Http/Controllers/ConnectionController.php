<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Connections\AcceptConnectionRequest;
use App\Http\Requests\Connections\RejectConnectionRequest;
use App\Http\Requests\Connections\RequestConnectionRequest;

use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

use App\User;
use App\Notifications\ConnectionRequested;
use App\Notifications\ConnectionDeclined;
use App\Notifications\ConnectionAccepted;
use App\Models\Connection;

class ConnectionController extends Controller
{
    public function list()
    {
        $user = \Auth::user();

        if(\Auth::user()->hasRole(['coach', 'pro_scout'])) 
        {
            $connections = Connection::where("user_id", $user->id)->with('athlete')->get();

            foreach($connections as $connection)
            {
                if(! $connection->accepted) 
                {
                    $connection->athlete->hideContactInfo();
                }
            }
        }
        else 
        {
            $connections = Connection::where("requested_user_id", $user->id)->with('sender', 'sender.roles', 'sender.college')->get();
        }

        return response()->json($connections, 200);
    }

    public function create(RequestConnectionRequest $request)
    {
        $fields = $request->validated();

        //Get the active user and the requested user
        $active_user = \Auth::user();
        $requested_user = User::where("id", "=", $fields["requested_user_id"])->firstOrFail();

        //Check to make sure this connection doesn't already exist
        $connection = Connection::where([
            ["requested_user_id", "=", $fields["requested_user_id"]],
            ["user_id", "=", $active_user->id]
        ])->first();

        if(!$connection)
        {
            //Create the connection
            $fields["user_id"] = $active_user->id;
            $fields["requests_sent"] = 1;
            $connection = Connection::create($fields);
        
            //Generate the request notification
            Notification::send($requested_user, new ConnectionRequested($active_user));
        }
        else 
        {
            //Calculate the connection limits
            $now = Carbon::now();
            $last_sent = Carbon::createFromDate($connection->request_last_sent);
            $days_since = $last_sent->diffInDays($now);

            $notification_total_limit = config('connection.total_limit'); //Total number of notifications that can be spawned from a connection request.
            $notification_frequency_limit = config('connection.frequency_limit'); //Number of days that has to elapse before a new notification will generate.

            //If total limit is not exceeded, and the frequency limit is fine, send another notification.
            if($connection->requests_sent <= $notification_total_limit && $days_since >= $notification_frequency_limit) 
            {
                //Generate the request notification
                Notification::send($requested_user, new ConnectionRequested($active_user));

                //Increment the connection limits
                $connection->requests_sent++;
                $connection->request_last_sent = $now;
                $connection->save(); 
            }
        
        }

        return response()->json($connection, 200);
    }

    public function acceptConnection(AcceptConnectionRequest $request, Connection $connection)
    {
        $fields = $request->validated();

        //Get the requesting user
        $requesting_user = User::findOrFail($connection->user_id);

        //Update the connection
        $connection->accepted = true;
        $connection->save();

        //Generate a notification alerting the user who requested the connection
        Notification::send($requesting_user, new ConnectionAccepted(\Auth::user()));

        return response()->json($connection, 200);
    }

    public function rejectConnection(RejectConnectionRequest $request, Connection $connection)
    {
        $fields = $request->validated();

        //For now at least, we're not going to notify the coach of rejections to keep things upbeat. Discussed in internal meeting.
        //Notification::send(\Auth::user()->email, new ConnectionDeclined());

        $connection->delete();

        return response()->json($connection, 200);
    }
}
