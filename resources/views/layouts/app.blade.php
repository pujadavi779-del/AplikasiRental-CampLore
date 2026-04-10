<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Rental App')</title>
    @vite('resources/css/app.css')

    {{-- Styles dari child view (Tailwind, AOS, dll) --}}
    @stack('styles')
    
</head>
<body>

    {{-- Navbar --}}
    @include('navbar')

    <hr>

    {{-- Isi halaman --}}
    @yield('content')

    {{-- Scripts dari child view (AOS init, dll) --}}
    @stack('scripts')

</body>
</html>