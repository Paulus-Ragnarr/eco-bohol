@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')


@section('content')

<div class="common-background flex-1 flex flex-col items-center h-full overflow-y-scroll">
    <div class="flex-1 w-full relative border rounded-lg shadow-sm mb-2">
        <div
            class="md:w-1/4 absolute top-20 left-2 md:left-20 z-10 bg-black/20 p-4 rounded-md shadow-md flex flex-col space-y-2">
            <div class="flex flex-col">
                <label for="infotype" class="text-sm text-white">Info Type</label>
                <select name="infotype" id="infotype" class="filter-map-select">
                    <option value="" selected>Select Info Type</option>
                    <option value="naturally_grown">Naturally Grown</option>
                    <option value="plantation">Plantation</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="cenro" class="text-sm text-white">CENRO</label>
                <select name="cenro" id="cenro" class="filter-map-select">
                    <option value="" selected>Select CENRO</option>
                    <option value="tagbilaran">Tagbilaran</option>
                    <option value="talibon">Talibon</option>
                </select>
            </div>
            <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700"
                id='get-map-image'>Print</button>
            <button class="primary-btn" id='filter-data'>Filter</button>
        </div>
        <div class="md:w-1/4 absolute bottom-20 left-2 md:left-20 z-10 bg-black/20 p-2 rounded-md shadow-md text-white"
            id="summary_div">
            <div>
                As of: <span id="summary_date"></span>
            </div>
            <div class="items-center">
                <div class="summary_label">
                    <span>Naturally Grown: </span>
                    <span id="naturally_grown_heatmap"></span>
                </div>
                <div class="h-2 w-full plan-gradient"></div>
            </div>
            <div class="items-center">
                <div class="summary_label">
                    <span>Plantation: </span>
                    <span id="plantation_heatmap"></span>
                </div>
                <div class="h-2 w-full nat-gradient"></div>
            </div>
        </div>
        <div id="map" style="height: 100%; width: 100%">
        </div>
    </div>
</div>

@stop

@section('additional_scripts')
<script src="{{ asset('static/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('static/js/heatmap_2.js') }}"></script>
<script src="{{ asset('static/js/saveheatmapimage.js')}}"></script>
<script src="{{ asset('static/js/jquery-3.6.3.min.js') }}"></script>
<script
    src="
        https://maps.googleapis.com/maps/api/js?key=AIzaSyD3EnVFiQGl-stBLE-pR_dCBpT0H3JeDzM&callback=initMap&libraries=visualization"
    async defer>
</script>
@include('admin.reports.report_scripts')
@stop