@extends('layouts.admin')


@section('title', 'Eco Bohol - Users')


@section('content')

@php
$user_roles = ['admin', 'manager', 'officer', 'researcher'];
@endphp

<div class="common-background flex-1 p-5 h-screen">
    <div class="flex sm:flex-col md:flex-row justify-between mb-5 border-b-2 pb-5 bg-white">
        <h1 class="text-2xl">{{ $user_type }}</h1>
        <a class="primary-btn md:ml-4 text-2x1 h-10" href={{ $location=='manage-users' ? '/admin/' . $location . '/add'
            : '/admin/' . $location . '/add-manager' }}>Add</a>
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

    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-4 h-5/6 mt-5">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg col-span-2">
            {{ $users->links('vendor.pagination.tailwind') }}
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-50 uppercase bg-green-600">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            User Role
                        </th>
                        <th scope="col" class="py-3 px-6">
                            {{ $location == "managers" ? 'Organization Name' :
                            'Position'}}
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
                    @foreach ($users as $user)
                    <tr class="bg-white border-b ">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            {{ ucwords($user->name) }}
                        </th>
                        <td class="py-4 px-6">
                            <select class="common-input user_role" type="text" name="user_role" id={{ $user->user_id }}
                                {{$user->user_role == "manager" || $user->user_role == "researcher" || $user->user_role == "admin" || $user->user_role == "officer"  ? 'disabled' : ''}}>
                                @foreach ($user_roles as $user_role)
                                <option value={{ $user_role }} {{ $user->user_role == $user_role ? 'selected' : '' }}>
                                    {{ ucwords($user_role) }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="py-4 px-6">
                            {{ $user->user_role == "manager" ? ($user->manager ? $user->manager->org_name : '') :
                            $user->position}}
                        </td>
                        <td class="py-4 px-6">
                            <p class={{ $user->status == 'active' ? 'text-green-600' : 'text-red-600' }}>
                                {{ ucwords($user->status) }}
                            </p>
                        </td>
                        <td class="py-4 px-6">
                            <a href={{ '/admin/' . $location . '/view?user_id=' . $user->user_id }}
                                class="font-medium text-blue-600 hover:underline">View</a>
                            <span>|</span>
                            <a href="/admin/manage-accounts/update?user_id={{$user->user_id}}"
                                class="font-medium text-blue-600 hover:underline">Update</a>
                            <span>|</span>
                            <button data-record-id="{{ $user->user_id }}" class="toggle-status
                                font-medium text-blue-600 hover:underline">{{ $user->status == 'active' ? 'Deactivate'
                                : 'Activate' }}</button>

                            {{-- <span>|</span>
                            <div class="common-background flex-1 p-5 h-screen">
                                <div class="flex sm:flex-col md:flex-row justify-between mb-5 border-b-2 pb-5 bg-white">
                                    <h1 class="text-2xl">{{ $user_type }}</h1>
                                    <a class="primary-btn md:ml-4 text-2x1" href="/admin/manage-users/add">Add User</a>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-5/6">
                                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg col-span-2">
                                        <table class="w-full text-sm text-left text-gray-500">
                                            <thead class="text-xs text-gray-50 uppercase bg-green-600">
                                                <tr>
                                                    <th scope="col" class="py-3 px-6">
                                                        Name
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        User Role
                                                    </th>
                                                    <th scope="col" class="py-3 px-6">
                                                        Position
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
                                                @foreach ($users as $user)
                                                <tr class="bg-white border-b ">
                                                    <th scope="row"
                                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                        {{ ucwords($user->name) }}
                                                    </th>
                                                    <td class="py-4 px-6">
                                                        <select class="common-input user_role" type="text"
                                                            name="user_role" id={{ $user->user_id }}>
                                                            @foreach ($user_roles as $user_role)
                                                            <option value={{ $user_role }} {{ $user->user_role ==
                                                                $user_role ? 'selected' : '' }}>
                                                                {{ ucwords($user_role) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        {{ $user->position }}
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <p class={{ $user->status == 'active' ? 'text-green-600' :
                                                            'text-red-600' }}>
                                                            {{ ucwords($user->status) }}
                                                        </p>
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <a href={{ '/admin/manage-users/view?user_id=' . $user->user_id
                                                            }}
                                                            class="font-medium text-blue-600 hover:underline">View</a>
                                                        <span>|</span>
                                                        <a href="#"
                                                            class="font-medium text-blue-600 hover:underline">Update</a>
                                                        <span>|</span>
                                                        <a href={{ '/admin/manage-users/toggle-user-status?user_id=' .
                                                            $user->user_id }}
                                                            class="
                                                            font-medium text-blue-600 hover:underline">{{ $user->status
                                                            == 'active' ? 'Deactivate' : 'Activate' }}</a>
                                                        {{-- <span>|</span>
                                                        <a href="#"
                                                            class="font-medium text-blue-600 hover:underline">Remove</a>
                                                        --}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div
                                        class="grid grid-cols-2 md:grid-cols-1 lg:grid-cols-2 gap-1 h-1/2 mt-5 md:mt-0">
                                        @foreach ($count as $role)
                                        <div class="summary-item">
                                            <h3>{{ $role['count(user_role)'] }}</h3>
                                            <h4>{{ ucwords($role['user_role']) }}(s)</h4>
                                        </div>
                                        @endforeach
                                        {{-- <div class="summary-item">
                                            <h3>5</h3>
                                            <h4>Officers</h4>
                                        </div>
                                        <div class="summary-item">
                                            <h3>18</h3>
                                            <h4>Managers</h4>
                                        </div>
                                        <div class="summary-item">
                                            <h3>1</h3>
                                            <h4>Researchers</h4>
                                        </div> --}}
                                    </div>
                                    <div id="overlay"
                                        class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60">
                                    </div>
                                    <div id="activate"
                                        class="fixed hidden z-50 top-1/4 left-1/2 -translate-x-1/2 sm:-translate-x-1/3 -translate-y-1/2 w-11/12 sm:w-1/2 md:w-1/3 bg-white rounded-md px-7 py-7 space-y-5 drop-shadow-lg">
                                        <h1 class="text-2xl font-semibold">Activate/Deactivate User</h1>
                                        <div class="py-5 border-t border-b border-gray-300">
                                            <p class="text-justify text-lg"><span
                                                    class="font-bold text-red-900">Warning!</span> Are you sure you want
                                                to
                                                activate/deactive this user?</p>
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
                                </div>

                                <script>
                                    var openButtons = document.querySelectorAll('.toggle-status');
        var archive = document.getElementById('activate');
        var closeButton = document.getElementById('close');
        var overlay = document.getElementById('overlay');
        var recordId = null;
        var user_id_input = document.getElementById('user_id');
        openButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                recordId = this.getAttribute('data-record-id');
                user_id_input.value = recordId
                archive.classList.remove('hidden');
                overlay.classList.remove('hidden');
            });
        });
        closeButton.addEventListener('click', function() {
            archive.classList.add('hidden');
            overlay.classList.add('hidden');
        });

        var user_role = document.getElementsByClassName('user_role');
        for (var i = 0; i < user_role.length; i++) {
            user_role[i].addEventListener('change', function(event) {
                fetch(
                        `/admin/manage-users/change-user-role?user_id=${event.target.id}&user_role=${event.target.value}`
                    )
                    .then(res => {
                        if (res.status == 200) {
                            alert("User Role Updated Successfully")
                            window.location.reload();
                        }
                    })
            })
        }
                                </script>


                                @stop