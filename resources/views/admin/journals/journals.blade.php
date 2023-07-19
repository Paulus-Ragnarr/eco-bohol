@extends('layouts.admin')


@section('title', 'Eco Bohol - Journals')


@section('content')

    <div class="common-background flex-1 p-5">
        <div class="flex flex-col md:flex-row md:justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Journals</h1>
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
        <div class="my-4 md:w-auto flex justify-between w-full items-center">
            <form action="/admin/manage-journals" class="flex items-center">
                <input class="px-2 py-2 pr-10 bg-gray-100 rounded border-1 focus:outline-green-600 text-black"
                    type="text" placeholder="Search" value="{{ $searchTerm }}" name="searchTerm">
                <button class="bg-gray-600 hover:bg-gray-800 text-white px-5 py-2">Search</button>
            </form>
            <div>
                <a class="primary-btn md:ml-4" href="/admin/manage-journals/add">Add</a>
            </div>
        </div>
        <div class="px-2">
            @if ($searchTerm)
                <h2>Search: {{ $searchTerm }}</h2>
            @endif
        </div>
        <div class="px-1">
            <div class="bg-gray-100 p-8 rounded-lg">
                @if ($searchTerm)
                    @if (count($journals) == 0)
                        <div>
                            <h3 class="text-center">No Journal Records found</h3>
                        </div>
                    @endif
                @endif
                <div class="grid md:grid-cols-4 gap-4 ">
                    @foreach ($journals as $journal)
                        <div class="overflow-hidden bg-white border rounded-lg shadow-lg">
                            <img src="/storage/{{ $journal->journal_images[0]->image }}" alt="Image"
                                class="h-48 w-full object-cover">
                            <div class="p-5 text-center text-lg font-bold">{{ $journal->title }}</div>
                            <div class="mt-2 px-2 text-center">{{ $journal->author }}</div>
                            <div class="mt-2 px-2 text-center">{{ $journal->publisher }}</div>
                            <div
                                class="mt-2 text-center {{ $journal->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($journal->status) }}
                            </div>
                            <div class="text-center p-4">
                                <a href="/admin/manage-journals/view?resjournal_id={{ $journal->resjournal_id }}"
                                    class="mt-3 font-medium text-blue-600 hover:underline">View</a>
                                <span>|</span>
                                <a href="/admin/manage-journals/update?resjournal_id={{ $journal->resjournal_id }}"
                                    class="mt-3 font-medium text-blue-600 hover:underline">Edit</a>
                                <span>|</span>
                                <button class="open-archive" data-record-id="{{ $journal->resjournal_id }}">
                                    <a href="#" class="font-medium text-blue-600 hover:underline">{{ $journal->status == 'Active' ? 'Archive' : 'Active' }}</a>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="overlay" class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60"></div>
        <div id="archive"
            class="fixed hidden z-50 top-1/4 left-1/2 -translate-x-1/2 sm:-translate-x-1/3 -translate-y-1/2 w-11/12 sm:w-1/2 md:w-1/3 bg-white rounded-md px-7 py-7 space-y-5 drop-shadow-lg">
            <h1 class="text-2xl font-semibold">Archive Record</h1>
            <div class="py-5 border-t border-b border-gray-300">
                <p class="text-justify text-lg"><span class="font-bold text-red-900">Warning!</span> Do you want to
                    archive this journal?</p>
            </div>
            <div class="flex flex-row justify-center sm:justify-end">
                <form action="/admin/archive-manage-journals" id="archive-form">
                    <input type="text" hidden name='resjournal_id' id="resjournal_id">
                    <button id="yes" type="submit"
                        class="px-5 py-2 primary-btn w-20 text-white cursor-pointer rounded-md sm:mb-0 sm:ml-4">
                        Yes</button>
                </form>
                <button id="close"
                    class="md:ml-4 px-5 py-2 w-20 bg-gray-400 hover:bg-gray-600 text-white cursor-pointer rounded-md">
                    No</button>
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
        var resjournal_id_input = document.getElementById('resjournal_id');

        openButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                recordId = this.getAttribute('data-record-id');
                resjournal_id_input.value = recordId
                archive.classList.remove('hidden');
                overlay.classList.remove('hidden');
            });
        });

        closeButton.addEventListener('click', function() {
            archive.classList.add('hidden');
            overlay.classList.add('hidden');
        });

        // yesButton.addEventListener('click', function() {
        //     fetch().then((res) => {
        //         if (res.status == 200) {
        //             window.location.reload();
        //         }
        //     })
        // })
    </script>
@stop
