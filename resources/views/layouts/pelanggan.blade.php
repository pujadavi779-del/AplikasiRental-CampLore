<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EEF3F0;
            /* Warna hijau pucat sesuai gambar */
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
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased">

    <div class="fixed top-0 left-0 right-0 z-50 p-5">
        @include('pages.pelanggan.navbar')
    </div>

    <div class="flex">
        <div class="fixed left-8 top-[125px] w-[300px] bottom-8 z-40 hidden lg:block">
            @include('pages.pelanggan.sidebar')
        </div>

        <main class="flex-1 lg:ml-[340px] pt-[135px] pr-8 pb-10 min-h-screen">
            <div class="anim">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>