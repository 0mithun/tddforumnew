<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Mail\PleaseConfirmYourEmail;
use App\Notifications\YouWereMentioned;
use App\User;

use DB;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        //dd($event->reply->mentionedUsers());


        preg_match_all('/@([\w\-]+)/', $event->reply->body, $matches);
        //dd($matches);

        foreach ($matches[1] as $name){
            if($user = User::where('first_name', $name)->first()){
                $user->notify(new YouWereMentioned($event->reply));
            }
        }
//        User::whereIn('name', $event->reply->mentionedUsers())
//            ->get()
//            ->each(function ($user) use ($event) {
//                $user->notify(new YouWereMentioned($event->reply));
//            });
    }
}
