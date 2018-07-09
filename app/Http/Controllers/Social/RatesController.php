<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\VideoRepository;
use App\Repositories\RateRepository;

class RatesController extends Controller
{   
    public function __construct(VideoRepository $videoRepo, RateRepository $rateRepo){
        $this->middleware('auth');
        $this->videoRepo = $videoRepo;
        $this->rateRepo = $rateRepo;
    }

    public function like($video_id){
        
        if(!$this->videoRepo->find($video_id))
            return redirect('/')->with('danger','Video not found');

        if($this->rateRepo->alreadyLiked($video_id)){
            $this->rateRepo->deleteRate($video_id);
            return redirect('/video/'.$video_id)->with('success','You no longer like this video !');
        }

        else if($this->rateRepo->alreadyDisliked($video_id)){
            $this->rateRepo->deleteRate($video_id);
        }
        
        $this->rateRepo->createAuthLike($video_id);

        return redirect('/video/'.$video_id)->with('success','You just liked this video !');
    }

    public function dislike($video_id){
        
        if(!$this->videoRepo->find($video_id))
            return redirect('/')->with('danger','Video not found');

        if($this->rateRepo->alreadyDisliked($video_id)){
            $this->rateRepo->deleteRate($video_id);
            return redirect('/video/'.$video_id)->with('success','You no longer dislike this video !');
        }

        else if($this->rateRepo->alreadyLiked($video_id)){
            $this->rateRepo->deleteRate($video_id);
        }
        
        $this->rateRepo->createAuthDislike($video_id);

        return redirect('/video/'.$video_id)->with('success','You just disliked this video !');
    }
}
