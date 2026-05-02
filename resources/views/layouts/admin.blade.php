<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CampLore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Wajib: sembunyikan elemen x-cloak sebelum Alpine init --}}
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="bg-[#f8faf6]">

    {{-- Sidebar (sudah include burger button & overlay di dalamnya) --}}
    @include('components.sidebar_dashboard_admin')

    {{-- Main content: geser ke kanan di desktop, full width di mobile --}}
    <main class="lg:ml-[272px] min-h-screen px-6 pt-20 lg:pt-6">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>