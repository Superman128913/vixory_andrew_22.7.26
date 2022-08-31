<?php

namespace App\Traits;

use NotificationChannels\Twilio\TwilioChannel;

trait NotificationHelpers
{
    public static function notifiableChannels($notifiable)
    {
        $settings = $notifiable->notificationsettings;

        $channel_array = array("broadcast", "database");
        foreach($settings as $setting)
        {
            switch($setting->name)
            {
                case "Email":
                    $channel_array[] = "mail";
                    break;
                case "SMS":
                    $channel_array[] = TwilioChannel::class;
                    break;
            }
        }

        return $channel_array;
    }
}