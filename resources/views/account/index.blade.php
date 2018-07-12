@extends('layouts.app')
@section('title') {{ Auth::user()->name }} account @endsection

@section('content')
    
    @if(count($videos) > 0 )
        <h1 class='display-2'> Your videos (@php echo count($videos) @endphp) </h1> 
        
        @foreach($videos as $video)
            
            <div style='margin-top:25px;'></div>
            <ul class='list-group'>
                <li class='list-group-item'> 
                    <a class='lead pure-link' href='/video/{{$video->id}}' style='margin-right:30px;'> 
                    
                    {{ $video->title }} </a>

                    <a href="/edit/{{$video->id}}" class='btn btn-primary btn-sm pull-right' style='color:white;'>Edit</a>
                    <a href="/delete/{{$video->id}}" class='btn btn-danger btn-sm pull-right' style='color:white;'>Delete</a>
                
                </li>
            </ul>
        
        @endforeach

        <div style='margin-top:20px;'></div>
        <a href='/upload' class='btn btn-success btn-lg'> Upload more ! </a>
    @else 
        <h1 class='display-2'> Your have no videos </h1>
        <a href='/upload' class='btn btn-success btn-lg'> Maybe upload some ? </a>
    @endif

@endsection
