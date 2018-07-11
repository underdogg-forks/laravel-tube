<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\VideoRepository;


class DashboardController extends Controller
{   
    public function __construct(VideoRepository $videoRepo){
        
        $this->middleware('auth');
        $this->videoRepo = $videoRepo;
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
}
