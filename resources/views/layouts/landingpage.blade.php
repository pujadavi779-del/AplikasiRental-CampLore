<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Camplore')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">

    @include('components.navbar_LP')

    <main class="flex-1">
        @yield('content')
    </main>

  

</body>
</html>