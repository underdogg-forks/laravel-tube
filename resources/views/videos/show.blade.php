@extends('layouts.video')
@section('title') {{ $data['video']->title }} @endsection

@section('content')

    <h1 class='display-2'> {{ $data['video']->title }} </h1>
    
    <div style='margin-bottom:25px;'></div>

      
      <video id="my_video_1" class="video-js vjs-default-skin" width="80%"
      controls preload="none" poster='/storage/thumbnails/{{$data['video']->thumbnail}}'
      data-setup='{ "aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>
        <source src='/storage/videos/{{$data['video']->name}}' >
    </video>

    <div class="progress" style="margin-left:10%; width:80%;" >
        <div class="progress-bar bg-success" role="progressbar" style="width:{{$data['proportion']}}%" 
        aria-valuenow="{{$data['proportion']}}" aria-valuemin="0" aria-valuemax="100"></div>     
    </div>

    <div class='social-buttons'>
        <a class='btn btn-success btn-md' href='/like/{{$data['video']->id}}'>
            Like {{ $data['likes'] }} 
        </a>
        
        <a class='btn btn-danger btn-md'href='/dislike/{{$data['video']->id}}'> 
            Dislike {{ $data['dislikes'] }}
        </a>

        @if($data['video']->user_id == auth()->user()->id)
             <span style='margin-left:5px;'>
             <a class='btn btn-primary btn-md'href='/edit/{{$data['video']->id}}'> 
                Edit 
            </a>
        @endif
    </div>

    <p class='lead' style='cursor:pointer; margin-top:10px;' data-toggle='collapse' data-target='#description'>
		Show video details </p>
	
	<div id='description' class='collapse alert-info text-center'>
			<p class='lead'>{{$data['video']->description }} </p>
			at <small>{{ $data['video']->created_at }}  by {{ $data['creator']->name }}</small> 
	</div>
    
    @auth
        @include('comments.create')
    @endauth
    
    @include('comments.list')

    <script src="https://vjs.zencdn.net/7.0.5/video.js"></script>
@endsection