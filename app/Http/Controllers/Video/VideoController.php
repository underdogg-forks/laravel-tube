<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\VideoRepository;
use App\Repositories\RateRepository;
use App\Repositories\UserRepository;
use App\Repositories\CommentRepository;


class VideoController extends Controller
{       
    public function __construct(VideoRepository $videoRepo,RateRepository $rateRepo, 
    UserRepository $userRepo, CommentRepository $commentRepo ){
        
        $this->videoRepo = $videoRepo;
        $this->rateRepo = $rateRepo;
        $this->userRepo = $userRepo;
        $this->commentRepo = $commentRepo;
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

        $data = [
            'video' => $video, 
            'creator' =>  $this->userRepo->find($video->user_id),
            'likes' => $this->rateRepo->countLikes($id),
            'dislikes' => $this->rateRepo->countDislikes($id),
            'proportion' => $this->rateRepo->getLikesPercentage($id),
            'comments' => $this->commentRepo->getVideoComments($id)
        ];
    
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
        
        $video->update([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);
        
        return redirect('/account')->with('success','Video updated');
    }

}
