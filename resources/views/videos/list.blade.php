@extends('layouts.app')

@section('title') Search results @endsection

@section('content')

    @foreach($videos as $video)
        <a class='display-3 pure-link' href="/video/{{$video->id}}"> {{ $video->title }} </a>
    @endforeach

@endsection