<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Likes;
use App\Thread;
use Illuminate\Http\Request;

use DB;

class LikeController extends Controller
{
    public  function store($thread){
        $thread = Thread::findOrFail($thread);
        return $thread->like();
    }

    public function destroy($thread){
        $thread = Thread::findOrFail($thread);
        return $thread->unlike();
    }
}
