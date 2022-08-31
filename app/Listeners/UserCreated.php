<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserCreated as UserCreatedEvent;

use App\Models\NotificationSetting;

class UserCreated
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        //Perform any setup logic for the user.
        $notification_setting = NotificationSetting::where('name', '=', 'Email')->first();
        $user = $event->user;
        $user->notificationsettings()->attach($notification_setting->id);
    }
}
