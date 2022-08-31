<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Traits\NotificationHelpers;

use NotificationChannels\Twilio\TwilioSmsMessage;

class TestBroadcast extends Notification
{
    use Queueable, NotificationHelpers;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return NotificationHelpers::notifiableChannels($notifiable);
    }



    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("New test message");
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('New Test Message');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'broadcast_message' => "Short sample message.",
            'broadcast_route_name' => "connections"
        ];
    }
}
