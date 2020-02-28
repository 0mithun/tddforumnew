<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Likes;
use App\Thread;
use Illuminate\Http\Request;

use DB;

class LikeController extends Controller
{


    public function like($thread){
        $thread = Thread::findOrFail($thread);
        if($thread->isLiked()){
            $thread->decrement('like_count');
            return $thread->unlike();
        }else{
            if($thread->isDesliked()){
                $thread->decrement('dislike_count');
                $thread->unlike();
                return $thread->like();
            }
            return $thread->like();
        }

    }

    public function dislike($thread){

        $thread = Thread::findOrFail($thread);

        if($thread->isDesliked()){
            $thread->decrement('dislike_count');
            return $thread->unlike();
        }else{
            if($thread->isLiked()){
                $thread->decrement('like_count');
                $thread->unlike();
                return $thread->disLike();
            }
            return $thread->disLike();
        }
    }

}
