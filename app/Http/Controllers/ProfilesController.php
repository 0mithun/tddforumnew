<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;

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
}
