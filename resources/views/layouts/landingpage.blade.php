<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- ← tambahkan ini --}}
    <title>@yield('title')</title>
</head>

<body>

    {{-- navbar pelanggan --}}
    @include('components.navbar_LP')

    <main>
        @yield('content')
    </main>

</body>

</html>