@extends('layouts.app')
@section('title') {{ Auth::user()->name }} account @endsection

@section('content')
    
    @if(count($videos) > 0 )
        <h1 class='display-2'> Your videos  </h1> 
        
        @foreach($videos as $video)
            
            <div style='margin-top:25px;'></div>
            <ul class='list-group'>
                <li class='list-group-item'> 
                    <a class='lead video-link' href='/video/{{$video->id}}' style='margin-right:30px;'> 
                    
                    {{ $video->title }} </a>

                    <a href="/edit/{{$video->id}}" class='btn btn-primary btn-sm pull-right' style='color:white;'>Edit</a>
                    <a href="/delete/{{$video->id}}" class='btn btn-danger btn-sm pull-right' style='color:white;'>Delete</a>
                
                </li>
            </ul>
        
        @endforeach
    
    @else <h1 class='display-2'> Your have no videos </h1>
    
    @endif

@endsection
