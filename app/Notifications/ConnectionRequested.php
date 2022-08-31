<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Traits\NotificationHelpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\Twilio\TwilioSmsMessage;

class ConnectionRequested extends Notification
{
    use Queueable, NotificationHelpers;

    public $coach;
    public $connection_url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($coach)
    {
        $this->coach = $coach;
        $this->connection_url = url('/account/connections/');
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('New Connection Request')
                    ->line('New connection requested by ' . $this->coach->name . ".")
                    ->action('Go To Connections', $this->connection_url);
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content('From Vixory, do not reply.' . "\n" . "New connection requested by " . $this->coach->name . ". " . url($this->connection_url));
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
            'coach_name'        => $this->coach->name,
            'connection_url'    => $this->connection_url,
            'broadcast_message' => 'New connection requested by ' . $this->coach->name . ".",
            'broadcast_route_name' => "connections",
        ];
    }
}
