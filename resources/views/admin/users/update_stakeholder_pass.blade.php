@extends('layouts.admin')

@section('title', 'Eco Bohol - Edit Stakeholder Password')

@section('content')
<div>
    @if (Session::has('successP'))
    @if (Session::has('successP'))
    <div id="success-alert"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-3 rounded relative sm:w-2/3 lg:w-full xl:w-full"
        role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ Session::get('successP') }}</span>
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
    @elseif(Session::has('error'))
    @if (Session::has('error'))
    <div id="error-alert"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-3 rounded relative sm:w-2/3 lg:w-full xl:w-full"
        role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ Session::get('error') }}</span>
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
    @endif
    <div class="p-8">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-sm md:text-2xl">Edit Stakeholder Password</h1>
            <a href="/admin/manage-stakeholders"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <h2 class="text-2xl font-bold mb-4">Change Password</h2>
        <form
            action="{{ url('/admin/manage-stakeholders/update') }}{{ $registered ? '?user_id=' . $registered->user_id : '' }}"
            method="POST">
            @method('patch')
            @csrf
            <div class="flex flex-col mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="new-password">New Password</label>
                <input class="common-input rounded px-4 py-2 w-1/2" type="password" name="new_password"
                    id="new_password" placeholder="Enter your new password" required>
                @error('new_password')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="confirm-password">Confirm
                    Password</label>
                <input class="common-input rounded px-4 py-2 w-1/2" type="password" name="new_password_confirmation"
                    id="confirmNewPasswordInput" placeholder="Confirm your new password" required>
                @error('new_password_confirmation')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="primary-btn w-24">Save</button>
        </form>
    </div>
</div>
@stop