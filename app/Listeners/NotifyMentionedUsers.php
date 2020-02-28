<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Mail\PleaseConfirmYourEmail;
use App\Notifications\YouWereMentioned;
use App\Notifications\YouWereMentionedEmail;
use App\User;

use App\Usersetting;
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
                $usersettings = $user->usersetting;
                if($usersettings->mention_notify_anecdotage ==1){
                    $user->notify(new YouWereMentioned($event->reply));
                }
                if($usersettings->mention_notify_email ==1){
                    $user->notify(new YouWereMentionedEmail($event->reply));
                }
            }
        }
//        User::whereIn('name', $event->reply->mentionedUsers())
//            ->get()
//            ->each(function ($user) use ($event) {
//                $user->notify(new YouWereMentioned($event->reply));
//            });
    }
}
