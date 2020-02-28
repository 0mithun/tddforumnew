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
        request()->validate([
            'reason'    =>  'required'
        ]);
        $user = User::find(1);

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
        $user = User::find(1);

//        $user = User::find(1);
        DB::table('reports')->insert([
            'user_id'           =>  auth()->id(),
            'reported_id'       =>  $user_id,
            'reported_type'     =>  'App\User'
        ]);


        $user->notify(new UserWasReported($user) );
    }


    public function thread(){

        request()->validate([
            'reason'    =>  'required'
        ]);

        $id = \request('id');
        $reason = \request('reason');
        $thread = Thread::findOrFail($id);

        DB::table('reports')->insert([
            'user_id'           =>  auth()->id(),
            'reported_id'       =>  $id,
            'reported_type'     =>  get_class($thread)
        ]);

        $user = User::find(1);
        $user->notify(new ThreadWasReported($thread, $reason));
    }

}
