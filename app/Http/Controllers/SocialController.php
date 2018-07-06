<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\Video;

class SocialController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($video_id){
        
        if(!Video::find($video_id))
            return redirect('/')->with('danger','Video not found');

        Rate::create([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'L'
        ]);

        return redirect('/video/'.$video_id)->with('success','You just liked this video !');
    }

    public function dislike($video_id){
        
        if(!Video::find($video_id))
            return redirect('/')->with('danger','Video not found');

        Rate::create([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'D'
        ]);

        return redirect('/video/'.$video_id)->with('success','You just disliked this video !');
    }
}
