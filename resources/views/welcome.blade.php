@extends('layouts.app')

@section('title') Welcome @endsection

@section('content')

    @auth
        <div class="jumbotron">
            <h1 class="display-4">Welcome!</h1>
            <a class="btn btn-primary btn-lg" href="/account" style="margin-right:15px;"> 
            Dashboard </a>
            <a class="btn btn-success btn-lg" href="/upload"> Upload </a>
        </div>
    @endauth

@endsection