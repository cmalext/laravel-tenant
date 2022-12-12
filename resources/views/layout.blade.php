<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    {{-- this is only a template. replace this with your own --}}
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
</head>

<body class="{{ $tcode }}">

    <nav class="navbar navbar-top navbar-fixed">

        <div class="nav">
            <div class="logo">
                <a href="/">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="navlinks">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/scenes">Scenes</a></li>
                    <li><a href="/channels">Channels</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>

</body>

</html>