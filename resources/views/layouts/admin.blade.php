<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CampLore' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>[x-cloak]{display:none!important}</style>
</head>

<body class="bg-[#f8faf6]">

    {{-- Sidebar --}}
    <x-sidebar_dashboard_admin />

    {{-- Content --}}
    <main class="lg:ml-[272px] min-h-screen px-6 pt-20 lg:pt-6">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>