<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Libraries\FileNameMaker;
use App\Repositories\VideoRepository;
use App\Repositories\UserRepository;
use App\Repositories\CommentRepository;

use App\Repositories\Rate\VideoRateRepository;
use App\Repositories\Rate\CommentRateRepository;


class VideoController extends Controller
{       
    public function __construct(VideoRepository $videoRepo,VideoRateRepository $videoRate, 
    UserRepository $userRepo, CommentRepository $commentRepo,CommentRateRepository $commentRate ){
        
        $this->videoRepo = $videoRepo;
        $this->videoRate = $videoRate;
        $this->commentRate = $commentRate;
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
            'likes' => $this->videoRate->countLikes($id),
            'dislikes' => $this->videoRate->countDislikes($id),
            'proportion' => $this->videoRate->getLikesPercentage($id),
            'comments' => $this->commentRepo->getVideoComments($id)
        ];

        return view('videos.show')->with('data',$data);
    }

    public function edit(Request $request){
        
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'video_id' => 'required',
            'thumbnail' => 'image|nullable|max:1999'
        ]);

        $video = $this->videoRepo->findAuth($request->input('video_id'));
            
        if(!$video)
            return redirect('/account')->with('danger','Video not found');
        
        $imageName = $video->thumbnail;

        if($request->hasFile('thumbnail')){
            if($imageName!='default.png')
                Storage::delete('public/thumbnails/'.$imageName);
            
            $imageNameMaker = new FileNameMaker($request->file('thumbnail'));
            $imageName = $imageNameMaker->getFileNameToStore();
            $path = $request->file('thumbnail')->storeAs('public/thumbnails',$imageName);
        }
        
        $video->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'thumbnail' => $imageName
        ]);
        
        return redirect('/account')->with('success','Video updated');
    }

    public function delete($video_id){
        
        $video = $this->videoRepo->findAuth($video_id);
        
        if(!$video)
            return redirect('/account')->with('danger','Video not found');

        Storage::delete('public/videos/'.$video->name);
        
        if($video->thumbnail!='default.png')
            Storage::delete('public/thumbnails/'.$video->thumbnail);
        
        $this->videoRate->deleteWhere(['video_id' => $video_id ]);
        $videoComments = $this->commentRepo->getWhere(['video_id' => $video_id]);
        
        foreach($videoComments as $comment){
            $this->commentRate->deleteWhere(['comment_id' => $comment->id]);
            $comment->delete();
        }
        
        $video->delete();
        return redirect('/account')->with('success','Video deleted');
    }

}
