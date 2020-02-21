<?php

namespace App\Http\Controllers\Api;

use Algolia\AlgoliaSearch\Http\Psr7\Request;
use App\Http\Controllers\Controller;
use App\Notifications\UserWasReported;
use App\User;

class UsersController extends Controller
{
    /**
     * Fetch all relevant username.
     *
     * @return mixed
     */
    public function index()
    {
        $search = request('name');

        return User::where('name', 'LIKE', "%$search%")
            ->take(5)
            ->pluck('name');
    }

    public function user(Request $request){
        return $request->user();
    }

    public  function  report(){
        $reason = \request('reason');
        $user_id = \request('user_id');

        $user = User::findOrFail($user_id);

        $user->notify(new UserWasReported($user) );

        return 'reported user';

        return \request()->all();
    }
}
