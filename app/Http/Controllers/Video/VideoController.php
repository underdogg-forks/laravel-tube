<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\VideoRepository;
use App\Repositories\RateRepository;

use App\Models\User;

class VideoController extends Controller
{   
    private $videoRepo;
    
    public function __construct(VideoRepository $videoRepo,RateRepository $rateRepo){
        $this->videoRepo = $videoRepo;
        $this->rateRepo = $rateRepo;
    }
    
    public function search(Request $request){
        
        $title =  $request->input('title');
        $videos = $this->videoRepo->getVideosWithTitle($title);

        if($videos->isEmpty()) 
            return redirect('/')->with('danger','No videos of title "'.$title.'" found');

         else
            return view('videos.list')->with('videos',$videos);
    }

    public function show($id){
        
        $video = $this->videoRepo->find($id);
        if(!$video)
            return redirect('/')->with('danger','Video of id '.$id. 'not found');
        
        $likes = $this->getLikesPercentage($id);

        $creator = User::find($video->user_id);
        $data = ['video' => $video, 'creator' => $creator,'likes' => $likes];
        return view('videos.show')->with('data',$data);
    }

    public function edit(Request $request){
        
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'video_id' => 'required'
        ]);

        $video = $this->videoRepo->findAuth($request->input('video_id'));
            
        if(!$video)
            return redirect('/account')->with('danger','Video not found');
        
        $video->title = $request->input('title');
        $video->description = $request->input('description');
        $video->save();
        return redirect('/account')->with('success','Video updated');
    }

    private function getLikesPercentage($id){
        
        $likes = $this->rateRepo->countLikes($id);
        $dislikes = $this->rateRepo->countDislikes($id);
        
        if($likes+$dislikes==0) return 0;
        
        return $likes/($likes+$dislikes)*100;
    }
}
