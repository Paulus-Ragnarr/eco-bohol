@extends('layouts.admin')


@section('title', 'Eco Bohol - Manage Maps')

@php
$menu = 'index';
@endphp


@section('content')

<div class="common-background flex-1 flex flex-col items-center h-full overflow-y-scroll">
    <div class="flex-1 w-full relative border rounded-lg shadow-sm mb-2">
        <div
            class="md:w-1/6 absolute top-20 left-2 md:left-20 z-10 bg-white p-4 rounded-md shadow-md flex flex-col space-y-2 {{ $user->user_role == 'admin' ? 'hidden' : '' }}">
            <div class="flex flex-col">
                <label for="infotype" class="text-sm text-gray-600">Info Type</label>
                <select name="infotype" id="infotype" class="common-input">
                    <option value="" selected>Select Info Type</option>
                    <option value="naturally_grown">Naturally Grown</option>
                    <option value="plantation">Plantation</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="cenro" class="text-sm text-gray-600">CENRO</label>
                <select name="cenro" id="cenro" class="common-input">
                    <option value="" selected>Select CENRO</option>
                    <option value="tagbilaran">CENRO Tagbilaran</option>
                    <option value="talibon">CENRO Talibon</option>
                </select>
            </div>
            {{-- <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700"
                id='get-map-image'>Print</button> --}}
            <button class="primary-btn" id='filter-data'>Filter</button>
        </div>
        <div class="md:w-1/4 absolute bottom-20 left-2 md:left-20 z-10 bg-black/30 p-2 rounded-md shadow-md text-white"
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
        <div id="map" style="height: 100%; width: 100%"></div>
    </div>
    <div
        class="border rounded-lg shadow-2xl h-3/5 w-full flex flex-col-reverse space-y-2 md:space-y-0 md:flex-row justify-center md:pt-5 pb-2 {{ $user->user_role != 'admin' ? 'hidden' : '' }}">
        <div class="flex-1 pl-2 md:pl-12     pr-2 md:mt-0 overflow-y-auto">
            @if (Session::has('success'))
            @if (Session::has('success'))
            <div id="success-alert"
                class="bg-green-100 border mb-2 border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ Session::get('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                    onclick="document.getElementById('success-alert').style.display = 'none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 5.652a.5.5 0 0 0-.707 0L10 9.293 6.354 5.647a.5.5 0 0 0-.707.707L9.293 10l-3.646 3.646a.5.5 0 1 0 .707.707L10 10.707l3.646 3.646a.5.5 0 0 0 .707-.707L10.707 10l3.646-3.646a.5.5 0 0 0 0-.707z" />
                    </svg>
                </span>
            </div>
            @endif
            @endif
            @if ($errors->any())
            <div id="error-alert" class="bg-red-100 border mb-2 border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>-{{ $error }}</li>
                    @endforeach
                </ul>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                    onclick="document.getElementById('error-alert').style.display = 'none';">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 5.652a.5.5 0 0 0-.707 0L10 9.293 6.354 5.647a.5.5 0 0 0-.707.707L9.293 10l-3.646 3.646a.5.5 0 1 0 .707.707L10 10.707l3.646 3.646a.5.5 0 0 0 .707-.707L10.707 10l3.646-3.646a.5.5 0 0 0 0-.707z" />
                    </svg>
                </span>
            </div>
            @endif
            <div class="flex justify-between mb-5 sticky top-0 bg-white">
                <form action="/admin/manage-maps" class="flex items-center">
                    <input class="px-2 py-2 bg-gray-100 focus:outline-green-600 text-black" type="text"
                        placeholder="Search" value="{{ $searchTerm }}" name="searchTerm">
                    <button type="submit" class="bg-green-600 py-2 px-4 text-white">Search</button>
                </form>
                <button class="primary-btn" id="toggle-views">Add Geolocation</button>
            </div>
            <div>
                @if ($searchTerm)
                <h2>Search: {{ $searchTerm }}</h2>
                @endif
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-2" name="geolocations">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-50 uppercase bg-green-600">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Latitude
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Longitude
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Barangay
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Town
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Description
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Cenro
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Info Type
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Species
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Intensity Count
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($searchTerm)
                        @if (count($locations) == 0)
                        <tr>
                            <td colspan="6" class="text-center py-6">
                                <h3>No Location Coordinates found</h3>
                            </td>
                        </tr>
                        @endif
                        @endif
                        @foreach ($locations as $location)
                        <tr class="bg-gray-200 border-b hover:bg-gray-200">
                            <td scope="row" class=" px-4 font-medium text-gray-900 whitespace-nowrap">
                                <input type="text" name="latitude" id="latitude_{{ $location->location_id }}"
                                    class="manage-maps-location-input" value={{ $location->latitude }} disabled>
                            </td>
                            <td class=" px-4">
                                <input type="text" name="longitude" id="longitude_{{ $location->location_id }}"
                                    class="manage-maps-location-input" value={{ $location->longitude }} disabled>
                            </td>
                            {{-- <td class="py-1 px-4">
                                <input type="text" name="locality_note" id="locality_note_{{ $location->location_id }}"
                                    disabled class="manage-maps-location-input" value="{{ $location->locality_note }}">
                            </td> --}}
                            <td class=" px-4">
                                <input type="text" name="barangay" id="barangay_{{ $location->location_id }}" disabled
                                    class="manage-maps-location-input" value="{{ $location->barangay }}">
                            </td>
                            <td class=" px-4">
                                <input type="text" name="town" id="town_{{ $location->location_id }}" disabled
                                    class="manage-maps-location-input" value="{{ $location->town }}">
                            </td>
                            <td class="px-4">
                                <input type="text" name="description" id="description_{{ $location->location_id }}"
                                    class="manage-maps-location-input" value="{{ $location->description }}" disabled>
                            </td>
                            <td class="px-4">
                                {{-- <input type="text" name="cenro" id="cenro_{{ $location->location_id }}"
                                    class="manage-maps-location-input" value="{{ $location->cenro }}" disabled> --}}
                                <select name="cenro" class="manage-maps-input manage-maps-select" disabled
                                    id="cenro_{{ $location->location_id }}">
                                    <option value="tagbilaran" {{ $location->cenro == 'tagbilaran'
                                        ? '
                                        selected'
                                        : null }}>
                                        Tagbilaran</option>
                                    <option value="talibon" {{ $location->cenro == 'talibon'
                                        ? '
                                        selected'
                                        : null }}>
                                        Talibon</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="py-1 px-1">
                                <button class="font-medium
                                text-blue-600
                                hover:underline update-location" name={{ $location->location_id }}>
                                    Update
                                </button>
                                <span>|</span>
                                <button class="toggle-add font-medium
                                text-blue-600
                                hover:underline" data-record-id="{{ $location->location_id }}">
                                    Add Species
                                </button>
                            </td>
                        </tr>
                        @foreach ($location->species_infos as $species_info)
                        <tr class="bg-white border-b ">
                            <td scope="row" class="px-4 font-medium text-gray-900 whitespace-nowrap">
                            </td>
                            <td class="px-4">
                            </td>
                            <td class="px-4">
                            </td>
                            <td class="px-4">
                            </td>
                            <td class="px-4">
                            </td>
                            <td class="px-4">
                            </td>
                            <td class="px-4">
                                <select name="infotype" class="manage-maps-input manage-maps-select" disabled
                                    id="infotype_{{ $species_info->species_infos_id }}">
                                    <option value="naturally_grown" {{ $species_info->infotype == 'naturally_grown'
                                        ? '
                                        selected'
                                        : null }}>
                                        Naturally Grown</option>
                                    <option value="plantation" {{ $species_info->infotype == 'plantation' ? 'selected' :
                                        null }}>
                                        Plantation</option>
                                </select>
                            </td>
                            <td class="px-4">
                                <select name="species_record" class="manage-maps-input manage-maps-select" disabled
                                    id="species_record_{{ $species_info->species_infos_id }}">
                                    @foreach ($species as $item)
                                    <option value="{{ $item->species_id }}" {{ $species_info->species_record->species_id
                                        == $item->species_id ? 'selected' : null }}>
                                        {{ $item->common_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4">
                                <input type="number" name="intensity_count" class="manage-maps-input" disabled value={{
                                    $species_info->intensity_count }}
                                id="intensity_count_{{ $species_info->species_infos_id }}">
                            </td>
                            <td class="px-4">
                                <button class="font-medium
                                text-blue-600
                                hover:underline update-species-info" name={{ $species_info->species_infos_id }}>
                                    Update
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $locations->links('vendor.pagination.tailwind') }}
        </div>
        <div class="flex-1 transition-all duration-700 ease-in-out mx-2 md:mx-0 md:mr-5 px-5 mb-5 overflow-y-auto border"
            id="add-geolocation-form">
            <div id="geo-form" class="">
                <form method="post" class="space-y-2 pt-1" action="/admin/manage-maps/add"
                    enctype="multipart/form-data">
                    @csrf
                    <h1 class="text-lg">Add Geolocation</h1>
                    <div class="flex w-full space-x-2">
                        <div class="flex w-full flex-col">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="common-input" name="latitude" value="{{ old('latitude') }}"
                                required>
                        </div>
                        <div class="flex w-full flex-col">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="common-input" name="longitude" value="{{ old('longitude') }}"
                                required>
                        </div>
                    </div>
                    <div class="flex w-full space-x-2">
                        <div class="flex w-full space-x-1">
                            <div class="flex w-full flex-col">
                                <label for="barangay">Barangay</label>
                                <input type="text" class="common-input w-full" name="barangay"
                                    value="{{ old('barangay') }}" required>
                            </div>
                            <div class="flex w-full flex-col">
                                <label for="town">Town / City</label>
                                <input type="text" class="common-input w-full" name="town" value="{{ old('town') }}"
                                    required>
                            </div>
                            {{-- <div class="flex w-full flex-col">
                                <label for="province">Province</label>
                                <input type="text" class="common-input w-full" name="province" value="Bohol" disabled>
                            </div> --}}
                        </div>
                        <div class="flex w-full flex-col">
                            <label for="description">Description of Location</label>
                            <input type="text" class="common-input w-full" name="description"
                                value="{{ old('description') }}" required>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label for="cenro" class="text-sm text-gray-600">CENRO</label>
                        <select name="cenro" class="common-input" required>
                            <option value="tagbilaran">Tagbilaran</option>
                            <option value="talibon">Talibon</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <h1>Species</h1>
                    </div>
                    <ul id="species_list" class="flex flex-col w-full overflow-auto">
                        <li>
                            <div class="flex space-x-2 pb-2">
                                <div class="flex flex-col w-full">
                                    <label for="species_1" class="text-sm text-gray-600">Species</label>
                                    <select name="species_1" class="common-input" required>
                                        @foreach ($species as $item)
                                        <option value="{{ $item->species_id }}">{{ $item->common_name }} -
                                            <em class="">{{ $item->scientific_name }}</em>
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label for="intensity_1" class="text-sm text-gray-600">Intensity</label>
                                    <input type="number" class="common-input" name="intensity_1" min="1" max="10000"
                                        value="{{ old('intensity_1') }}" required>
                                </div>
                                <div class="flex flex-col">
                                    <label for="infotype_1" class="text-sm text-gray-600">Info Type</label>
                                    <select name="infotype_1" class="common-input" required>
                                        <option value="naturally_grown">Naturally Grown</option>
                                        <option value="plantation">Plantation</option>
                                    </select>
                                </div>

                            </div>
                        </li>
                    </ul>
                    <div class="flex flex-row gap-3">
                        <div class="flex items-center">
                            <h1>Add</h1>
                            <button class="ml-2 text-2xl text-green-700 hover:bg-green-200 px-2 rounded-md border"
                                onclick="add_species_slot(this)" type="button">
                                +
                            </button>
                        </div>
                        <div class="flex items-center">
                            <h1 class="text-red-700">Delete </h1>
                            <button class="ml-2 text-2xl text-red-700 hover:bg-red-200 px-2 rounded-md border"
                                onclick="delete_species_slot()" type="button">
                                -
                            </button>
                        </div>
                    </div>
                    <input type="number" class="hidden" id="species_counter" name="species_counter">
                    <div class="flex justify-end">
                        <button type="submit" class="primary-btn w-full mb-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @csrf
    <div id="overlay" class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60">
    </div>
    <div id="activate"
        class="fixed hidden z-50 top-1/4 left-1/2 -translate-x-1/2 sm:-translate-x-1/3 -translate-y-1/4 w-64 sm:w-96 md:w-96 bg-white rounded-md px-7 py-7 space-y-5 drop-shadow-lg">
        <h1 class="text-2xl font-semibold">Add Species</h1>
        <div class="flex flex-col items-center justify-center gap-3">
            <form id="add_species_form" class="flex flex-col gap-3">
                <div class="flex flex-col gap-2 w-full">
                    <input type="text" hidden name='location_id' id="location_id">
                    <label for="species_id" class="text-sm text-gray-600">Species Name</label>
                    <select class="common-input w-52 md:w-full" name="species_id" id="species_id" required>
                        <option value="">Select a Species</option>
                        @foreach ($species as $item)
                        <option value="{{ $item->species_id }}">{{ $item->common_name }} -
                            <em class="">{{ $item->scientific_name }}</em>
                        </option>
                        @endforeach
                        @error('species')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </select>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label for="intensity" class="text-sm text-gray-600">Intensity Count</label>
                    <input type="number" class="common-input w-52 md:w-full" name="intensity" id="intensity"
                        value="{{ old('intensity') }}" min="1" max="10000" required>
                    @error('intensity')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <label for="infotype_" class="text-sm text-gray-600">Info Type</label>
                    <select class="common-input w-52 md:w-full" name="infotype_" id="infotype_" required>
                        <option value="">Select a Info Type</option>
                        <option value="naturally_grown">Naturally Grown</option>
                        <option value="plantation">Plantation</option>
                    </select>
                    @error('infotype')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-center items-center w-full">
                    <button id="yes" type="submit"
                        class="py-2 primary-btn w-52 md:w-80 text-white cursor-pointer rounded-md">
                        Submit
                    </button>
                </div>
            </form>
            <div class="flex justify-center items-center">
                <button id="close"
                    class=" px-5 py-2 w-52 md:w-80 bg-gray-400 hover:bg-gray-600 text-white cursor-pointer rounded-md">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var openButtons = document.querySelectorAll('.toggle-add');
        var archive = document.getElementById('activate');
        var closeButton = document.getElementById('close');
        var overlay = document.getElementById('overlay');
        var recordId = null;
        var location_input = document.getElementById('location_id');

        openButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                recordId = this.getAttribute('data-record-id');
                location_input.value = recordId
                archive.classList.remove('hidden');
                overlay.classList.remove('hidden');
            });
        });
        closeButton.addEventListener('click', function() {
            archive.classList.add('hidden');
            overlay.classList.add('hidden');
            add_species_form.reset();
        });
</script>

<script>
    let toggle_maps_button = document.getElementById('toggle-views');
        let geo_form = document.getElementById('add-geolocation-form');
        let geolocations = document.getElementById('geolocations');
        let geo_form_inner = document.getElementById('geo-form');
        toggle_maps_button.addEventListener('click', function() {
            if (geo_form.classList.contains('flex-1')) {
                geo_form.classList.toggle('flex-1');
                geo_form.classList.toggle('border')
                geo_form_inner.classList.toggle('hidden')
            } else {
                geo_form.classList.toggle('flex-1');
                geo_form.classList.toggle('border')
                setTimeout(() => {
                    geo_form_inner.classList.toggle('hidden')
                }, 200);
            }
        })

        toggle_maps_button.click();

        var species_count = 1;
        var species_list = document.getElementById('species_list')
        var species_counter = document.getElementById('species_counter')

        species_counter.value = species_count

        function add_species_slot(e) {
            species_count++;
            const list_item = document.createElement('li');
            list_item.innerHTML = `
        <div class="flex space-x-2 pb-2">
            <div class="flex flex-col w-full">
                <label for="species_${species_count}" class="text-sm text-gray-600">Species</label>
                <select name="species_${species_count}" class="common-input" required>
                    @foreach ($species as $item)
                    <option value="{{ $item->species_id }}">{{ $item->common_name }} -
                        <em class="">{{ $item->scientific_name }}</em>
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col w-full">
                <label for="intensity_${species_count}" class="text-sm text-gray-600">Intensity</label>
                <input type="number" class="common-input" name="intensity_${species_count}" min="0" value="{{ old('intensity_${species_count}') }}" required>
            </div>
            <div class="flex flex-col">
                <label for="infotype_${species_count}" class="text-sm text-gray-600">Info Type</label>
                <select name="infotype_${species_count}" class="common-input" required>
                    <option value="naturally_grown">Naturally Grown</option>
                    <option value="plantation">Plantation</option>
                </select>
            </div>
        </div>
        `
            species_counter.value = species_count
            species_list.appendChild(list_item);
        }

        function delete_species_slot() {
            if (species_count > 1) {
                species_list.removeChild(species_list.lastChild);
                species_count--;
                species_counter.value = species_count;
            }
        }
</script>


<script src="{{ asset('static/js/manage-maps-update.js') }}"></script>
<script src="{{ asset('static/js/add_species_maps.js') }}"></script>
{{-- <script src="{{ asset('static/js/html2canvas.min.js') }}"></script> --}}
<script src="{{ asset('static/js/heatmap_2.js') }}"></script>
{{-- <script src="{{ asset('static/js/saveheatmapimage.js')}}"></script> --}}
<script src="{{ asset('static/js/jquery-3.6.3.min.js') }}"></script>
<script
    src="
                                                                                                                                                                                                                                                                                                                                                        https://maps.googleapis.com/maps/api/js?key=AIzaSyD3EnVFiQGl-stBLE-pR_dCBpT0H3JeDzM&callback=initMap&libraries=visualization"
    async defer></script>
@stop