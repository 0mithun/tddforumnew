<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\ReplywasReported;
use App\Notifications\ThreadWasUpdated;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Support\Facades\App;

class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','lodReply']]);
    }

    /**
     * Fetch all relevant replies.
     *
     * @param int    $channelId
     * @param Thread $thread
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->where('parent_id', NULL)->paginate(20);
    }

    /**
     * Persist a new reply.
     *
     * @param  integer           $channelId
     * @param  Thread            $thread
     * @param  CreatePostRequest $form
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {

        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        return  $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');


    }

    public  function newReply(Reply $reply){
        request()->validate([
            'body'  =>  'required',
        ]);


        Reply::create([
            'body' => request('body'),
            'user_id' => auth()->id(),
            'thread_id' =>  $reply->thread_id,
            'parent_id' =>  $reply->id
        ]);
        return 'reply add hoise';
    }

    public function lodReply(Reply $reply){
        $nestedReply = Reply::where('parent_id', $reply->id)->get();

       return response()->json($nestedReply);

    }

    /**
     * Update an existing reply.
     *
     * @param Reply $reply
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(request()->validate(['body' => 'required|spamfree']));
    }

    /**
     * Delete the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    public function report(Reply $reply){
//        return $reply->body;
        $user = User::find(5);
        $reason = request('reason');
        $user->notify(new ReplywasReported($reply, $reason));

        return 'Thread Succssfully reported';
    }
}
