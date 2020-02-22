<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use http\Env\Request;

class ProfilesController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  User $user
     * @return \Response
     */
    public function show($user)
    {
        $usredata = User::where('username', $user)->first();
           return view('profiles.show', [
            'profileUser' => $usredata,
            'activities' => Activity::feed($usredata)
        ]);
    }

    public function avatar(){
        return view('profiles.avatar');
    }

    public  function settings(){
        return view('profiles.settings');
    }

    public function avatarChange($user){
        request()->validate([
            'avatar' => ['required', 'image']
        ]);



        if(request()->has('avatar')){
            $avatar_path= auth()->user()->avatar_path;
            $path = 'uploads/'.request()->avatar->store('avatars');


            if(file_exists($avatar_path)){
                unlink($avatar_path);

                auth()->user()->update([
                    'avatar_path' => $path
                ]);
            }else{
                auth()->user()->update([
                    'avatar_path' => $path
                ]);
            }

        }
        return response()->json(['status'=>'success', 'message'=>'Avatar Change Successfully', 'avatar_path'=>asset($path)]);

    }
}
