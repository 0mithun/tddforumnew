<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Tags;
use App\Thread;
use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function tags(){
        return view('pages.admin.tags');
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

    public function privacyPolicy(){
        $adminInfo = Admin::first();
        return view('pages.admin.privacypolicy',compact('adminInfo'));
    }

    public function tos(){
        $adminInfo = Admin::first();
        return view('pages.admin.tos', compact('adminInfo'));
    }

    public function faq(){
        $adminInfo = Admin::first();
        return view('pages.admin.faq',compact('adminInfo'));
    }


    public function tosUpdate(){
        \request()->validate([
            'body'   =>  'required'
        ]);

        $admin = Admin::first();

        $admin->tos = \request('body');
        $admin->save();

        session()->flash('successmessage','Tos Information Update Successfully');
        return redirect()->back();
    }

    public function privacyPolicyUpdate(){
        \request()->validate([
            'body'   =>  'required'
        ]);

        $admin = Admin::first();

        $admin->privacypolicy = \request('body');
        $admin->save();

        session()->flash('successmessage','Tos Information Update Successfully');
        return redirect()->back();
    }

    public function faqUpdate(){
        \request()->validate([
            'body'   =>  'required'
        ]);

        $admin = Admin::first();

        $admin->faq = \request('body');
        $admin->save();

        session()->flash('successmessage','Faq Information Update Successfully');
        return redirect()->back();

    }


    public function siteSettings(){
        $admin = Admin::first();
        return view('pages.admin.sitesettings', compact('admin'));
    }

    public function siteSettingsUpdate(){
        \request()->validate([
            'app_name'   =>  'required',
            'mail_driver'   =>  'required',
            'mail_host'   =>  'required',
            'mail_port'   =>  'required',
            'username'   =>  'required',
            'password'   =>  'required',
            'mail_encryption'   =>  'required',
            'copyright'   =>  'required',
            'timezone'   =>  'required',
        ]);

        $admin = Admin::first();

        $admin->update(request()->all());

        session()->flash('successmessage','Admin Settings Update Successfully');

        return redirect()->route('admin.setesettings');
    }
}
