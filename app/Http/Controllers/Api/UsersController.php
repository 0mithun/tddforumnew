<?php

namespace App\Http\Controllers\Api;

use Algolia\AlgoliaSearch\Http\Psr7\Request;
use App\Http\Controllers\Controller;
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
}
