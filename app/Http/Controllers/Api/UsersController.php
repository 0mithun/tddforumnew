<?php

namespace App\Http\Controllers\Api;

use Algolia\AlgoliaSearch\Http\Psr7\Request;
use App\Http\Controllers\Controller;
use App\Notifications\UserWasReported;
use App\User;

use DB;
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
//        return [
//          'hello',
//          'world'
//        ];
//        return User:: where('name', 'LIKE', "%$search%")
//            ->take(5)
//            ->pluck('name')->toArray();
        //full_name
     return   DB::table("users")
            ->select("id", DB::raw("CONCAT(first_name, ' ', last_name) as name"))
//            ->where("students_class_id", $id)
                ->where('name', 'LIKE', "%$search%")
            ->pluck("name");
            ;
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
