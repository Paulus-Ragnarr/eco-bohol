@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')

@section('content')

    <div class="common-background flex-1 p-5">
        <div class="mb-5 border-b-2 pb-5 bg-white flex justify-between">
            <h1 class="text-2xl">Generate Monitoring Record</h1>
            <a href="/admin/analytics-reports/plantation_monitoring"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24  bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="flex justify-end">
            <form action="/admin/analytics-reports/plantation_monitoring" method="get" class="flex space-x-2">
                <input type="number" name="id" id="id" hidden value={{ $plantation->plantation_id }}>
                <input type="date" class="common-input w-full" name="start_date"
                    value={{ $start_date ? $start_date : '2023-01-01' }}>
                <input type="date" class="common-input w-full" name="end_date"
                    value={{ $end_date ? $end_date : '2023-12-12' }}>
                {{-- <input type="date" class="common-input w-full" name="start_date">
                <input type="date" class="common-input w-full" name="end_date"> --}}
                <button type="submit" class="secondary-btn">Filter</button>
            </form>
            <div>
                <button id="print-button" class="primary-btn md:ml-4">Print Report</button>
            </div>
        </div>
        <div class="mt-10" id="report-print">
            <div id="report-paper" class="flex flex-col h-full space-y-4 px-10 py-8 bg-white text-center">
                <div class="report-header-log">
                    <div class="">
                        <h1 class="underline text-2xl font-bold text-black">Monitoring Record</h1>
                    </div>
                </div>
                <div class="flex space-x-10">
                    <div>
                        <span class="font-bold">Plantation Code:</span>
                        <span>{{ $plantation->unique_code }}</span>
                    </div>
                    <div>
                        <span class="font-bold">Manager:</span>
                        <span>{{ $plantation->manager->org_name }}</span>
                    </div>
                    <div>
                        <span class="font-bold">Date Filtered:</span>
                        <span>{{$start_date}} - {{$end_date}}</span>
                    </div>
                    <div>
                        <span class="font-bold">As of:</span>
                        <span id="record-date"></span>
                    </div>
                </div>
                {{-- <div class="overflow-x-auto relative"> --}}
                <div class="overflow-x-auto relative">
                    @if ($user->user_role != 'manager')
                        <table class="w-full text-sm text-left text-gray-500 report-table">
                            <thead class="text-xs uppercase">
                                <tr>
                                    <th scope="col" class="py-2 px-4">
                                        Date Monitored
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        Longitude
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        Latitude
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        Area (Ha)
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        Spacing
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        No. Plots
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        No. Survived
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        No. Dead
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        Survival Rate %
                                    </th>
                                    <th scope="col" class="py-2 px-4">
                                        Evaluator
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plantation_monitorings as $plantation_monitoring)
                                    <tr class="bg-white border-b ">
                                        <th scope="row" class="py-3 px-5 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $plantation_monitoring->date_monitored }}
                                        </th>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->longitude }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->latitude }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->area }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->spacing }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->no_plots }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->no_survived }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->no_dead }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->survival_rate }}
                                        </td>
                                        <td class="py-3 px-5">
                                            {{ $plantation_monitoring->user->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif ($user->user_role == 'manager')
                        <table class="w-full text-sm text-left text-gray-500 report-table">
                            <thead class="text-xs uppercase">
                                <tr>
                                    <th scope="col" class="py-2 px-3">
                                        Date Monitored
                                    </th>
                                    <th scope="col" class="py-2 px-3">
                                        Area (Ha)
                                    </th>
                                    <th scope="col" class="py-2 px-3">
                                        No. Survived
                                    </th>
                                    <th scope="col" class="py-2 px-3">
                                        No. Dead
                                    </th>
                                    <th scope="col" class="py-2 px-3">
                                        No. Replanted
                                    </th>
                                    <th scope="col" class="py-2 px-3">
                                        Current Planted
                                    </th>
                                    <th scope="col" class="py-2 px-3">
                                        Remarks
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plantation_monitorings as $plantation_monitoring)
                                    <tr class="bg-white border-b ">
                                        <th scope="row" class="py-2 px-3 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $plantation_monitoring->date_monitored }}
                                        </th>
                                        <td class="py-2 px-3">
                                            {{ $plantation_monitoring->area }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ $plantation_monitoring->no_survived }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ $plantation_monitoring->no_dead }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ $plantation_monitoring->no_replanted }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ $plantation_monitoring->current_planted }}
                                        </td>
                                        <td class="py-2 px-3">
                                            {{ $plantation_monitoring->remarks }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div>
                    <input type="text" hidden id="graph_data" value="{{ $graph_data }}">
                    <div class="grid md:grid-cols-2 mt-5 w-full gap-2">
                        @if ($user->user_role != 'manager')
                            <div class="flex flex-col">
                                <h1 class="text-center text-black">Survival Rate</h1>
                                <canvas id="survival_rate"></canvas>
                            </div>
                            <div class="flex flex-col">
                                <h1 class="text-center text-black">Total Planted, No. Survived, No. Dead</h1>
                                <canvas id="planted_data"></canvas>
                            </div>
                        @elseif ($user->user_role == 'manager')
                            <div class="flex flex-col">
                                <h1 class="text-center text-black">Current Planted</h1>
                                <canvas id="manager_current_planted"></canvas>
                            </div>
                            <div class="flex flex-col">
                                <h1 class="text-center text-black">Current Planted, No. Dead, No. Replanted</h1>
                                <canvas id="manager_planted_data"></canvas>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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
    
        const dateDisplay = document.getElementById('record-date');
        dateDisplay.innerHTML = getCurrentDateAndTime();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script src="{{ asset('static/js/plantation_monitoring_report.js') }}"></script>

@stop

@section('additional_scripts')
    @include('admin.reports.report_scripts')
@stop
