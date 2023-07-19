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

@php
$user = Auth::user();
$user_permissions = $user->permissions();
@endphp

<body class="antialiased">
    <main class="flex h-screen">
        <div id="admin-menu"
            class="side-menu transition-width duration-300 ease-in-out md:static h-screen w-[15%] flex flex-col justify-between z-10">
            <div>
                <div class="flex items-center relative py-3 bg-green-900 space-x-2 mx-2 my-5 rounded-md px-4">
                    {{-- <img class="rounded-full bg-yellow-400 h-10 w-10 overflow-hidden" src="" alt=""> --}}
                    <div>
                        <div class="menu-icon md:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h6 class="my-0 menu-text hidden md:block text-white" id="user_name">{{ $user->name }}</h6>
                        <p class="my-0 text-sm hidden menu-text md:block text-gray-300" id="user_details">
                            {{ $user->email }}</p>
                    </div>
                    <div
                        class="absolute -right-6 bg-yellow-400 w-8 h-8 rounded-full p-1 md:hidden shadow-ld text-green-800 transition-transform duration-200 ease-in-out">
                        <button id="toggle-admin-menu" class="transition-transform duration-300 ease-in-out ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </div>
                <ul>
                    <li class="nav-item" name="/admin/dashboard">
                        <a href="/admin/dashboard">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">Dashboard</p>
                            {{-- {{dd($user_permissions)}} --}}
                        </a>
                    </li>
                    <li class="nav-item {{ $user_permissions['species_records'] == false ? 'hidden' : '' }}"
                        name="/admin/manage-speciesrecords">
                        <a href="/admin/manage-speciesrecords">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 15V7M7.5 7.5V10.5M7.5 7.5C7.5 5.29086 5.70914 3.5 3.5 3.5H0.5V6.5C0.5 8.70914 2.29086 10.5 4.5 10.5H7.5M7.5 7.5H10.5C12.7091 7.5 14.5 5.70914 14.5 3.5V0.5H11.5C9.29086 0.5 7.5 2.29086 7.5 4.5V7.5ZM7.5 7.5L11.5 3.5M7.5 10.5L3.5 6.5" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">Species Records</p>
                        </a>
                    </li>
                    <li class="nav-item {{ $user_permissions['mangrove_projects'] == false ? 'hidden' : '' }}"
                        name="/admin/manage-projects">
                        <a href="/admin/manage-projects">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.893 13.393l-1.135-1.135a2.252 2.252 0 01-.421-.585l-1.08-2.16a.414.414 0 00-.663-.107.827.827 0 01-.812.21l-1.273-.363a.89.89 0 00-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 01-1.81 1.025 1.055 1.055 0 01-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 01-1.383-2.46l.007-.042a2.25 2.25 0 01.29-.787l.09-.15a2.25 2.25 0 012.37-1.048l1.178.236a1.125 1.125 0 001.302-.795l.208-.73a1.125 1.125 0 00-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 01-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 01-1.458-1.137l1.411-2.353a2.25 2.25 0 00.286-.76m11.928 9.869A9 9 0 008.965 3.525m11.928 9.868A9 9 0 118.965 3.525" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">Mangrove Projects</p>
                        </a>
                    </li>
                    <li class="nav-item {{ $user_permissions['manage_journals'] == false ? 'hidden' : '' }}"
                        name="/admin/manage-journals">
                        <a href="/admin/manage-journals">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">Manage Journals</p>
                        </a>
                    </li>
                    <li class="nav-item {{ $user_permissions['plantations'] == false ? 'hidden' : '' }}"
                        name="/admin/manage-plantations">
                        <a href="/admin/manage-plantations">
                            <div class="menu-icon md:hidden">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6" xmlns="http://www.w3.org/2000/svg">
                                    <polyline style="fill:none; stroke:white" points="20 8.5 20 22.5 4 22.5 4 8.5" />
                                    <polyline style="fill:none; stroke:white" points="23 10.5 12 1.5 1 10.5" />
                                    <path
                                        d="M8,11.5H9a3,3,0,0,1,3,3v1a0,0,0,0,1,0,0H11a3,3,0,0,1-3-3v-1A0,0,0,0,1,8,11.5Z" />
                                    <path class="cls-1"
                                        d="M15,13.5h1a0,0,0,0,1,0,0v1a3,3,0,0,1-3,3H12a0,0,0,0,1,0,0v-1A3,3,0,0,1,15,13.5Z" />
                                    <line x1="12" y1="22.5" x2="12" y2="15.5" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">Plantations</p>
                        </a>
                    </li>
                    <li class="nav-item {{ $user_permissions['nurseries'] == false ? 'hidden' : '' }}"
                        name="/admin/manage-nurseries">
                        <a href="/admin/manage-nurseries">
                            <div class="menu-icon md:hidden">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6">
                                    <path
                                        d="m8.75 6.75c0 1.25-.75 3-.75 3m.25-2.5s.75-2-1-3.5-4.5-1-4.5-1 0 2 1.5 3.5 4 1 4 1zm.5-1s-.75-2 1-3.5 4.5-1 4.5-1 0 2-1.5 3.5-4 1-4 1z" />
                                    <path d="m4.75 9.75h6.5s.5 4.5-3.25 4.5-3.25-4.5-3.25-4.5z" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">
                                Nurseries
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ $user_permissions['manage_maps'] == false ? 'hidden' : '' }}"
                        name="/admin/manage-maps">
                        <a href="/admin/manage-maps">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">Manage Maps</p>
                        </a>
                    </li>
                    <div class="nav-item {{ $user_permissions['reports'] == false ? 'hidden' : '' }} "
                        onclick="dropdownReport()" id="reports-toogle">
                        <a href="#" class="flex justify-between">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">
                                Generate Reports
                            </p>
                            <div class="menu-icon order-last hidden md:block">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </a>
                    </div>
                    <div class="mt-1 hidden" id="submenuReport">
                        <li class="nav-item {{ $user_permissions['heatmap_reports'] == false ? 'hidden' : '' }}"
                            name="/admin/analytics-reports/heatmap">
                            <a href="/admin/analytics-reports/heatmap">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Heat Map</p>
                            </a>
                        </li>
                        <li class="nav-item {{ $user_permissions['plantation_record_report'] == false ? 'hidden' : '' }}"
                            name="/admin/analytics-reports/plantation_records">
                            <a href="/admin/analytics-reports/plantation_records">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Plantation Records</p>
                            </a>
                        </li>
                        <li class="nav-item {{ $user_permissions['monitoring_report'] == false ? 'hidden' : '' }}"
                            name="/admin/analytics-reports/plantation_monitoring">
                            <a href="/admin/analytics-reports/plantation_monitoring">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Plantation Monitoring Report</p>
                            </a>
                        </li>
                        <li class="nav-item {{ $user_permissions['nursery_record_report'] == false ? 'hidden' : '' }}"
                            name="/admin/analytics-reports/nursery_records">
                            <a href="/admin/analytics-reports/nursery_records">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Nursery Records</p>
                            </a>
                        </li>
                        <li class="nav-item {{ $user_permissions['nursery_monitor_report'] == false ? 'hidden' : '' }}"
                            name="/admin/analytics-reports/nursery_monitoring">
                            <a href="/admin/analytics-reports/nursery_monitoring">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Nursery Monitoring Record</p>
                            </a>
                        </li>
                        <li class="nav-item {{ $user_permissions['project_reports'] == false ? 'hidden' : '' }}"
                            name="/admin/analytics-reports/projects">
                            <a href="/admin/analytics-reports/projects">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Projects</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item {{ $user_permissions['reports'] == false ? 'hidden' : '' }}"
                            name="/admin/analytics-reports/manager_list">
                            <a href="/admin/analytics-reports/manager_list">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">List of Managers</p>
                            </a>
                        </li> --}}
                    </div>
                    <hr class="my-5 nav-divide" />
                    <div class="nav-item {{ $user_permissions['manage_accounts'] == false ? 'hidden' : '' }} "
                        onclick="dropdown()" id="manage-accounts-toggle">
                        <a href="#" class="flex justify-between">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <p class="menu-text hidden md:block">
                                Manage Accounts
                            </p>
                            <div class="menu-icon order-last hidden md:block">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </a>
                    </div>
                    <div class="mt-1 hidden" id="submenu">
                        <li class="nav-item {{ $user_permissions['manage_accounts'] == false ? 'hidden' : '' }}"
                            name="/admin/manage-users">
                            <a href="/admin/manage-users">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">
                                    Admin, Officer & Researcher
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ $user_permissions['manage_accounts'] == false ? 'hidden' : '' }}"
                            name="/admin/managers">
                            <a href="/admin/managers">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6">
                                        <path
                                            d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">
                                    Manager
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ $user_permissions['stakeholders'] == false ? 'hidden' : '' }}"
                            name="/admin/manage-stakeholders">
                            <a href="/admin/manage-stakeholders">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6">
                                        <path fill-rule="evenodd"
                                            d="M4.5 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5h-.75V3.75a.75.75 0 000-1.5h-15zM9 6a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm-.75 3.75A.75.75 0 019 9h1.5a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM9 12a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm3.75-5.25A.75.75 0 0113.5 6H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM13.5 9a.75.75 0 000 1.5H15A.75.75 0 0015 9h-1.5zm-.75 3.75a.75.75 0 01.75-.75H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM9 19.5v-2.25a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v2.25a.75.75 0 01-.75.75h-4.5A.75.75 0 019 19.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Stakeholders</p>
                            </a>
                        </li>
                    </div>
                    <li class="nav-item" name="/admin/account-settings">
                        <a href="/admin/account-settings">
                            <div class="menu-icon md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                            </div>
                            <p class="menu-text hidden md:block">Account Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="/logout" method="POST" class="m-0">
                            @csrf
                            <button type="submit">
                                <div class="menu-icon md:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6">
                                        <path fill-rule="evenodd"
                                            d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm5.03 4.72a.75.75 0 010 1.06l-1.72 1.72h10.94a.75.75 0 010 1.5H10.81l1.72 1.72a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06l3-3a.75.75 0 011.06 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="menu-text hidden md:block">Logout</p>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
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

@yield('additional_scripts')


<script>
    const submenuReport = document.getElementById("submenuReport");
    const generate_report_toogle = document.getElementById("reports-toogle")
    let isMenuOpen2 = localStorage.getItem('isMenuOpen2') === 'true' || false;
    submenuReport.style.display = isMenuOpen2 ? 'block' : 'none';

    generate_report_toogle.classList.add(isMenuOpen2 ? 'bg-gray-900/50' : '');

    function dropdownReport() {
        isMenuOpen2 = !isMenuOpen2;
        submenuReport.style.display = isMenuOpen2 ? 'block' : 'none';
        generate_report_toogle.classList.toggle('bg-gray-900/50');

        localStorage.setItem('isMenuOpen2', isMenuOpen2);

        if (submenuReport.classList.contains("hidden")) {
            submenuReport.classList.remove("hidden");
        } else {
            submenuReport.classList.add("hidden");
        }

    }
</script>
<script>
    const submenu = document.getElementById("submenu");
    const manage_accounts_toggle = document.getElementById("manage-accounts-toggle")
    let isMenuOpen = localStorage.getItem('isMenuOpen') === 'true' || false;
    submenu.style.display = isMenuOpen ? 'block' : 'none';

    manage_accounts_toggle.classList.add(isMenuOpen ? 'bg-gray-900/50' : '');

    function dropdown() {
        isMenuOpen = !isMenuOpen;
        submenu.style.display = isMenuOpen ? 'block' : 'none';
        manage_accounts_toggle.classList.toggle('bg-gray-900/50')

        localStorage.setItem('isMenuOpen', isMenuOpen);

        if (submenu.classList.contains("hidden")) {
            submenu.classList.remove("hidden");
        } else {
            submenu.classList.add("hidden");
        }
    }
</script>
<script>
    let admin_menu = document.getElementById('admin-menu')
    let nav_items = document.getElementsByClassName('nav-item');
    let nav_menu_texts = document.getElementsByClassName('menu-text')
    let menu_icons = document.getElementsByClassName('menu-icon')

    for (let i = 0; i < nav_items.length; i++) {
        if (window.location.pathname.includes(nav_items[i].getAttribute('name'))) {
            nav_items[i].classList.add('active');
        }
    }
    let toggle_button = document.getElementById('toggle-admin-menu')

    toggle_button.addEventListener('click', function() {
        admin_menu.classList.toggle('w-[15%]')
        admin_menu.classList.toggle('w-3/6')
        toggle_button.classList.toggle('rotate-180')
        for (let j = 0; j < nav_menu_texts.length; j++) {
            nav_menu_texts[j].classList.toggle('hidden')
        }
        for (let k = 0; k < menu_icons.length; k++) {
            menu_icons[k].classList.toggle('hidden')
        }
    });
</script>

</html>