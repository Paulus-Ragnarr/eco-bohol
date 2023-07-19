@extends('layouts.admin')

@section('title', 'EcoBohol - Users')

@section('content')

    <div class="common-background flex-1 p-5">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Stakeholders</h1>
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
        <div class="grid grid-rows-2 grid-flow-row gap-4">
            <div>
                <div class="flex justify-between ml-1 pt-4 pb-2">
                    <h2 class="text-2x1">Registered Stakeholders</h2>
                </div>
                {{ $userstakeholder->links('vendor.pagination.tailwind') }}
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="table-auto w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-50 uppercase bg-green-600">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Stakeholder ID
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Type
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Organization Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Contact Number
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
                            @foreach ($userstakeholder as $registered)
                                <tr class="bg-white border-b ">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $registered->user_id }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ ucwords($registered->name) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ ucwords($registered->stakeholder->stakeholder_type) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $registered->stakeholder->org_name }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $registered->user_contact }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class={{ $registered->status == 'active' ? 'text-green-600' : 'text-red-600' }}>
                                            {{ ucwords($registered->status) }}
                                        </p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href={{ '/admin/manage-stakeholders/view-registered?user_id=' . $registered->user_id }}
                                            class="font-medium 
                                     text-blue-600 
                                     hover:underline">View</a>
                                        <span>|</span>
                                        <a href={{ '/admin/manage-stakeholders/update?user_id=' . $registered->user_id }}
                                            class="font-medium
                                     text-blue-600
                                     hover:underline">Update</a>
                                        <span>|</span>
                                        <button
                                            class="disable-user toggle-status
                                        font-medium text-blue-600 hover:underline"
                                            data-record-id="{{ $registered->user_id }}">
                                            {{ $registered->status == 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="overlay" class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60"></div>
            <div id="activate"
                class="fixed hidden z-50 top-1/4 left-1/2 -translate-x-1/2 sm:-translate-x-1/3 -translate-y-1/2 w-11/12 sm:w-1/2 md:w-1/3 bg-white rounded-md px-7 py-7 space-y-5 drop-shadow-lg">
                <h1 class="text-2xl font-semibold">Activate/Deactivate User</h1>
                <div class="py-5 border-t border-b border-gray-300">
                    <p class="text-justify text-lg"><span class="font-bold text-red-900">Warning!</span> Are you sure you
                        want
                        to
                        activate/deactive this user?</p>
                </div>
                <div class="flex flex-row justify-center sm:justify-end">
                    <form action="/admin/disable-manage-stakeholders" id="disable-form">
                        <input type="text" hidden name='user_id' id="user_id">
                        <button id="yes" type="submit"
                            class="px-5 py-2 primary-btn w-20 text-white cursor-pointer rounded-md sm:mb-0 sm:ml-4">
                            Yes</button>
                    </form>
                    <button id="close"
                        class="md:ml-4 px-5 py-2 w-20 bg-gray-400 hover:bg-gray-600 text-white cursor-pointer rounded-md">
                        No</button>
                </div>
            </div>
            <div>
                <div class="flex justify-between ml-1 mt-3 pt-4 pb-2">
                    <h2 class="text-2x1">Pending Registration</h2>
                </div>
                {{ $pending->links('vendor.pagination.tailwind') }}
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="table-auto w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-50 uppercase bg-green-600">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Email
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Type
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Organzation Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Contact Number
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
                            @foreach ($pending as $register)
                                <tr class="bg-white border-b ">
                                    <td class="py-4 px-6">
                                        {{ ucfirst($register->name) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $register->email }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $register->stakeholder->stakeholder_type }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $register->stakeholder->org_name }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $register->user_contact }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class={{ $register->status == 'Active' ? 'text-green-600' : 'text-red-600' }}>
                                            {{ ucwords($register->status) }}
                                        </p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href={{ '/admin/manage-stakeholders/view?user_id=' . $register->user_id }}
                                            class="font-medium 
                                                text-blue-600 
                                                hover:underline">View</a>
                                        <span>|</span>
                                        <a href="{{ route('approve.stakeholder', ['user_id' => $register]) }}"
                                            class="font-medium text-blue-600 hover:underline">Accept</a>
                                        <span>|</span>
                                        <a href="{{ route('delete.user', ['user_id' => $register]) }}"
                                            class="font-medium text-blue-600 hover:underline">Reject</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        var openButtons = document.querySelectorAll('.disable-user');
        var disable = document.getElementById('activate');
        var closeButton = document.getElementById('close');
        var yesButton = document.getElementById('yes');
        var overlay = document.getElementById('overlay');
        var recordId = null;
        var user_id_input = document.getElementById('user_id');

        openButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                recordId = this.getAttribute('data-record-id');
                user_id_input.value = recordId
                disable.classList.remove('hidden');
                overlay.classList.remove('hidden');
            });
        });

        closeButton.addEventListener('click', function() {
            disable.classList.add('hidden');
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
    {{-- <div id="overlay" class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60"></div>
        <div id="activate"
            class="fixed hidden z-50 top-1/4 left-1/2 -translate-x-1/2 sm:-translate-x-1/3 -translate-y-1/2 w-11/12 sm:w-1/2 md:w-1/3 bg-white rounded-md px-7 py-7 space-y-5 drop-shadow-lg">
            <h1 class="text-2xl font-semibold">Approve Stakeholder?</h1>
            <div class="py-5 border-t border-b border-gray-300">
                <p class="text-justify text-lg"><span class="font-bold text-red-900">Confirm</span> Are you sure you want
                    to approve this stakeholder?</p>
            </div>
            <div class="flex flex-row justify-center sm:justify-end">
                <form action="/admin/manage-users/toggle-user-status" id="archive-form">
                    <input type="text" hidden name='user_id' id="user_id">
                    <button id="yes" type="submit"
                        class="px-5 py-2 primary-btn w-20 text-white cursor-pointer rounded-md sm:mb-0 sm:ml-4">
                        Yes</button>
                </form>
                <button id="close"
                    class="md:ml-4 px-5 py-2 w-20 bg-gray-400 hover:bg-gray-600 text-white cursor-pointer rounded-md">
                    No</button>
            </div>
        </div>
    </div> --}}
@stop
