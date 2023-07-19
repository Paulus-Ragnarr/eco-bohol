<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

{{-- @php
$user = Auth::user();
$user_permissions = $user->permissions();
@endphp --}}

<body class="antialiased">
    <main class="flex h-screen">
        <div id="admin-menu"
            class="side-menu transition-width duration-300 ease-in-out md:static h-screen w-[15%] flex flex-col justify-between z-10">
            <div class="px-5 mb-10 hover:bg-green-900 py-4 flex space-x-2 items-center">
                <a href="/" class="flex space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <p class="menu-text hidden md:block">Back to Homepage</p>
                </a>
            </div>
        </div>
        <div class="overflow-y-auto text-xs md:text-base w-full">
            @yield('content')
        </div>
    </main>
</body>


</html>