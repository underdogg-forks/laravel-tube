<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($video_id){
        return 'like';
    }

    public function dislike($video_id){
        return 'dislike';
    }
}
