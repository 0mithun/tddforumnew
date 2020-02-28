<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWasReported extends Notification
{
    use Queueable;

    protected  $reported_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reported_user)
    {
        $this->reported_user = $reported_user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $user = auth()->user();
        return [
//           'data' => "User " . $user->username . " ". " reported user " . $this->reported_user->username
            'message' => "User " . $user->username . " ". " reported user " . $this->reported_user->username,
            'link' => url('/threads?by='.$this->reported_user->username)
        ];

    }
}
