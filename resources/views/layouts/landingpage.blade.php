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

<deskripsi class="min-h-screen flex flex-col">

    <x-navbar_LP />

    <main class="flex-1">
        @yield('content')
    </main>

    @stack('scripts')
</deskripsi>
</html>