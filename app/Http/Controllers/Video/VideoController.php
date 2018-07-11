<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Libraries\FileNameMaker;
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
        
        $rates = $this->rateRepo->deleteWhere(['video_id' => $video_id ]);
        $comments = $this->commentRepo->deleteWhere(['video_id' => $video_id]);
        $video->delete();
        return redirect('/account')->with('success','Video deleted');
    }

}
