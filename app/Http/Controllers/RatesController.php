<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\Video;

class RatesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($video_id){
        
        if(!Video::find($video_id))
            return redirect('/')->with('danger','Video not found');

        if($this->alreadyLiked($video_id)){
            Rate::where('video_id','=',$video_id)->delete();
            return redirect('/video/'.$video_id)->with('success','You no longer like this video !');
        }

        else if($this->alreadyDisliked($video_id)){
            Rate::where('video_id','=',$video_id)->delete();
        }
        
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

        if($this->alreadyDisliked($video_id)){
            Rate::where('video_id','=',$video_id)->delete();
            return redirect('/video/'.$video_id)->with('success','You no longer dislike this video !');
        }

        else if($this->alreadyLiked($video_id)){
            Rate::where('video_id','=',$video_id)->delete();
        }
        
        Rate::create([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'D'
        ]);

        return redirect('/video/'.$video_id)->with('success','You just disliked this video !');
    }

    private function alreadyLiked($video_id){
        
        if(Rate::where([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'L'    
        ])->get()->count() >0 ) return true;

        else return false;
    }

    private function alreadyDisliked($video_id){
        
        if(Rate::where([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'D'    
        ])->get()->count() >0 ) return true;

        else return false;
    }
}
