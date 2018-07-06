<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
