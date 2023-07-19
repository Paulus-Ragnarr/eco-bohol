@extends('layouts.admin')


@section('title', 'Eco Bohol - Nursery Record')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Nursery Record</h1>
            <a href='/admin/manage-nurseries'
                class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="flex justify-end">
            <a href={{ '/admin/manage-nurseries/update?nursery_id=' . $nursery->nursery_id }} class="primary-btn">Edit
                Record</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-5">
            {{-- <div>
            <p>Nursery ID</p>
            <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{$nursery->nursery_id}}</p>
        </div> --}}
            <div>
                <p>Nursery Address</p>
                <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $nursery->nursery_address }}</p>
            </div>
            <div>
                <p>Date Established</p>
                <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $nursery->date_established }}</p>
            </div>
            <div>
                <p>Organization Name</p>
                @foreach ($managers as $manager)
                    @if ($manager->manager_id == $nursery->manager_id)
                        <p class="bg-gray-100 p-2 rounded-md shadow-md hover:bg-green-100">{{ $manager->org_name }}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="flex justify-end mb-5">
            <a href={{ ' /admin/manage-nurseries/add-batch?nursery_id=' . $nursery->nursery_id }}
                class="primary-btn">Add</a>
        </div>
        <div>
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
            {{ $batches->links('vendor.pagination.tailwind') }}
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-2">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-50 uppercase bg-green-600">
                        <tr>
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
                            <th scope="col" class="py-3 px-6">
                                Status
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batches as $batch)
                            @foreach ($speciesrecord as $mangrove)
                                @if ($mangrove->species_id == $batch->species_id)
                                    <td class="py-4 px-6">
                                        {{ $mangrove->common_name }}
                                    </td>
                                @endif
                            @endforeach
                            <td class="py-4 px-6">
                                {{ $batch->date_potted }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $batch->no_potted }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $batch->current_no_potted }}
                            </td>
                            <td class="py-4 px-6 {{ $batch->status == 'Active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $batch->status }}
                            </td>
                            <td class="py-4 px-6">
                                <a href={{ '/admin/manage-nurseries/view-batch?batch_id=' . $batch->batch_id . '&nursery_id=' . $nursery->nursery_id }}
                                    class="font-medium
                            text-blue-600
                            hover:underline">View</a>
                                <span>|</span>
                                <a href={{ '/admin/manage-nurseries/update-batch?batch_id=' . $batch->batch_id . '&nursery_id=' . $nursery->nursery_id }}
                                    class="font-medium
                                text-blue-600
                                hover:underline">Update</a>
                                <span>|</span>
                                <button class="open-archive" data-record-id="{{ $batch->batch_id }}">
                                    <a href="#"
                                        class="font-medium
                                            text-blue-600
                                            hover:underline">{{ $batch->status == 'Active' ? 'Archived' : 'Active' }}</a>
                                </button>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="overlay" class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60"></div>
            <div id="archive"
                class="fixed hidden z-50 top-1/4 left-1/2 -translate-x-1/2 sm:-translate-x-1/3 -translate-y-1/2 w-11/12 sm:w-1/2 md:w-1/3 bg-white rounded-md px-7 py-7 space-y-5 drop-shadow-lg">
                <h1 class="text-2xl font-semibold">Archive Record</h1>
                <div class="py-5 border-t border-b border-gray-300">
                    <p class="text-justify text-lg"><span class="font-bold text-red-900">Warning!</span> Do you want to
                        archive this
                        Batch Propagule Record?</p>
                </div>
                <div class="flex flex-row justify-center sm:justify-end">
                    <form action="/admin/archive-batch-propagule" id="archive-form">
                        <input type="text" hidden name='species_id' id="species_id">
                        <button id="yes" type="submit"
                            class="px-5 py-2 primary-btn w-20 text-white cursor-pointer rounded-md sm:mb-0 sm:ml-4">
                            Yes</button>
                    </form>
                    <button id="close"
                        class="sm:ml-4 px-5 py-2 w-20 bg-gray-400 hover:bg-gray-600 text-white cursor-pointer rounded-md">
                        No</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var openButtons = document.querySelectorAll('.open-archive');
        var archive = document.getElementById('archive');
        var closeButton = document.getElementById('close');
        var yesButton = document.getElementById('yes');
        var overlay = document.getElementById('overlay');
        var recordId = null;
        var species_id_input = document.getElementById('species_id');

        openButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                recordId = this.getAttribute('data-record-id');
                species_id_input.value = recordId
                archive.classList.remove('hidden');
                overlay.classList.remove('hidden');
            });
        });

        closeButton.addEventListener('click', function() {
            archive.classList.add('hidden');
            overlay.classList.add('hidden');
        });
    </script>
@stop
