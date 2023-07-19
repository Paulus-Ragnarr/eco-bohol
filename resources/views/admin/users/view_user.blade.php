@extends('layouts.admin')

@section('title', 'Eco Bohol - View User')


@section('content')
    <div class="common-background flex-1 pt-5 px-5 pb-20 overflow-y-auto space-y-2">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucfirst($action) }} Account Detail</h1>
            <a href="/admin/{{ $location }}"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>

        <div class="mx-auto mt-16 max-w-3xl shadow-md rounded-md">
            <div class="uppercase bg-green-600 rounded-t-md px-4 py-2">
                <h1 class="text-lg text-white  font-bold">User Info</h1>
            </div>
            <div class="p-4">
                <br>
                <br>
                <h2 class="text-xl font-bold text-center">{{ $user->name }}</h2>
                <p class="text-gray-600 text-center">{{ $user->email }}</p>
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
                <div class={{ $user->user_role == 'manager' ? 'hidden' : 'visible' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Position:</span>
                        <span>{{ $user->position }}</span>
                    </div>
                </div>
                <div class={{ $user->user_role == 'manager' ? 'visible' : 'hidden' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Organization Name:</span>
                        <span>
                            @foreach ($managers as $manager)
                                @if ($manager->manager_id == $user->user_id)
                                    {{ $manager->org_name }}
                                @endif
                            @endforeach
                        </span>
                    </div>
                </div>
                {{-- <div class={{ $user->user_role == 'manager' ? 'hidden' : 'visible' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Office:</span>
                        <span>{{ $user->office }}</span>
                    </div>
                </div> --}}
                <div class={{ $user->user_role == 'manager' ? 'visible' : 'hidden' }}>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold">Organization Type:</span>
                        <span>
                            @foreach ($managers as $manager)
                                @if ($manager->manager_id == $user->user_id)
                                    {{ $manager->org_type }}
                                @endif
                            @endforeach
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
