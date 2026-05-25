<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Camplore' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif !important; }
    </style>

    

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <x-navbar_LP />

    {{-- MAIN WRAPPER --}}
    <div class="flex flex-1 relative bg-[#f5f4f0]">

        {{-- SIDEBAR --}}
        <aside class="fixed left-8 top-[100px] w-[280px] bottom-8 z-40 hidden lg:block">
            <div class="h-full no-scrollbar overflow-y-auto">
                <x-sidebar_pelanggan />
            </div>
        </aside>

        {{-- CONTENT --}}
        <main class="flex-1 lg:ml-[320px]">
            <div class="px-8 pt-8 anim">
                @yield('content')
            </div>
        </main>

    </div>

    @stack('scripts')
</body>
