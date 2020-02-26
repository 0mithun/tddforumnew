<?php

namespace App\Http\Controllers;

use App\Mail\ContactToAdmin;
use App\Rules\Recaptcha;
use App\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;

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

    public function getTags(){
        return Tags::all();
    }


    public function tagLoad(Request $request){

        $term =  \request('q');

        if(empty($term)){
            return response()->json([]);
        }
        $tags = Tags::search($term)->limit(5)->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->name];
        }

        return \Response::json($formatted_tags);

    }

    public function allTags(){
        $tags = Tags::all();
        return response()->json($tags);
    }
}
