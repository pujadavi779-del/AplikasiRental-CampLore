<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <header>
        @include('components.navbar_admin')
    </header>

    <h1 class="text-center text-2xl font-bold mt-8">List Produk</h1>
    <div class="container mx-auto px-4 flex-grow">
        <main>
            @yield('content')
        </main>
    </div>

    <footer>
        @include('components.footer')
    </footer>
</body>
</html>