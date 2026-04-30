<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CampLore</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8faf6]">
    <div class="ml-[272px]">
        @include('components.sidebar_dashboard_admin')

        {{-- CONTENT --}}
        <main class="pt-24 px-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>