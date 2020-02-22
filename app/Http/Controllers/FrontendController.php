<?php

namespace App\Http\Controllers;

use App\Mail\ContactToAdmin;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class FrontendController extends Controller
{


    public function contact(){
        return view('pages.contact');
    }

    public function tos(){
        return view('pages.tos');
    }

    public function faq(){
        return view('pages.faq');
    }

    public  function privacyPolicy(){
        return view('pages.privacypolicy');
    }

    public  function  contactAdmin(Recaptcha $recaptcha){

        request()->validate([
            'from'      =>  'required',
            'subject'   =>  'required',
            'body'      =>  'required',
            'g-recaptcha-response' => ['required', $recaptcha],
        ],
            [
            'g-recaptcha-response.required' =>  'Please solve the captcha'
        ]);

        $data =  request()->only(['from','subject','body']);

       Mail::to('admin@anecdotage.com')->send(new ContactToAdmin($data));
        return  'Contact Successfully';
    }
}
