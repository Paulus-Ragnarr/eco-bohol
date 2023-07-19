@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')


@section('content')

<div class="common-background flex-1 p-5">
    <div class="mb-5 border-b-2 pb-5 bg-white flex justify-between">
        <h1 class="text-2xl">Nursery Records</h1>
        <a href="/admin/analytics-reports/nursery_records"
            class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24  bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
    </div>
    <div class="flex justify-end">
        <button id="print-button" class="primary-btn md:ml-4">Print Report</button>
    </div>
    <div id="report-print">
        <div id="report-paper" class="flex flex-col space-y-4 report-paper px-10 py-10 bg-white">
            <div class="report-header text-center">
                <div class="report-header-log">
                    <div class="flex justify-center relative">
                        {{-- <div>
                            <img src="/static/img/DENR_logo.png" alt=""
                                class="h-20 w-20 absolute left-[12%] md:left-[15%]">
                        </div> --}}
                        <div>
                            <h2>DEPARTMENT OF ENVINRONMENT AND NATURAL RESOURCES</h2>
                            <h2>UPPER DE LA PAZ, CORTES, BOHOL</h2>
                        </div>
                    </div>
                    {{-- <div class="flex justify-center">
                        <img src="/static/img/report-header.png" alt="report-header">
                    </div> --}}
                    <div class="mt-2">
                        <h1 class="underline text-2xl font-bold text-black">Nursery Record</h1>
                    </div>
                </div>
            </div>
            <div class="report-main justify-center flex flex-col mt-10">
                <div class="w-full grid grid-cols-1">
                    <div class="report-details-input">
                        <span class="report-details-label">As of:</span>
                        <span class="report-details-value" id="record-date"></span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-2">
                    <div class="report-details-input">
                        <span class="report-details-label">Nursery ID:</span>
                        <span class="report-details-value">{{ $nursery_record->nursery_id}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Nursery Address:</span>
                        <span class="report-details-value">{{ $nursery_record->nursery_address}}</span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-2">
                    <div class="report-details-input">
                        <span class="report-details-label">Date Established:</span>
                        <span class="report-details-value">{{ $nursery_record->date_established }}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Organization Name:</span>
                        <span class="report-details-value">{{ $nursery_record->manager->org_name }}</span>
                    </div>
                </div>
            </div>
            <div class="report-main justify-center flex flex-col mt-10">
                <h2 class="font-bold underline mb-5">Batch Potted</h2>
                <div class="w-full justify-between flex">
                    <table class="w-full text-sm text-left text-gray-500 report-table">
                        <thead class="text-xs uppercase">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Batch ID
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Species
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Date Potted
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Initial No. Potted
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Current No. Potted
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nursery_record->batch_infos as $batch_info)
                            @if (strtolower($batch_info->status) == 'active')
                            <tr class="bg-white border-b ">
                                <td class="py-4 px-6">
                                    {{ $batch_info->batch_id}}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_info->species_record->common_name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_info->date_potted }}
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $batch_info->no_potted }}
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $batch_info->current_no_potted }}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="report-main justify-center flex flex-col mt-10">
                <h2 class="font-bold underline">Batch Analysis</h2>
                <input type="text" hidden id="latest_records" value="{{$latest_records}}">
                <div class="w-full justify-between flex">
                    <div class="grid md:grid-cols-2 mt-5 w-full gap-2">
                        <div class="flex flex-col">
                            <h1 class="text-center text-black">Batch Survival Rate Data</h1>
                            <canvas id="batch_survival_rate"></canvas>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-center text-black">Batch Propagule Data</h1>
                            <canvas id="propagule_data"></canvas>
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
    <script src="{{ asset('static/js/nursery_record_report.js') }}"></script>

    @stop

    @section('additional_scripts')
    @include('admin.reports.report_scripts')
    @stop