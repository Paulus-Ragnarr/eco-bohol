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

<body class="antialiased">
    <header class="search-species-header z-20 flex w-full justify-between items-center p-4 md:p-2 fixed top-0">
        {{-- <a href="/" class="text-2xl">
        </a> --}}
        <div>
            <button class="hover:bg-green-800 p-2 rounded-md" onclick='history.back()'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="white" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </button>
        </div>
        <div>
            <div class="md:hidden">
                <button id="show-menu-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                    </svg>
                </button>
            </div>
            {{-- medium screen menu --}}
            <div class="hidden md:flex items-center space-x-4">
                <div class="search-species-primary-btn px-4 py-1 rounded">
                    @if ($user)
                    <a href="/admin">Dashboard</a>
                    @else
                    <a href="/login">Login</a>
                    <p hidden id="check-auth"></p>
                    @endif
                </div>
            </div>

            {{-- small screen menu --}}
            <div id="mobile-menu"
                class="hidden md:hidden fixed top-0 right-4 bg-white w-32 rounded space-y-2 shadow-md px-4 py-5 mt-12">

                <div class="primary-btn px-4 py-1 rounded">
                    @if ($user)
                    <a href="/admin">Dashboard</a>
                    @else
                    <a href="/login">Login</a>
                    <p hidden id="check-auth"></p>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <main class="h-full pt-10">
        @yield('content')
    </main>
</body>

@yield('script')

</html>