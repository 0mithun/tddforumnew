<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
//use Symfony\Component\Console\Input\Input;

class ChannelController extends Controller
{

    public function search(){
        $qureystring = request()->channel_name;

        $channels = Channel::where('name', 'like', '%' .$qureystring. '%')->get();

        return $channels;


    }
}
