<?php

namespace App\Http\Controllers;

use App\Notifications\ReplywasReported;
use App\Notifications\ThreadWasReported;
use App\Notifications\UserWasReported;
use Illuminate\Http\Request;
use App\Reply;
use App\User;
use App\Thread;
use DB;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function reply(Reply $reply){
//
        $user = User::find(5);

        DB::table('reports')->insert([
            'user_id'           =>  auth()->id(),
            'reported_id'       =>  $reply->id,
            'reported_type'     =>  get_class($reply)
        ]);

        $reason = request('reason');
        $user->notify(new ReplywasReported($reply, $reason));

        return 'Thread Succssfully reported';
    }


    public  function  user(){
        $reason = \request('reason');
        $user_id = \request('user_id');
        $user = User::findOrFail($user_id);

        DB::table('reports')->insert([
            'user_id'           =>  auth()->id(),
            'reported_id'       =>  $user_id,
            'reported_type'     =>  get_class($user)
        ]);


        $user->notify(new UserWasReported($user) );
    }


    public function thread(){
        $id = \request('id');
        $reason = \request('reason');
        $thread = Thread::findOrFail($id);

        DB::table('reports')->insert([
            'user_id'           =>  auth()->id(),
            'reported_id'       =>  $id,
            'reported_type'     =>  get_class($thread)
        ]);

        $thread->notify(new ThreadWasReported($thread, $reason));
    }

}
