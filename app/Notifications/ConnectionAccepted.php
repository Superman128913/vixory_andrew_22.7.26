<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Traits\NotificationHelpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\Twilio\TwilioSmsMessage;

class ConnectionAccepted extends Notification
{
    use Queueable, NotificationHelpers;

    public $connection_url;
    public $athlete;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($athlete){
        $this->athlete = $athlete;
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
            ->greeting('Connection Accepted')
            ->line($this->athlete->name . " accepted your connection request!")
            ->action('Go To Connections', url('/account/connections/'));
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content('From Vixory, do not reply.' . "\n" . $this->athlete->name . " accepted your connection request! " . url($this->connection_url));
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
            'athlete_name'      => $this->athlete->name,
            'connection_url'    => $this->connection_url,
            'broadcast_message' => $this->athlete->name . " accepted your connection request!",
            'broadcast_route_name' => "connections",
        ];
    }
}
