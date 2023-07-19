@extends('layouts.admin')


@section('title', 'Eco Bohol - Users')

@section('content')
    <div class="common-background flex-1 p-5 h-screen">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Add User</h1>
        </div>
        <form action="/admin/managers/add-manager" method="POST">
            @csrf
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Account</h6>
                    </div>
                    <div class="grid lg:grid-cols-3 md:grid-cols-2">
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="user_email">Email</label>
                            <input class="common-input" type="email" name="user_email" value="{{ old('user_email') }}"
                                required>
                            @error('user_email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="user_password">Password</label>
                            <input class="common-input" type="password" name="user_password" placeholder=""
                                value="{{ old('user_password') }}" required>
                            @error('user_password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Personal Details</h6>
                    </div>
                    <div class="grid lg:grid-cols-3 md:grid-cols-2">
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="first_name">First Name</label>
                            <input class="common-input" type="text" name="first_name" value="{{ old('first_name') }}"
                                required>
                            @error('first_name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="middle_name">Middle Name</label>
                            <input class="common-input" type="text" name="middle_name" placeholder="Optional"
                                value="{{ old('middle_name') }}">
                            @error('middle_name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="last_name">Last Name</label>
                            <input class="common-input" type="text" name="last_name" value="{{ old('last_name') }}"
                                required>
                            @error('last_name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="suffix">Suffix</label>
                            <input class="common-input" type="text" name="suffix" placeholder="Optional"
                                value="{{ old('suffix') }}">
                            @error('suffix')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="user_contact">Contact</label>
                            <input class="common-input" type="text" name="user_contact"
                                value="{{ old('user_contact') }}">
                            @error('user_contact')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>* For Managers Only</h6>
                    </div>
                    <div class="grid md:grid-cols-3">
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="org_name">Organization</label>
                            <input class="common-input" type="text" name="org_name" value="{{ old('org_name') }}"
                                required>
                            @error('org_name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="org_type">Type</label>
                            {{-- <input class="common-input" type="text" name="org_type"> --}}
                            <select class="common-input" type="text" name="org_type" required>
                                <option value="">Select Type</option>
                                <option value="PO" {{ old('org_type') == 'PO' ? 'selected' : '' }}>People's
                                    Organization</option>
                                <option value="BLGU" {{ old('org_type') == 'BLGU' ? 'selected' : '' }}>Barangay Local
                                    Government Unit</option>
                            </select>
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="user_role">User Role</label>
                            <select class="common-input" type="text" name="user_role">
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href='/admin/{{ $location }}'
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Cancel</a>
            </div>
        </form>
    </div>
@stop
