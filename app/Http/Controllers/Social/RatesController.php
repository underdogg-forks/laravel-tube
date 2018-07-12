<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\VideoRepository;
use App\Repositories\CommentRepository;

use App\Repositories\Rate\VideoRateRepository;
use App\Repositories\Rate\CommentRateRepository;

class RatesController extends Controller
{   
    public function __construct(VideoRepository $videoRepo, VideoRateRepository $videoRate,
    CommentRateRepository $commentRate, CommentRepository $commentRepo){
        
        $this->middleware('auth');
        $this->videoRepo = $videoRepo;
        $this->commentRepo = $commentRepo;
        $this->videoRate = $videoRate;
        $this->commentRate= $commentRate;
    }

    public function likeVideo($video_id){
        
        if(!$this->videoRepo->find($video_id))
            return redirect('/')->with('danger','Video not found');

        if($this->videoRate->alreadyLiked($video_id)){
            $this->videoRate->deleteRateAuth($video_id);
            return redirect('/video/'.$video_id)->with('success','You no longer like this video !');
        }

        else if($this->videoRate->alreadyDisliked($video_id)){
            $this->videoRate->deleteRateAuth($video_id);
        }
        
        $this->videoRate->createAuthLike($video_id);

        return redirect('/video/'.$video_id)->with('success','You just liked this video !');
    }

    public function dislikeVideo($video_id){
        
        if(!$this->videoRepo->find($video_id))
            return redirect('/')->with('danger','Video not found');

        if($this->videoRate->alreadyDisliked($video_id)){
            $this->videoRate->deleteRateAuth($video_id);
            return redirect('/video/'.$video_id)->with('success','You no longer dislike this video !');
        }

        else if($this->videoRate->alreadyLiked($video_id)){
            $this->videoRate->deleteRateAuth($video_id);
        }
        
        $this->videoRate->createAuthDislike($video_id);

        return redirect('/video/'.$video_id)->with('success','You just disliked this video !');
    }

    public function likeComment($comment_id){
        
        if(!$this->commentRepo->find($comment_id))
            return redirect('/')->with('danger','Comment not found');

        $video_id = $this->commentRepo->find($comment_id)->video_id;
        
        if($this->commentRate->alreadyLiked($comment_id)){
            $this->commentRate->deleteRateAuth($comment_id);
            return redirect('/video/'.$video_id)->with('success','You no longer like this comment !');
        }

        else if($this->commentRate->alreadyDisliked($comment_id)){
            $this->commentRate->deleteRateAuth($comment_id);
        }
        
        $this->commentRate->createAuthLike($comment_id);

        return redirect('/video/'.$video_id)->with('success','You just liked this comment !');
    }

    public function dislikeComment($comment_id){
        
        if(!$this->commentRepo->find($comment_id))
            return redirect('/')->with('danger','Comment not found');

        $video_id = $this->commentRepo->find($comment_id)->video_id;

        if($this->commentRate->alreadyDisliked($comment_id)){
            $this->commentRate->deleteRateAuth($comment_id);
            return redirect('/video/'.$video_id)->with('success','You no longer dislike this comment !');
        }

        else if($this->commentRate->alreadyLiked($comment_id)){
            $this->commentRate->deleteRateAuth($comment_id);
        }
        
        $this->commentRate->createAuthDislike($comment_id);

        return redirect('/video/'.$video_id)->with('success','You just disliked the comment !');
    }
}
