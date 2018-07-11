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
            'video' => 'required',
            'thumbnail' => 'image|nullable|max:1999'
        ]);

        $imageName =  'default.png';

        if($request->hasFile('thumbnail')){
            $imageNameMaker = new FileNameMaker($request->file('thumbnail'));
            $imageName = $imageNameMaker->getFileNameToStore();
            $path = $request->file('thumbnail')->storeAs('public/thumbnails',$imageName);
        }
        
        $videoNameMaker = new FileNameMaker($request->file('video'));
        
        $videoName = $videoNameMaker->getFileNameToStore();

        $this->videoRepo->create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'name' => $videoName,
            'thumbnail' => $imageName
        ]);
        
        $path = $request->file('video')->storeAs('public/videos',$videoName);

        return redirect('/account')->with('success','Your video has been uploaded');
    }    

}
