@extends('layouts.admin')


@section('title', 'Eco Bohol - Plantation Record')


@section('content')

    <div class="common-background flex-1 h-screen pt-5 px-5 pb-40 overflow-y-auto space-y-2">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Plantation Record</h1>
            <a href='/admin/manage-plantations'
                class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
            <input type="text" id="plantation_id" hidden value={{ $plantation->plantation_id }}>
        </div>
        <div class="grid grid-cols-1 md:grid-rows-2 space-y-2">
            <div class="grid grid-cols-1 md:grid-cols-2 h-1/2">
                <div class="">
                    <div class="flex flex-wrap space-y-7 space-x-1 border-b pb-4 mr-4">
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Plantation Code: </span>
                                <span class="font-bold">{{ $plantation->unique_code }}</span>
                            </span>
                            {{-- <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                            <span class="">Penro: </span>
                            <span class="font-bold">{{ $plantation->penro }}</span>
                        </span> --}}
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Cenro: </span>
                                <span class="font-bold">{{ $plantation->cenro }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">District: </span>
                                <span class="font-bold">{{ $plantation->district }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Date Started: </span>
                                <span class="font-bold">{{ $plantation->date_started }}</span>
                            </span>
                        </div>
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Address: </span>
                                <span class="font-bold">{{ $plantation->plantation_address }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Component: </span>
                                <span class="font-bold">{{ $plantation->component }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Commodity: </span>
                                <span class="font-bold">{{ $plantation->commodity }}</span>
                            </span>
                        </div>
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Fund Source: </span>
                                <span class="font-bold">{{ $plantation->fund_source }}</span>
                            </span>
                        </div>
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Contractor: </span>
                                @foreach ($managers as $managers)
                                    @if ($managers->manager_id == $plantation->manager_id)
                                        <span class="font-bold">{{ $managers->org_name }}</span>
                                    @endif
                                @endforeach
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-wrap space-y-7     mt-4 border-b pb-5 mr-4">
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Total Area: </span>
                                <span class="font-bold">{{ $plantation->total_area }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Tenure: </span>
                                <span class="font-bold">{{ $plantation->tenure }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Latitude: </span>
                                <span class="font-bold">{{ $plantation->latitude }}</span>
                                <input type="text" id="latitude" value="{{ $plantation->latitude }}" hidden>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Longitude: </span>
                                <span class="font-bold">{{ $plantation->longitude }}</span>
                                <input type="text" id="longitude" value="{{ $plantation->longitude }}" hidden>
                            </span>
                        </div>
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">No Loa: </span>
                                <span class="font-bold">{{ $plantation->no_loa }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Target Loa: </span>
                                <span class="font-bold">{{ $plantation->target_loa }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Species Planted: </span>
                                <span class="font-bold">{{ str_replace(',', ' ', $plantation->species) }}</span>
                            </span>
                        </div>
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Initial Number: </span>
                                <span class="font-bold">{{ $plantation->initial_no }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Target Number: </span>
                                <span class="font-bold">{{ $plantation->target_no }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Current No. Planted: </span>
                                <span class="font-bold">{{ $plantation->current_planted }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Density (Ha): </span>
                                <span class="font-bold">{{ $plantation->density_ha }}</span>
                            </span>
                        </div>
                        <div class="space-x-2">
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Status: </span>
                                <span class="font-bold">{{ $plantation->status }}</span>
                            </span>
                            <span class="items-center p-2 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Loa Attachment: </span>
                                <span class="font-bold">
                                    @foreach ($plantation->loa_attachment as $attachment)
                                        @if ($attachment->attachmentFor == 'loa_attachment')
                                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                                class="underline text-blue-400
                                        hover:text-blue-600">{{ $attachment->attachmentFilename }}</a>
                                        @endif
                                    @endforeach
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 mr-4">
                        <div
                            class="flex flex-col items-center rounded-md {{ $latest_record && $latest_record->survival_rate > 85 ? 'bg-green-300' : 'bg-red-300' }}">
                            <div>Survival Rate</div>
                            <div class=" text-xl">{{ $latest_record ? $latest_record->survival_rate : 0.0 }}%</div>
                        </div>
                    </div>
                </div>
                <div class="h-full bg-gray-300" id="map"></div>
            </div>
            <div class="space-y-2">
                <div class="">
                    <div class="flex justify-end">
                        @if ($user->user_role == 'manager')
                            <a href={{ '/admin/manage-plantations/add-monitoring-record?plantation_id=' . $plantation->plantation_id }}
                                class="primary-btn">Add Monitoring Record</a>
                        @elseif ($user->user_role == 'officer')
                            <a href={{ '/admin/manage-plantations/add-officer-monitoring-record?plantation_id=' . $plantation->plantation_id }}
                                class="primary-btn">Add Monitoring Record</a>
                        @endif
                    </div>
                    <div class="justify-start">
                        @if ($user->user_role == 'admin')
                            <h1 class="text-xl mt-4 px-2">Officer Monitoring Record</h1>
                        @endif
                    </div>
                </div>
                <div class="">
                    @if ($user->user_role == 'officer' || $user->user_role == 'admin')
                        @if (Session::has('success'))
                            @if (Session::has('success'))
                                <div id="success-alert"
                                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-3 rounded relative sm:w-2/3 lg:w-full xl:w-full"
                                    role="alert">
                                    <strong class="font-bold">Success!</strong>
                                    <span class="block sm:inline">{{ Session::get('success') }}</span>
                                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                                        onclick="document.getElementById('success-alert').style.display = 'none';">
                                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <title>Close</title>
                                            <path
                                                d="M14.348 5.652a.5.5 0 0 0-.707 0L10 9.293 6.354 5.647a.5.5 0 0 0-.707.707L9.293 10l-3.646 3.646a.5.5 0 1 0 .707.707L10 10.707l3.646 3.646a.5.5 0 0 0 .707-.707L10.707 10l3.646-3.646a.5.5 0 0 0 0-.707z" />
                                        </svg>
                                    </span>
                                </div>
                            @endif
                        @endif
                        {{ $records->links('vendor.pagination.tailwind') }}
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-50 uppercase bg-green-600">
                                    <th scope="col" class="py-3 px-6">
                                        Date Monitored
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Area(ha)
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Spacing
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        No. Plots
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        No Survived
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        No. Dead
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Current No. Planted
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Survival Rate
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Evaluator
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Actions
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr class="bg-white border-b ">
                                            <th scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->date_monitored }}
                                            </th>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->area }}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->spacing }}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->no_plots }}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->no_survived }}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->no_dead }}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->current_planted }}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->survival_rate }}%
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                @foreach ($officer as $officers)
                                                    @if ($officers->user_id == $record->user_id)
                                                        {{ $officers->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="py-4 px-6">
                                                <a href={{ '/admin/manage-plantations/view-officer-monitoring-record?monitor_id=' .
                                                    $record->monitor_id .
                                                    '&plantation_id=' .
                                                    $plantation->plantation_id }}
                                                    class="font-medium
                                text-blue-600
                                hover:underline">View</a>
                                                <span>|</span>
                                                <a href={{ '/admin/manage-plantations/update-officer-monitoring-record?monitor_id=' .
                                                    $record->monitor_id .
                                                    '&plantation_id=' .
                                                    $plantation->plantation_id }}
                                                    class="font-medium
                                text-blue-600
                                hover:underline {{ $record->user_id != $user->user_id ? 'disabled' : null }}">Update</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div>
                    @if ($user->user_role == 'manager')
                        @if (Session::has('success'))
                            @if (Session::has('success'))
                                <div id="success-alert"
                                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-3 rounded relative sm:w-2/3 lg:w-full xl:w-full"
                                    role="alert">
                                    <strong class="font-bold">Success!</strong>
                                    <span class="block sm:inline">{{ Session::get('success') }}</span>
                                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                                        onclick="document.getElementById('success-alert').style.display = 'none';">
                                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <title>Close</title>
                                            <path
                                                d="M14.348 5.652a.5.5 0 0 0-.707 0L10 9.293 6.354 5.647a.5.5 0 0 0-.707.707L9.293 10l-3.646 3.646a.5.5 0 1 0 .707.707L10 10.707l3.646 3.646a.5.5 0 0 0 .707-.707L10.707 10l3.646-3.646a.5.5 0 0 0 0-.707z" />
                                        </svg>
                                    </span>
                                </div>
                            @endif
                        @endif
                        {{ $records->links('vendor.pagination.tailwind') }}
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-50 uppercase bg-green-600">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            Date Monitored
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Area
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            No. Survived
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            No. Dead
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            No. Replanted
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Current Planted
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Remarks
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr class="bg-white border-b ">
                                            <th scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $record->date_monitored }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $record->area }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $record->no_survived }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $record->no_dead }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $record->no_replanted }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $record->current_planted }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $record->remarks }}
                                            </td>
                                            <td class="py-4 px-6">
                                                <a href={{ '/admin/manage-plantations/update-monitoring-record?monitor_id=' .
                                                    $record->monitor_id .
                                                    '&plantation_id=' .
                                                    $plantation->plantation_id }}
                                                    class="font-medium
                                text-blue-600
                                hover:underline {{ $loop->index > 0 || intval(request()->page > 1) ? 'disabled' : null }}">Update</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('static/js/heatmap_plantation.js') }}"></script>
    <script
        src="
                                                                        https://maps.googleapis.com/maps/api/js?key=AIzaSyD3EnVFiQGl-stBLE-pR_dCBpT0H3JeDzM&callback=initMap&libraries=visualization"
        async defer></script>

@stop
