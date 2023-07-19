@extends('layouts.admin')

@section('title', 'Eco Bohol - Dashboard')


@section('content')
    <div class="common-background flex-1 p-5">
        <div class="mb-3">
            <h2 class="text-4xl">Welcome to EcoBohol</h2>
        </div>
        @if ($user->user_role == 'admin')
            <div class="dashboard-summary grid md:grid-cols-5 md:space-x-2 gap-2">
                <div class="summary-item bg-green-600 hover:bg-green-500">
                    <h2 class="text-white text-bold text-lg">{{ $userCount }}</h2>
                    <h4 class="text-white">Active Users</h4>
                </div>
                <div class="summary-item bg-rose-600 hover:bg-rose-500">
                    <h2 class="text-white text-bold text-lg">{{ $pendingCount }}</h2>
                    <h4 class="text-white">Pending Registrations</h4>
                </div>
                <div class="summary-item bg-sky-700 hover:bg-sky-600">
                    <h3 class="text-white text-bold text-lg">{{ $mangroveCount }}</h3>
                    <h4 class="text-white">Species</h4>
                </div>
                <div class="summary-item bg-orange-700 hover:bg-orange-600">
                    <h3 class="text-white text-bold text-lg">{{ $ongoingCount }}</h3>
                    <h4 class="text-white">Ongoing Plantations</h4>
                </div>
                <div class="summary-item bg-gray-800 hover:bg-gray-700">
                    <h3 class="text-white text-bold text-lg">{{ $completeCount }}</h3>
                    <h4 class="text-white">Completed Plantations</h4>
                </div>
            </div>
            <div class="grid md:grid-row-2 mt-5 bg-gray-50">
                <div class="p-3">
                    <h1 class="text-start text-2xl">As of <span class="text-bold" id="date-container"></span></h1>
                </div>
                <div class="grid md:grid-cols-2 gap-2">
                    <div class="flex flex-col  p-5 space-y-2">
                        <h1 class="text-center">Plantations Survival Rate Data</h1>
                        <canvas id="survival_rate"></canvas>
                    </div>
                    <div class="flex flex-col  p-5 gap-2">
                        <h1 class="text-center">Plantations Monitoring Data</h1>
                        <canvas id="planted_data"></canvas>
                    </div>
                </div>
            </div>
        @elseif ($user->user_role == 'officer')
            <div class="dashboard-summary grid md:grid-cols-3 md:space-x-2 gap-2">
                <div class="summary-item bg-sky-700 hover:bg-sky-600">
                    <h3 class="text-white text-bold text-lg">{{ $mangroveCount }}</h3>
                    <h4 class="text-white">Species</h4>
                </div>
                <div class="summary-item bg-orange-700 hover:bg-orange-600">
                    <h3 class="text-white text-bold text-lg">{{ $ongoingCount }}</h3>
                    <h4 class="text-white">Ongoing Plantations</h4>
                </div>
                <div class="summary-item bg-gray-800 hover:bg-gray-700">
                    <h3 class="text-white text-bold text-lg">{{ $completeCount }}</h3>
                    <h4 class="text-white">Completed Plantations</h4>
                </div>
            </div>
            <div class="grid md:grid-row-2 mt-5 bg-gray-50">
                <div class="p-3">
                    <h1 class="text-start text-2xl">As of <span class="text-bold" id="date-container"></span></h1>
                </div>
                <div class="grid md:grid-cols-2 gap-2">
                    <div class="flex flex-col  p-5 space-y-2">
                        <h1 class="text-center">Plantations Survival Rate Data</h1>
                        <canvas id="survival_rate"></canvas>
                    </div>
                    <div class="flex flex-col  p-5 gap-2">
                        <h1 class="text-center">Plantations Monitoring Data</h1>
                        <canvas id="planted_data"></canvas>
                    </div>
                </div>
            </div>
        @elseif ($user->user_role == 'stakeholder')
            <div class="dashboard-summary grid md:grid-cols-3 md:space-x-2 gap-2">
                <div class="summary-item bg-sky-700 hover:bg-sky-600">
                    <h3 class="text-white text-bold text-lg">{{ $ongoingproj }}</h3>
                    <h4 class="text-white">Ongoing Projects</h4>
                </div>
                <div class="summary-item bg-orange-700 hover:bg-orange-600">
                    <h3 class="text-white text-bold text-lg">{{ $upcomingproj }}</h3>
                    <h4 class="text-white">Upcoming Projects</h4>
                </div>
                <div class="summary-item bg-gray-800 hover:bg-gray-700">
                    <h3 class="text-white text-bold text-lg">{{ $completeproj }}</h3>
                    <h4 class="text-white">Completed Projects</h4>
                </div>
            </div>
        @elseif ($user->user_role == 'manager')
            <div class="dashboard-summary grid md:grid-cols-2 md:space-x-2 gap-2">
                <div class="summary-item bg-sky-700 hover:bg-sky-600">
                    <h3 class="text-white text-bold text-lg">{{ $ongoingplant }}</h3>
                    <h4 class="text-white">Ongoing Plantations</h4>
                </div>
                <div class="summary-item bg-gray-800 hover:bg-gray-700">
                    <h3 class="text-white text-bold text-lg">{{ $completeplant }}</h3>
                    <h4 class="text-white">Completed Plantations</h4>
                </div>
            </div>
        @endif
    </div>

    <script>
        function getCurrentDateAndTime() {
            const dateTime = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            return dateTime.toLocaleString(undefined, options);
        }

        const dateDisplay = document.getElementById('date-container');
        dateDisplay.innerHTML = getCurrentDateAndTime();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script src="{{ asset('static/js/dashb_currentbar.js') }}"></script>
    <script src="{{ asset('static/js/dashb_survivalchart.js') }}"></script>
@stop
{{-- <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5LUarjQmcQOd8ov4VU7AZAulYv4OsFWo&callback=initMap&libraries=visualization"
    async defer></script> --}}
