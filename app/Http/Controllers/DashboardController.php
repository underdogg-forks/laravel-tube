<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Repositories\VideoRepository;
use App\Repositories\RateRepository;


class DashboardController extends Controller
{   
    public function __construct(VideoRepository $videoRepo, RateRepository $rateRepo){
        $this->middleware('auth');
        $this->videoRepo = $videoRepo;
        $this->rateRepo = $rateRepo;
    }

    public function index(){
        $videos = $this->videoRepo->getAuth();
        return view('account.index')->with('videos',$videos);
    }

    public function edit($video_id){
        $video = $this->videoRepo->findAuth($video_id);
        
        if(!$video)
            return redirect('/account')->with('danger','Video not found');

        return view('videos.edit')->with('video',$video);
    }

    public function delete($video_id){
        
        $video = $this->videoRepo->findAuth($video_id);
        
        if(!$video)
            return redirect('/account')->with('danger','Video not found');

        Storage::delete('public/videos/'.$video->name);
        
        if($video->thumbnail!='default.png')
            Storage::delete('public/thumbnails/'.$video->thumbnail);
        $rates = $this->rateRepo->deleteWhere('video_id','=',$video_id);
        $video->delete();
        return redirect('/account')->with('success','Video deleted');
    }
}
