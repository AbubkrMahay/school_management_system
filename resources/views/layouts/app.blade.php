<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<body>
    @auth
    @include('includes.header')
    @endauth
    <div class="d-flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="flex-shrink-0">
            @auth
            @include('includes.sidebar')
            @endauth
        </aside>

        <!-- Main Content Area -->
        <main class="flex-grow-1">
           @yield('content')
        </main>
    </div>
</body>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Scripts -->
   @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

</html>