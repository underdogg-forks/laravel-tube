<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CommentRepository;
use App\Repositories\VideoRepository;

class CommentsController extends Controller
{
    public function __construct(CommentRepository $commentRepo, VideoRepository $videoRepo){
        $this->middleware('auth');
        $this->commentRepo = $commentRepo;
        $this->videoRepo = $videoRepo;
    }

    public function store(Request $request){
        
        $this->validate($request,[
            'content' => 'required',
            'video_id' => 'required'
        ]);
        
        if(!$this->videoRepo->find($request->input('video_id')))
            return redirect('/')->with('danger','Video not found');
        
        $this->commentRepo->create([
            'video_id' => $request->input('video_id'),
            'user_id' => auth()->user()->id,
            'content' => $request->input('content')
        ]);

        return redirect('/video/'.$request->input('video_id'))->with('success','Comment added');
    }
}
