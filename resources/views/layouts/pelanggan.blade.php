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

    {{-- NAVBAR --}}
    @include('components.navbar_LP')

    {{-- MAIN WRAPPER --}}
    <div class="flex flex-1 relative">

        {{-- SIDEBAR --}}
        <aside class="fixed left-8 top-[100px] w-[280px] bottom-8 z-40 hidden lg:block">
            <div class="h-full no-scrollbar overflow-y-auto">
                @include('pages.pelanggan.sidebar')
            </div>
        </aside>

        {{-- CONTENT --}}
        <main class="flex-1 lg:ml-[320px]">
            <div class="px-8 pt-8 anim">
                @yield('content')
            </div>
        </main>

    </div>

</body>
</html>