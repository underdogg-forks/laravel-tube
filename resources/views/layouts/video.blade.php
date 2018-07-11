<!DOCTYPE html>
<html lang="pl">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/video.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    
</head>
<body>
    @include('inc.navbar')
    
    <main class="text-center">
        <div style="margin-bottom:15px;"></div> 
        @include('inc.message')
        @yield('content')               
    </main>
</body>
</html>
