<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCollegeSelected extends Notification
{
    use Queueable;

    public $athlete;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->athlete = $user;
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
        $name = $this->athlete->first_name . ' ' . $this->athlete->last_name;

        return (new MailMessage)
                    ->greeting('New College')
                    ->line($name . ' selected a college not in the database and requires admin approval before showing in search.')
                    ->action('Go To Admin', $url);
    }
}
