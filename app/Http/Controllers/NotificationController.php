<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function getUnread(Request $request, User $user)
    {
        /**
         * Get all notifications that have been created within past XX days. This has to be a pretty
         * high number or we would risk not retrieving notification
         */
        $user_id = $user->id;
        $earliestDate = Carbon::now()->subDays(14);
        $notifications = DB::table('notifications')
            ->where("notifiable_id", "=", $user_id)
            ->whereDate('created_at', '>=', $earliestDate)
            ->orWhere(function($query) use (&$user_id){
                $query->where("notifiable_id", "=", $user_id);
                $query->whereNull('read_at');
            })
            ->latest()
            ->get();

        foreach($notifications as $notification) 
        {
            $notification->data = json_decode($notification->data);
        }

        return response()->json($notifications, 200);
    }

    public function markAsRead(Request $request, User $user)
    {
        $user->unreadNotifications->markAsRead();
        return response()->json("Notifications marked as read.", 200);
    }
}
