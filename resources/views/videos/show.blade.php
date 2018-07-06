@extends('layouts.app')
@section('title') {{ $data['video']->title }} @endsection

@section('content')

    <h1 class='display-2'> {{ $data['video']->title }} </h1>
    
    <video width="600" height="400" controls>
        <source src="/storage/videos/{{ $data['video']->name }}">
    </video>

    <div class='social-buttons'>
        <a class='btn btn-success btn-md' href='/like/{{$data['video']->id}}'>Like </a>
        <a class='btn btn-danger btn-md'href='/dislike/{{$data['video']->id}}'> Dislike </a>
    </div>

    <div class='description'>
        <p class='lead' style='margin:0;'>{{$data['video']->description }} </p>
        at <small>{{ $data['video']->created_at }}  by {{ $data['creator']->name }}</small> 
    </div>

@endsection