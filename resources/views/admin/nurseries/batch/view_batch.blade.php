@extends('layouts.admin')


@section('title', 'Eco Bohol - Nursery Batch Record')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Batch Propagule</h1>
            <a href={{ '/admin/manage-nurseries/view?nursery_id=' . $nursery->nursery_id }}
                class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="grid grid-cols-4 gap-3 mb-5">
            <div>
                <p>Species</p>
                @foreach ($speciesrecord as $mangrove)
                    @if ($mangrove->species_id == $batch->species_id)
                        <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $mangrove->common_name }}</p>
                    @endif
                @endforeach
            </div>
            <div>
                <p>Initial Number Potted</p>
                <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $batch->no_potted }}</p>
            </div>
            <div>
                <p>Current Number Potted</p>
                <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $batch->current_no_potted }}</p>
            </div>
            <div>
                <p>Date Potted</p>
                <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $batch->date_potted }}</p>
            </div>
            <div>
                <p>Batch Status</p>
                <p
                    class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100 {{ $batch->status == 'Active' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $batch->status }}</p>
            </div>
            <div>
                <p>Survival Rate</p>
                <p
                    class="p-2 rounded-md shadow-md {{ ($latest_record && $latest_record->survival_rate > 80) || !$latest_record ? 'bg-green-300' : 'bg-red-300' }}">
                    {{ $latest_record ? $latest_record->survival_rate : 100.0 }}%
                </p>
            </div>
            <div>
                <p>Remarks</p>
                <p class="flex bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $batch->remarks }}</p>
            </div>
        </div>
        <div class="flex justify-start space-x-2">
            <a href={{ '/admin/manage-nurseries/view-batch?batch_id=' . $batch->batch_id . '&nursery_id=' . $nursery->nursery_id }}
                class="primary-btn">View Batch Monitoring</a>
            <a href={{ '/admin/manage-nurseries/view-batch-purchase?batch_id=' . $batch->batch_id . '&nursery_id=' . $nursery->nursery_id }}
                class="primary-btn">View Batch Purchased or Planted</a>
        </div>
        <div class="flex justify-between pt-5 mb-1">
            <div>
                <h1 class="text-bold text-2xl">Batch Monitoring</h1>
            </div>
            <div>
                <a href={{ ' /admin/manage-nurseries/add-batch-monitoring?nursery_id=' . $nursery->nursery_id . '&batch_id=' . $batch->batch_id }}
                    class="primary-btn">Add Monitoring</a>
            </div>
        </div>
        <div class="flex flex-col">
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
            {{ $batch_monitoring_records->links('vendor.pagination.tailwind') }}
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-2">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-50 uppercase bg-green-600">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Date Monitored
                            </th>
                            <th scope="col" class="py-3 px-6">
                                No. Potted
                            </th>
                            <th scope="col" class="py-3 px-6">
                                No. Survived
                            </th>
                            <th scope="col" class="py-3 px-6">
                                No. Dead
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Survival Rate
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
                        @foreach ($batch_monitoring_records as $batch_monitoring)
                            <tr class="bg-white border-b ">
                                <td class="py-4 px-6">
                                    {{ $batch_monitoring->date_monitored }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_monitoring->current_no_potted }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_monitoring->no_survived }}
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $batch_monitoring->no_dead }}
                                </td>
                                <td
                                    class="py-4 px-6 font-medium whitespace-nowrap {{ $batch_monitoring && $batch_monitoring->survival_rate > 80 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $batch_monitoring->survival_rate }}%
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $batch_monitoring->remarks }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href={{ '/admin/manage-nurseries/update-batch-monitoring?batch_id=' . $batch_monitoring->batch_id . '&nursery_id=' . $nursery->nursery_id . '&batch_monitoring_id=' . $batch_monitoring->monitor_id }}
                                        class="font-medium text-blue-600 hover:underline {{ $loop->index > 0 || intval(request()->page > 1) ? 'disabled' : null }}">Update</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
