<?php

namespace Bigpxl\UserApproval\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AthleteCollegeOverride;

use \App\User;
use \App\Models\College;

class UserApprovalController
{
    public function getUnapprovedCoaches()
    {
        $users = User::where('requires_approval', true)->role(["coach", "pro_scout"])->with('roles')->get();
        return response()->json($users, 200);
    }

    public function getUnapprovedAthletes()
    {
        $users = User::where('requires_approval', true)->role("athlete")->get();
        return response()->json($users, 200);
    }

    public function approveAthlete(Request $request, User $user)
    {
        //Approve the user
        $user->requires_approval = false;
        $user->approval = true;

        if($request->overide_id) 
        {
            //Set the users college to whatever the admin selected.
            $user->college_id = $request->overide_id;

            //Fire off notification to user
            Notification::send($user, new AthleteCollegeOverride($user));
        }
        else 
        {
            //Create a new college and set the user to that collge.
            $college = new College();
            $college->name = $user->manual_college_entry;
            $college->save();

            $user->college_id = $college->id;
        }

        //Save the user. For some reason I have to unset the append attribute for state_name. 
        unset($user->state_name);
        $user->save();

        //Return user & college as response
        $data = new \stdClass();
        if(isset($college)) {
            $data->college = $college;
        }
        $data->user = $user;

        return response()->json($data, 200);
    }

    /**
     * Search database of colleges and return potential.
     */
    public function searchCollege(Request $request)
    {
        $q = $request->q;
        $colleges = College::search($q)->get();
        
        return response()->json($colleges, 200);
    }

    /**
     * Approve a coach.
     */
    public function approveCoach(Request $request, User $user)
    {
        $user->requires_approval = false; //Since they're approved, they no longer require approval.
        $user->approval = true;
    
        //If a college_id isn't set we need to create the college
        if($user->hasRole('coach') && !$user->college_id) {
            $college = new College();
            $college->name = $user->manual_college_entry;
            $college->save();

            //Add the user too the college.
            $user->college_id = $college->id;
        }
        
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Reject a coach.
     */
    public function rejectCoach(Request $request, User $user)
    {
        $user->requires_approval = false; //Since they're rejected, they no longer require an admin to choose to approve/reject them.
        $user->approval = false;
        $user->save();

        return response()->json($user, 200);
    }
}
