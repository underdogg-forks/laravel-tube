<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\VideoRepository;
use App\Libraries\FileNameMaker;

class UploadController extends Controller
{

    public function __construct(VideoRepository $videoRepo){
        $this->middleware('auth');
        $this->videoRepo = $videoRepo;
    }

    public function index(){
        return view('videos.upload');
    }

    public function store(Request $request){
        
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'video' => 'required'
        ]);
        
        $fileMaker = new FileNameMaker($request->file('video'));
    
        $this->videoRepo->create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'name' => $fileMaker->getFileNameToStore(),
            'thumbnail' => 'default.png'
        ]);
        
        $path = $request->file('video')->storeAs('public/videos',$fileMaker->getFileNameToStore());

        return redirect('/')->with('success','Your video has been uploaded');
    }

}
