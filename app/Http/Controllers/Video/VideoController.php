<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Video;
use App\Models\User;
use App\Models\Rate;

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
        
        $positiveRates = $this->getPositiveRatesPercent($id);

        $creator = User::find($video->user_id);
        $data = ['video' => $video, 'creator' => $creator,'positiveRates' => $positiveRates];
        return view('videos.show')->with('data',$data);
    }

    public function edit(Request $request){
        
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'video_id' => 'required'
        ]);

        $video = Video::where([
            'user_id' => auth()->user()->id,
            'id' => $request->input('video_id')
        ])->first();
            
        if(!$video)
            return redirect('/account')->with('danger','Video not found');
        
        $video->title = $request->input('title');
        $video->description = $request->input('description');
        $video->save();
        return redirect('/account')->with('success','Video updated');
    }

    private function getPositiveRatesPercent($id){
        
        $positives = Rate::where([
            'video_id' => $id,
            'type' => 'L'
        ])->get()->count();
            
        $negatives = Rate::where([
            'video_id' => $id,
            'type' => 'D'
        ])->get()->count();
        
        if($positives+$negatives==0) return 0;
        return $positives/($positives+$negatives)*100;
    }
}
