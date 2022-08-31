<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Traits\NotificationHelpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\Twilio\TwilioSmsMessage;

class SavedSearchResults extends Notification
{
    use Queueable, NotificationHelpers;

    private $saved_search;
    private $saved_search_url;
    private $new_user_count;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($saved_search, $new_user_count)
    {
        $this->saved_search = $saved_search;
        $this->saved_search_url = url('/search/' . $saved_search->id);
        $this->new_user_count = $new_user_count;
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
            ->content('From Vixory, do not reply.' . "\n" . "New athletes (" . $this->new_user_count . ") found that match your search criteria. " . url($this->saved_search_url));
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
                    ->greeting('New Athletes Matched')
                    ->action('View Saved Search', url($this->saved_search_url))
                    ->line('New athletes (' . $this->new_user_count . ') found that match your search criteria.');
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
            'new_user_count' => $this->new_user_count,
            'saved_search'  => $this->saved_search,
            'broadcast_message' => $this->new_user_count . " new users matched your saved search.",
            'broadcast_route_name' => "saved-search-view"
        ];
    }
}
