@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')

@section('content')

<div class="common-background flex-1 p-5">
    <div class="mb-5 border-b-2 pb-5 bg-white flex justify-between">
        <h1 class="text-2xl">Generate Nursery Monitoring Record</h1>
        <a href="/admin/analytics-reports/nursery_monitoring"
            class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24  bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
    </div>
    <div class="flex justify-end">
        <form action="/admin/analytics-reports/nursery_monitoring" method="get" class="flex space-x-2">
            <input type="number" name="id" id="id" hidden value={{ $batch_info->batch_id }}>
            <input type="date" class="common-input w-full" name="start_date" value={{$start_date ? $start_date
                : '2023-01-01' }}>
            <input type="date" class="common-input w-full" name="end_date" value={{$end_date ? $end_date : '2023-12-12'
                }}>
            <button type="submit" class="secondary-btn">Filter</button>
        </form>
        <div>
            <button id="print-button" class="primary-btn md:ml-4">Print Report</button>
        </div>
    </div>
    <div id="report-print">
        <div id="report-paper" class="flex flex-col space-y-4 px-10 py-10 bg-white text-center report-paper">
            {{-- <div class="flex justify-center">
                <img src="/static/img/report-header.png" alt="report-header">
            </div> --}}
            <div class="report-header text-center">
                <div class="report-header-log">
                    <div class="flex justify-center relative">
                        {{-- <div>
                            <img src="/static/img/DENR_logo.png" alt=""
                                class="h-20 w-20 absolute left-[12%] md:left-[15%]">
                        </div> --}}
                        {{-- <div>
                            <h2>DEPARTMENT OF ENVINRONMENT AND NATURAL RESOURCES</h2>
                            <h2>UPPER DE LA PAZ, CORTES, BOHOL</h2>
                        </div> --}}
                    </div>
                    {{-- <div class="flex justify-center">
                        <img src="/static/img/report-header.png" alt="report-header">
                    </div> --}}
                    <div class="mt-2">
                        <h1 class="underline text-2xl font-bold text-black">Nursery Monitoring Record</h1>
                    </div>
                </div>
            </div>
            <div class="report-main flex justify-start mt-10 space-x-7">
                <div>
                    <span class="font-bold">Date Potted:</span>
                    <span>{{ $batch_info->date_potted}}</span>
                </div>
                <div>
                    <span class="font-bold">Species:</span>
                    <span>{{ $batch_info->species_record->common_name}}</span>
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
            <div class="report-main flex justify-center mt-10">
                <table class="w-full text-sm text-left text-gray-500 report-table">
                    <thead class="text-xs text-black uppercase">
                        <tr>
                            <th scope="col" class="py-2 px-4">
                                Date Monitored
                            </th>
                            <th scope="col" class="py-2 px-4">
                                No. Potted
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
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batch_monitorings as $batch_monitoring)
                        <tr class="bg-white">
                            <th scope="row" class="py-3 px-5 font-medium text-gray-900 whitespace-nowrap">
                                {{ $batch_monitoring->date_monitored}}
                            </th>
                            <td class="py-3 px-5">
                                {{ $batch_monitoring->current_no_potted }}
                            </td>
                            <td class="py-3 px-5">
                                {{ $batch_monitoring->no_survived}}
                            </td>
                            <td class="py-3 px-5">
                                {{ $batch_monitoring->no_dead }}
                            </td>
                            <td class="py-3 px-5">
                                {{ $batch_monitoring->survival_rate }} %
                            </td>
                            <td class="py-3 px-5">
                                {{ $batch_monitoring->remarks }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="report-main mt-10">
                {{-- <h2 class="font-bold underline">Batch Analysis</h2> --}}
                <input type="text" hidden id="batch_monitorings" value="{{$batch_monitorings}}">
                <div class="w-full justify-between flex">
                    <div class="grid md:grid-cols-2 mt-5 w-full gap-2">
                        <div class="flex flex-col">
                            <h1 class="text-center text-black">Survival Rate</h1>
                            <canvas id="survival_rates"></canvas>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-center text-black">Current Potted, No. Survived, No. Dead</h1>
                            <canvas id="potted_data"></canvas>
                        </div>
                    </div>
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
        };
        return dateTime.toLocaleString(undefined, options);
    }

    const dateDisplay = document.getElementById('record-date');
    dateDisplay.innerHTML = getCurrentDateAndTime();
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('static/js/nursery_monitoring_report.js') }}"></script>


@stop

@section('additional_scripts')
@include('admin.reports.report_scripts')
@stop