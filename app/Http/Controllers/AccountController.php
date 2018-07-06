<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class AccountController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $videos = Video::where('user_id','=',auth()->user()->id)->get();
        return view('account.index')->with('videos',$videos);
    }

    public function edit($video_id){
        //
    }

    public function delete($video_id){
        //
    }
}
