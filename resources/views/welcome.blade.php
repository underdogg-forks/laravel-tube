@extends('layouts.app')

@section('title') Welcome @endsection

@section('content')

    @auth
        <a  href="/upload" class="btn btn-primary btn-lg"> Upload your video </a>
    @endauth

@endsection