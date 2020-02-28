<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSettingsController extends Controller
{


    public  function index(){
        $settings = auth()->user()->usersetting;
        return view('profiles.settings.notifications',compact('settings'));
    }

    public function update(Request $request){

        //return $request->all();
        auth()->user()->usersetting()->delete();
        auth()->user()->usersetting()->create($request->all());

        session()->flash('successmessage','Notification settings update successfully');
        return redirect()->route('user.settnigs', auth()->user()->username);
        //dd($request->all());
    }

//    public  function notifications(){
//        return view('profiles.settings.notifications');
//    }


}
