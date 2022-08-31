<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CoachRegistered extends Notification
{
    use Queueable;

    public $coach;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->coach = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/admin/user-approval');
        $name = $this->coach->first_name . ' ' . $this->coach->last_name;

        return (new MailMessage)
                    ->greeting('New Coach Registered')
                    ->line($name . ' registered and requires admin approval to access search functionality.')
                    ->action('Go To Admin', $url);
    }
}
