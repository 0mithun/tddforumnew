<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Rules\Recaptcha;
use App\Thread;
use App\Trending;

class ThreadsController extends Controller
{
    /**
     * Create a new ThreadsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Channel      $channel
     * @param ThreadFilters $filters
     * @param \App\Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Rules\Recaptcha $recaptcha
     * @return \Illuminate\Http\Response
     */
    public function store(Recaptcha $recaptcha)
    {


        if(request()->hasFile('image_path')){
            $rule = 'image|max:1024';
        }else{
            $rule = '';
        }


        request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required', $recaptcha],
            'image_path'    => $rule

        ],[
            'channel_id.required'    => 'The channel field is required.',
            'channel_id.exists'    => 'Invalid channel',
            'g-recaptcha-response.required' =>  'Please solve the captcha'
        ]);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
            'location'  =>  request('location'),
            'source'  =>  request('source'),
            'main_subject'  =>  request('main_subject'),
            'is_famous'  =>  request('is_famous'),

        ]);

        $file_path = '';
        if (request()->hasFile('image_path')) {
            $extension = request()->file('image_path')->getClientOriginalExtension();
            $file_name = $thread->id.".".$extension;
            $file_path = request()->image_path->storeAs('threads', $file_name);

        }else{
            $file_path = 'baler image ';
        }

        $thread->image_path= 'uploads/'. $file_path;
        $thread->save();

        $thread = $thread->fresh();


        if (request()->wantsJson()) {
            return response($thread, 201);
        }

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer      $channel
     * @param  \App\Thread  $thread
     * @param \App\Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread, Trending $trending)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->increment('visits');

        return view('threads.show', compact('thread'));
    }

    /**
     * Update the given thread.
     *
     * @param string $channel
     * @param Thread $thread
     */
    public function update($channel, Thread $thread)
    {
        dd(request()->all());

        exit;
        $this->authorize('update', $thread);

       if(request()->hasFile('image_path')){
            $rule = 'image|max:1024';
        }else{
            $rule = '';
        }
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'image_path'    => $rule

        ]);

        $data = [
            'title' => request('title'),
            'channel_id'    => request('channel_id'),
            'body' => request('body'),
            'location'  =>  request('location'),
            'source'  =>  request('source'),
            'main_subject'  =>  request('main_subject'),
            'is_famous'  =>  (request('is_famous') == 'true')  ? 1 : 0,
        ];

        if (request()->hasFile('image_path')) {
            $extension = request()->file('image_path')->getClientOriginalExtension();
            $file_name = $thread->id.".".$extension;
            $file_path = request()->image_path->storeAs('threads', $file_name);
            $data['image_path']  = $file_path;
        }

        $thread->update($data);

        return $thread;
    }

    /**
     * Delete the given thread.
     *
     * @param        $channel
     * @param Thread $thread
     * @return mixed
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(25);
    }
}
