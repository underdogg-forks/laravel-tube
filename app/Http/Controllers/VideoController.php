<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;

class VideoController extends Controller
{
    public function search(Request $request){
        
        $title =  $request->input('title');
        $videos = Video::where('title','LIKE','%'.$title.'%')->get();

        if($videos->isEmpty()) 
            return redirect('/')->with('danger','No videos of title "'.$title.'" found');
        
         else
            return view('videos.list')->with('videos',$videos);
    }

    public function show($id){
        
        $video = Video::find($id);
        if(!$video)
            return redirect('/')->with('danger','Video of id '.$id. 'not found');
        $creator = User::find($video->user_id);
        $data = ['video' => $video, 'creator' => $creator];
        return view('videos.show')->with('data',$data);
    }
}
