<!DOCTYPE html>
<html>
<head>
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