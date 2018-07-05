@extends('layouts.app')
@section('title') {{ $data['video']->title }} @endsection

@section('content')

    <h1 class='display-3'> {{$data['video']->title }} </h1>
    <video width="600" height="400" controls>
        <source src="/storage/videos/{{$data['video']->name}}">
    </video>

    <p class='lead'> by {{$data['creator']->name }} 
     at <small>{{ $data['creator']->created_at }} </small> 
    </p>


@endsection