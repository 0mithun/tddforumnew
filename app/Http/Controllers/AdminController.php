<?php

namespace App\Http\Controllers;

use App\Tags;
use App\Thread;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function tags(){
        return view('pages.tags');
    }

    public function tagsAdd(){
        \request()->validate([
            'name'      =>  'required'
        ]);

         $tags = Tags::create(\request()->all());
         //$thread = Thread::first();
         //$thread->tags()->syncWithoutDetaching(1);
//        dd($thread->tags);
        //return $thread->tags;
    }

    public function tagsUpdate(){
        \request()->validate([
            'name'      =>  'required'
        ]);

        $id = request('id');
        $name = request('name');

        $tag = Tags::findOrFail($id);

        $tag->update([
            'name'  =>  $name
        ]);
    }
}
