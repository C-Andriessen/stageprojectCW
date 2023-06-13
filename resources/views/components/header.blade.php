<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwsflits</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Nieuwsflits</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto mb-2 mb-lg-0">

                </div>

                @if (Route::has('login'))
                @auth
                <a href="{{ url('/home') }}" class="btn btn-outline-primary">Dashboard</a>
                @else
                <a class="text-decoration-none text-dark me-2" href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                <a class="text-decoration-none text-dark me-4" href="{{ route('register') }}">Registreer</a>
                @endif
                @endif
                @endif
            </div>
        </div>
    </nav>