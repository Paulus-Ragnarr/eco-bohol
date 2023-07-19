@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')


@section('content')

<div class="common-background flex-1 p-5">
    <div class="mb-5 border-b-2 pb-5 bg-white flex justify-between">
        <h1 class="text-2xl">Plantation Records</h1>
        <a href="/admin/analytics-reports/plantation_records"
            class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24  bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
    </div>
    <div class="flex justify-end">
        <button id="print-button" class="primary-btn md:ml-4">Print Report</button>
    </div>
    <div id="report-print" class="report-print">
        <div id="report-paper" class="report-paper px-10 py-10 bg-white w-2/3">
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
                        <h1 class="underline text-2xl font-bold text-black">Plantation Record</h1>
                    </div>
                </div>
            </div>
            <div class="report-main flex flex-col justify-center mt-10">
                <div class="w-full grid grid-cols-1">
                    <div class="report-details-input">
                        <span class="report-details-label">As of: </span>
                        <span class="report-details-value" id="record-date"></span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-2">
                    <div class="report-details-input">
                        <span class="report-details-label">Plantation Code:</span>
                        <span class="report-details-value">{{ $plantation_record->unique_code }}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Manager:</span>
                        <span class="report-details-value">{{ $plantation_record->manager->org_name}}</span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-4">
                    <div class="report-details-input">
                        <span class="report-details-label">Penro:</span>
                        <span class="report-details-value">{{ $plantation_record->penro }}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Cenro:</span>
                        <span class="report-details-value">{{ $plantation_record->cenro}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Region:</span>
                        <span class="report-details-value">{{ $plantation_record->region}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">District:</span>
                        <span class="report-details-value">{{ $plantation_record->district}}</span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-1">
                    <div class="report-details-input">
                        <span class="report-details-label">Address:</span>
                        <span class="report-details-value">{{ $plantation_record->plantation_address}}</span>
                    </div>
                </div>
            </div>
            <div class="report-main flex flex-col justify-center mt-10">
                <h2 class="font-bold underline">PLANTATION DETAILS</h2>
                <div class="w-full grid grid-cols-4">
                    <div class="report-details-input">
                        <span class="report-details-label">Date Started:</span>
                        <span class="report-details-value">{{ $plantation_record->date_started}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Component:</span>
                        <span class="report-details-value">{{ $plantation_record->component}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Commodity:</span>
                        <span class="report-details-value">{{ $plantation_record->commodity}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Total Area:</span>
                        <span class="report-details-value">{{ $plantation_record->total_area}}</span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-4">
                    <div class="report-details-input">
                        <span class="report-details-label">Tenure:</span>
                        <span class="report-details-value">{{ $plantation_record->tenure}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Fund Sources:</span>
                        <span class="report-details-value">{{ $plantation_record->fund_source}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Target LOA:</span>
                        <span class="report-details-value">{{ $plantation_record->target_loa}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">No LOA:</span>
                        <span class="report-details-value">{{ $plantation_record->no_loa}}</span>
                    </div>
                </div>
                <br>
                <div class="w-full grid grid-cols-1">
                    <div class="report-details-input">
                        <span class="report-details-label">Species:</span>
                        <span class="report-details-value">{{ $plantation_record->species}}</span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-4">
                    <div class="report-details-input">
                        <span class="report-details-label">Target Number:</span>
                        <span class="report-details-value">{{ $plantation_record->target_no}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Initial Planted:</span>
                        <span class="report-details-value">{{ $plantation_record->initial_no}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Current Planted:</span>
                        <span class="report-details-value">{{ $plantation_record->current_planted}}</span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-4">
                    <div class="report-details-input">
                        <span class="report-details-label">Density (ha):</span>
                        <span class="report-details-value">{{ $plantation_record->density_ha}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Status:</span>
                        <span class="report-details-value">{{ $plantation_record->status}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Latitude:</span>
                        <span class="report-details-value">{{ $plantation_record->latitude}}</span>
                    </div>
                    <div class="report-details-input">
                        <span class="report-details-label">Longitude:</span>
                        <span class="report-details-value">{{ $plantation_record->longitude}}</span>
                    </div>
                </div>
                <div class="w-full grid grid-cols-1">
                    <div class="report-details-input">
                        <span class="report-details-label">Remarks:</span>
                        <span class="report-details-value">{{ $plantation_record->remark}}</span>
                    </div>
                </div>
            </div>
            <div class="report-main flex flex-col justify-center mt-10">
                <h2 class="font-bold underline">PLANTATION ANALYSIS</h2>
                <input type="text" hidden id="survival_rates" value="{{$survival_rates}}">
                <input type="text" hidden id="no_planted_data" value="{{$no_planted_data}}">
                <div class="grid md:grid-cols-2 mt-5 w-full gap-2">
                    <div class="flex flex-col">
                        <h1 class="text-center text-black">Plantations Survival Rate Data</h1>
                        <canvas id="survival_rate"></canvas>
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-center text-black">Target No. Planted & Current No. Planted</h1>
                        <canvas id="planted_data"></canvas>
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
<script src="{{ asset('static/js/plantation_report.js') }}"></script>


@stop

@section('additional_scripts')
@include('admin.reports.report_scripts')
@stop