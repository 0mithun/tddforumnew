<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Mail\ConfirmNewEmail;
use App\Thread;
use App\User;
use App\Usersetting;
use Illuminate\Http\Request;

use Carbon\Carbon;

use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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


    public function edit($user){
        $usre = auth()->user();

        return view('profiles.edit',compact('user'));


    }

    public  function  update(Request $request){
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.auth()->user()->id,
        ]);
        auth()->user()->update($request->only(['first_name','last_name','date_of_birth','city','country','about']));

        if(auth()->user()->email != $request->email){
            $token = md5(uniqid().str_random());
            DB::table('confirm_email')
                    ->insert([
                        'new_email'     =>  $request->email,
                        'user_id'       =>  auth()->user()->id,
                        'confirmation_token'    =>$token
                    ])
                ;
            $data = [
                'confirmation_token'    => $token
            ];
                Mail::to($request->email)->send(new ConfirmNewEmail($token));
            session()->flash('message','Your profile information update successfully. New email need to confirm');
        }

        session()->flash('message','Your profile information update successfully');

        return redirect()->route('profile', auth()->user()->username);
    }


    public  function confirmNewEmail(){
        $token = request('token');

        $data = DB::table('confirm_email')
                ->where('confirmation_token', $token)
                ->first()
            ;
        if($data){
           $old_email =  DB::table('users')
                ->where('email', $data->new_email)
                ->first()
            ;
           if($old_email){
               session()->flash('This email already taken');
               return redirect('/');
           }else{
               DB::table('users')
                   ->where('id', $data->user_id)
                   ->update([
                       'email'  =>  $data->new_email
                   ]);
               DB::table('confirm_email')->where('new_email', $data->new_email)->delete();

               session()->flash('New email update successfully');
               return redirect('/');
           }

        }else{
            session()->flash('Invalid Token');
            return redirect('/');
        }

    }

    public function editPassword(){
        return view('profiles.changepassword');
    }

    public function updatePassword(Request $request){

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ],[
            'password.required' =>  'The mew password field is required.',
            'password.min' =>  'The mew password must be at least 6 characters.',
        ]);

        $data = [];

        $user = auth()->user();

        $auth_user = DB::table('users')->where('id', $user->id)->first();


        if (Hash::check($request->old_password, $auth_user->password)) {
            $user->update([
                'password'  =>  bcrypt($request->password)
            ]);
            session()->flash('successmessage','Your password change successfully.');
            return redirect()->back();

        }else{
            session()->flash('errormessage','Your current password dose not match.');
            return redirect()->back();
        }




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
        return response()->json(['status'=>'success', 'message'=>'Avatar Change Successfully', 'avatar_path'=>asset($path)]);

    }

    public function mySubscriptionsShow(){

        $subscriptions = DB::table('thread_subscriptions')
                ->where('user_id', auth()->user()->id)
                ->get()

            ;

        return view('profiles.subscriptions', compact('subscriptions'));
    }

    public  function myFavoritesShow(){
        $user = auth()->user();

        $favorites = DB::table('favorites')
                ->where('user_id', $user->id)
                ->where('favorited_type','App\Thread')
                ->get()

            ;

//        dd($favorite);
        return view('profiles.favorites', compact('favorites'));
    }

    public function myThreadsShow(){
        $threads =Thread::where('user_id', auth()->user()->id)->get();

        return view('profiles.threads', compact('threads'));
    }

    public function myLikesShow(){
        $user = auth()->user();

        $likes = DB::table('likes')
            ->where('user_id', $user->id)
            ->where('likeable_type','App\Thread')
            ->get()

        ;

//        dd($favorite);
        return view('profiles.likes', compact('likes'));
    }
}
