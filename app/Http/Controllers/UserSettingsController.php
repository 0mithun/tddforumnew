<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSettingsController extends Controller
{


    public  function index(){
        return view('profiles.settings.index');
    }

    public  function notifications(){
        return view('profiles.settings.notifications');
    }

    public  function subscriptions(){
        return view('profiles.settings.subscriptions');
    }
}
