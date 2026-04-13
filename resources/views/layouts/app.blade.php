<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Rental App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Styles dari child view (Tailwind, AOS, dll) --}}
    @stack('styles')
</head>
<body>

    {{-- Navbar --}}


    <hr>

    {{-- Isi halaman --}}
    @yield('content')

    {{-- Scripts dari child view (AOS init, dll) --}}
    @stack('scripts')

</body>
</html>