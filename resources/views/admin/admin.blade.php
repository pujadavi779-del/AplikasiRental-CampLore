<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CampLore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Masukkan file partials sidebar-nav di sini --}}
    @include('sidebar_dashboard_admin')
</head>
<body class="bg-[#080d03]">

    <div class="antialiased">
        {{-- Area Konten Utama --}}
        <main class="p-4 sm:ml-64 pt-24 min-h-screen">
            @yield('content')
        </main>
    </div>

</body>
</html>