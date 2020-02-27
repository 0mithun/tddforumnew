<?php

namespace App\Filters;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ThreadFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['by', 'popular', 'unanswered','viewed','recents','liked','rated','bestofweek','favorites'];

    /**
     * Filter the query by a given username.
     *
     * @param  string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function by($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * Filter the query according to those that are unanswered.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }

    public function viewed(){
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('visits','desc');
    }

    public function recents(){
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('created_at','desc');
    }

    public function liked(){
        $user = auth()->user();
        $likes = DB::table('likes')
//            ->where('user_id', $user->id)
            ->where('up',1)
            ->where('likeable_type','App\Thread')
            ->get()
        ;
        $likeThreadId = [];

        foreach ($likes as $like){
            $likeThreadId[] = $like->likeable_id;
        }

        return $this->builder->whereIn('id', $likeThreadId)->orderBy('created_at','desc');
    }

    public function rated(){
    //        likes_count / (dislikes_count+1)
        $this->builder->getQuery()->orders = [];
            $threads = DB::table('threads')
                    ->where('like_count','>',0)
                    ->orderBy('like_count','desc')
                    ->get()
            ;
        $filterThread = [];
        foreach ($threads as $thread){
            $like = $thread->like_count;
            $dislike = $thread->dislike_count;

            $formula = $like>$dislike+1;
            if($formula){
                $filterThread[] = $thread->id;
            }
        }
        return $this->builder->whereIn('id', $filterThread)->orderBy('like_count','desc');
    }

    public function bestofweek(){
        $days = Carbon::now()->subDays(7)->toDateTimeString();
        $likes = DB::table('likes')
             ->where('created_at','<=',$days)
            ->where('likeable_type','App\Thread')
            ->get()
        ;

        $likesId = [];

        foreach ($likes as $like){
            $likesId[] = $like->likeable_id;
        }

        $threads = DB::table('threads')->whereIn('id',$likesId)->get();

        $filterThread = [];
        foreach ($threads as $thread){

            $like = $thread->like_count;
            $dislike = $thread->dislike_count;
            if($like>$dislike){
                $filterThread[] = $thread->id;
            }
        }
        return $this->builder->whereIn('id', $filterThread)->orderBy('created_at','desc');
    }



    public function favorites(){
        $user = auth()->user();
        $favorites = DB::table('favorites')
                ->where('user_id', $user->id)
                ->where('favorited_type','App\Thread')
                ->get()
            ;
        $favoriteThreadId = [];

        foreach ($favorites as $favorite){
            $favoriteThreadId[] = $favorite->favorited_id;
        }

        return $this->builder->whereIn('id', $favoriteThreadId)->orderBy('created_at','desc');

    }
}
