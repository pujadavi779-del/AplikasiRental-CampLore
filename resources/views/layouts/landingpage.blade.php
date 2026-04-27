<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EEF3F0;
            margin: 0;
        }

        .anim {
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased">

    {{-- Navbar saja, BUKAN full layout --}}
    @include('components.navbar_LP')

    {{-- Layout: Sidebar + Konten --}}
    <div class="flex min-h-screen">

        {{-- Sidebar fixed, hanya desktop --}}
        <div class="fixed left-8 top-[125px] w-[280px] bottom-8 z-40 hidden lg:block">
            @include('pages.pelanggan.sidebar')
        </div>

        {{-- Konten utama di samping sidebar --}}
        <main class="w-full lg:ml-[320px] pt-[135px] px-8 pb-10">
            <div class="anim">
                @yield('content')
            </div>
        </main>

    </div>

    @stack('scripts')
</body>

</html>