<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CampLore</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8faf6]">

    @include('sidebar_dashboard_admin')

    

    <div class="antialiased">
        <main class="p-4 sm:ml-64 pt-24 min-h-screen">
            @yield('content')
        </main>
    </div>

</body>
</html>
:::