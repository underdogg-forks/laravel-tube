<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Rate;
use Illuminate\Support\Facades\Storage;

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
        $video = Video::where([
            'id' => $video_id,
            'user_id' => auth()->user()->id    
        ])->first();
        
        if(!$video)
            return redirect('/account')->with('danger','Video not found');

        return view('videos.edit')->with('video',$video);
    }

    public function delete($video_id){
        
        $video = Video::where([
            'user_id' => auth()->user()->id,
            'id' => $video_id
        ])->first();
        
        if(!$video)
            return redirect('/account')->with('danger','Video not found');

        Storage::delete('public/videos/'.$video->name);
        $rates = Rate::where('video_id','=',$video_id)->delete();
        $video->delete();
        return redirect('/account')->with('success','Video deleted');
    }
}
