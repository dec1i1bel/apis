<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

</head>
<body>
    @section('header')
        <header class="container-xl mb-4">
            <nav class="nav">
                <a class="navbar-brand" href="{{ route('index') }}">
                    <img src="{{ asset('/images/logo.png') }}" class="logo-img">
                </a>
                <a class="nav-link" href="{{ route('index') }}">APIs</a>
            </nav>
        </header>
    @show
    <div class="container">
        @yield('content')
    </div>
    @section('footer')
        <footer class="container-xl"></footer>
    @show
</body>
</html>
