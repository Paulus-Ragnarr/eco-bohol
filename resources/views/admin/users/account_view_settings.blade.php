@extends('layouts.admin')

@section('title', 'Eco Bohol - Account Settings')

@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-20 overflow-y-auto space-y-2">
        <div class="flex justify-start md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Account Settings</h1>
        </div>

        <div class="mx-auto mt-16 max-w-4xl shadow-md rounded-md">
            <div class="uppercase bg-green-600 rounded-t-md px-4 py-2">
                <h1 class="text-lg text-white  font-bold">User Info</h1>
            </div>
            <div class="p-4">
                <br>
                <br>
                <div class="flex flex-col items-center">
                    <h2 class="text-xl font-bold text-center">{{ $user->name }}</h2>
                    <p class="text-gray-600 text-center">{{ $user->email }}</p>
                    <br>
                    @if ($user->user_role == 'admin' || $user->user_role == 'officer' || $user->user_role == 'researcher')
                        <a class="primary-btn text-2x1 h-10"
                            href={{ '/admin/account-settings/edit-user-account?user_id=' . $user->user_id }}>Edit
                            Account</a>
                    @endif
                    @if ($user->user_role == 'manager')
                        <a class="primary-btn text-2x1 h-10"
                            href={{ '/admin/account-settings/edit-manager-account?user_id=' . $user->user_id }}>Edit
                            Account</a>
                    @endif
                    @if ($user->user_role == 'stakeholder')
                        <a class="primary-btn text-2x1 h-10"
                            href={{ '/admin/account-settings/edit-stakeholder-account?user_id=' . $user->user_id }}>Edit
                            Account</a>
                    @endif
                </div>
                <hr class="my-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold">User ID:</span>
                    <span>{{ $user->user_id }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold">Contact No:</span>
                    <span>{{ $user->user_contact }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold">User Role:</span>
                    <span>{{ ucwords($user->user_role) }}</span>
                </div>
                <div class={{ $user->user_role == 'manager' || $user->user_role == 'stakeholder' ? 'hidden' : 'visible' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Position:</span>
                        <span>{{ $user->position }}</span>
                    </div>
                </div>
                <div class={{ $user->user_role == 'manager' || $user->user_role == 'stakeholder' ? 'visible' : 'hidden' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Organization Name:</span>
                        <span>
                            {{ $user->user_role == 'manager' ? ($user->manager ? $user->manager->org_name : '') : ($user->stakeholder ? $user->stakeholder->org_name : '') }}
                        </span>
                    </div>
                </div>
                {{-- <div class={{ $user->user_role == 'manager' || $user->user_role == 'stakeholder' ? 'hidden' : 'visible' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Office:</span>
                        <span>{{ $user->office }}</span>
                    </div>
                </div> --}}
                <div class={{ $user->user_role == 'manager' || $user->user_role == 'stakeholder' ? 'visible' : 'hidden' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Organization Type:</span>
                        <span>
                            {{ $user->user_role == 'manager' ? ($user->manager ? $user->manager->org_type : '') : ($user->stakeholder ? $user->stakeholder->stakeholder_type : '') }}
                        </span>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold">User Status:</span>
                    <span
                        class={{ $user->status == 'active' ? 'text-green-600' : 'text-red-600' }}>{{ ucwords($user->status) }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold">Account Created:</span>
                    <span>{{ $user->created_at }}</span>
                </div>
            </div>
        </div>

    </div>

@stop
