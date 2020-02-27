<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class UserAvatarController extends Controller
{
    /**
     * Store a new user avatar.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'avatar' => ['required', 'image']
        ]);

        

        if(request()->has('avatar')){
           $avatar_path= auth()->user()->avatar_path;
            $path = 'uploads/'.request()->avatar->store('avatars');


            if(file_exists($avatar_path)){
                if(!$avatar_path == 'images/avatars/default.png'){
                    unlink($avatar_path);
                }

                auth()->user()->update([
                    'avatar_path' => $path
                ]);
            }else{
                auth()->user()->update([
                    'avatar_path' => $path
                ]);
            }

        }


        return response([], 204);
    }
}
