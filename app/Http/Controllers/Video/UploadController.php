<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Video;

class UploadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
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

        $fileName = pathinfo($request->file('video')->getClientOriginalName(),PATHINFO_FILENAME);
        $extenstion = $request->file('video')->getClientOriginalExtension();

        $fileNameToStore = $fileName.'_'.time().'.'.$extenstion;

        $path = $request->file('video')->storeAs('public/videos',$fileNameToStore);

        Video::create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'name' => $fileNameToStore
        ]);

        return redirect('/')->with('success','Your video has been uploaded');
    }

}
