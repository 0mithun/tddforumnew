<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplywasReported extends Notification
{
    use Queueable;

    protected $reply;
    protected $reason;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reply, $reason)
    {
        $this->reply = $reply;
        $this->reason = $reason;
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
            //'reply_id'  =>  $this->reply->id,
//            'data' => "User " .$user->username .  " reported a reply by " . $this->reply->owner->username.' because: '.$this->reason

            'message' => "User " .$user->username .  " reported a reply by " . $this->reply->owner->username.' because: '.$this->reason,
            'link' => $this->reply->path()
        ];


    }
}
