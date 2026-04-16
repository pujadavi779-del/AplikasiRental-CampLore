<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - CampLore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f4f5ed;
        }

        .font-serif {
            font-family: 'DM Serif Display', serif;
        }
    </style>
</head>

<body class="antialiased">

    {{-- 1. SIDEBAR (Pastikan file sidebar kamu sudah benar namanya) --}}
    @include('sidebar_dashboard_admin')

    {{-- 2. MAIN CONTENT --}}
    <main class="sm:ml-64 min-h-screen p-4 sm:p-6">

        <header class="bg-white rounded-3xl p-4 flex flex-col sm:flex-row justify-between items-center shadow-sm border border-[#e5e6d8] mb-6 gap-4">
            <nav class="text-[11px] font-bold uppercase tracking-widest flex items-center gap-2">
                <span style="color: #5a7a3a;">Manajemen Profil</span>
                <span style="color: #c8c9b4;">/</span>
                <span style="color: #ff4d94;">Ubah Password</span>
            </nav>

            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search..." class="w-full bg-[#f4f5ed] border-none text-xs py-2 pl-10 pr-4 rounded-xl focus:ring-1 focus:ring-[#5a7a3a] outline-none">
                </div>
                <div class="relative text-[#5a7a3a]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-width="1.5" />
                    </svg>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-pink-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-[40px] p-8 md:p-16 shadow-sm border border-[#e5e6d8] flex flex-col items-center">

            <h1 class="text-4xl font-serif mb-12 text-center" style="color: #2a3020;">Change Your Password</h1>

            <form action="#" method="POST" class="w-full max-w-xl space-y-6">
                <div class="relative group">
                    <input type="password" placeholder="Previous Password"
                        class="w-full py-4 px-6 bg-white border border-[#e5e6d8] rounded-2xl outline-none focus:ring-2 focus:ring-[#5a7a3a] transition-all group-hover:border-[#5a7a3a]">
                    <span class="absolute right-6 top-4 text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                </div>

                <div class="relative group">
                    <input type="password" placeholder="New Password"
                        class="w-full py-4 px-6 bg-white border border-[#e5e6d8] rounded-2xl outline-none focus:ring-2 focus:ring-pink-400 transition-all group-hover:border-pink-400">
                    <span class="absolute right-6 top-4 text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </span>
                </div>

                <div class="relative group">
                    <input type="password" placeholder="Confirm New Password"
                        class="w-full py-4 px-6 bg-white border border-[#e5e6d8] rounded-2xl outline-none focus:ring-2 focus:ring-pink-400 transition-all group-hover:border-pink-400">
                    <span class="absolute right-6 top-4 text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                </div>

                <div class="flex justify-center pt-8">
                    <button type="submit" class="flex items-center gap-3 px-10 py-4 bg-[#b2967d] hover:bg-[#5a7a3a] text-white rounded-full font-bold shadow-lg transition-all active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </main>
</body>

</html>