@extends('layouts.admin')

@section('title', 'Eco Bohol - Mangrove Records')

@section('content')

    <div class="common-background flex-1 p-5">
        <div class="flex flex-col md:flex-row md:justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Species Records</h1>
        </div>
        @if (Session::has('success'))
            @if (Session::has('success'))
                <div id="success-alert"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative sm:w-2/3 lg:w-full xl:w-full"
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
        @if (Session::has('error'))
            @if (Session::has('error'))
                <div id="error-alert"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative sm:w-2/3 lg:w-full xl:w-full"
                    role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ Session::get('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="document.getElementById('error-alert').style.display = 'none';"><svg
                            class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 5.652a.5.5 0 0 0-.707 0L10 9.293 6.354 5.647a.5.5 0 0 0-.707.707L9.293 10l-3.646 3.646a.5.5 0 1 0 .707.707L10 10.707l3.646 3.646a.5.5 0 0 0 .707-.707L10.707 10l3.646-3.646a.5.5 0 0 0 0-.707z" />
                        </svg>
                    </span>
                </div>
            @endif
        @endif
        <div class="my-4 flex justify-between items-center">
            <form action="/admin/manage-speciesrecords" class="flex items-center">
                <input class="px-2 py-2 bg-gray-100 focus:outline-green-600 text-black" type="text" placeholder="Search"
                    value="{{ $searchTerm }}" name="searchTerm">
                <button type="submit" class="bg-gray-600 hover:bg-gray-800 text-white px-5 py-2">Search</button>
            </form>
            <div>
                <a class="primary-btn md:text-2x1" href="/admin/manage-speciesrecords/add">Add</a>
            </div>
        </div>
        <div>
            @if ($searchTerm)
                <h2>Search: {{ $searchTerm }}</h2>
            @endif
        </div>
        <div>
            {{ $speciesrecord->links('vendor.pagination.tailwind') }}
            <div class="overflow-x-auto mt-5 relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-50 uppercase bg-green-600">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Species ID
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Scientific Name
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Common Name
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Conservation Status
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
                        @if ($searchTerm)
                            @if (count($speciesrecord) == 0)
                                <tr>
                                    <td colspan="6" class="text-center py-6">
                                        <h3>No Species Records found</h3>
                                    </td>
                                </tr>
                            @endif
                        @endif
                        @foreach ($speciesrecord as $species_record)
                            <tr class="bg-white border-b">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $species_record->mangrove_id }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ $species_record->scientific_name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $species_record->common_name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $species_record->conserv_status }}
                                </td>
                                <td
                                    class="py-4 px-6 {{ $species_record->status == 'Active' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $species_record->status }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href={{ '/admin/manage-speciesrecords/view?species_id=' . $species_record->species_id }}
                                        class="font-medium text-blue-600 hover:underline">View</a>
                                    <span>|</span>
                                    <a href={{ '/admin/manage-speciesrecords/update?species_id=' . $species_record->species_id }}
                                        class="font-medium
                                text-blue-600
                                hover:underline">Edit</a>
                                    <span>|</span>
                                    <button class="open-archive" data-record-id="{{ $species_record->species_id }}">
                                        <a href="#"
                                            class="font-medium
                                        text-blue-600
                                        hover:underline">{{ $species_record->status == 'Active' ? 'Archive' : 'Active' }}</a>
                                    </button>
                                    <span>|</span>
                                    <button class="open-delete" data-record-id="{{ $species_record->species_id }}">
                                        <a href="#"
                                            class="font-medium text-blue-600 hover:underline">Delete</a></button>
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
                        activate/archive this
                        species record?</p>
                </div>
                <div class="flex flex-row justify-center sm:justify-end">
                    <form action="/admin/archive-species-record" id="archive-form">
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
            <div id="delete"
                class="fixed hidden z-50 top-1/4 left-1/2 -translate-x-1/2 sm:-translate-x-1/3 -translate-y-1/2 w-11/12 sm:w-1/2 md:w-1/3 bg-white rounded-md px-7 py-7 space-y-5 drop-shadow-lg">
                <h1 class="text-2xl font-semibold">Delete Record</h1>
                <div class="py-5 border-t border-b border-gray-300">
                    <p class="text-justify text-lg"><span class="font-bold text-red-900">Warning!</span> Are you sure you
                        want to delete this record?</p>
                </div>
                <div class="flex flex-row justify-center sm:justify-end">
                    <form action="/admin/delete-record" id="delete-form">
                        <input type="text" hidden name='record_id' id="record_id">
                        <button id="delete-yes" type="submit"
                            class="px-5 py-2 primary-btn w-20 text-white cursor-pointer rounded-md sm:mb-0 sm:ml-4">
                            Yes</button>
                    </form>
                    <button id="delete-close"
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
    <script>
        var openDeleteButtons = document.querySelectorAll('.open-delete');
        var deleteDialog = document.getElementById('delete');
        var deleteCloseButton = document.getElementById('delete-close');
        var deleteYesButton = document.getElementById('delete-yes');
        var deleteOverlay = document.getElementById('overlay');
        var deleteRecordId = null;
        var recordIdInput = document.getElementById('record_id');

        openDeleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                deleteRecordId = this.getAttribute('data-record-id');
                recordIdInput.value = deleteRecordId;
                deleteDialog.classList.remove('hidden');
                deleteOverlay.classList.remove('hidden');
            });
        });

        deleteCloseButton.addEventListener('click', function() {
            deleteDialog.classList.add('hidden');
            deleteOverlay.classList.add('hidden');
        });
    </script>
@stop