@extends('layouts.admin')

@section('title', 'Eco Bohol - View Information')

@section('content')
    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto space-y-2">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-sm md:text-2xl">{{ ucfirst($action) }} Information</h1>
            <a href="/admin/manage-stakeholders"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-3 pt-5 pb-10">
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Stakeholder ID:</span>
                <span class="font-bold">{{ $registered->user_id }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Stakeholder Name:</span>
                <span class="font-bold">{{ $registered->name }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Email:</span>
                <span class="font-bold">{{ $registered->email }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Contact:</span>
                <span class="font-bold">{{ $registered->user_contact }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Organization Name:</span>
                <span class="font-bold">{{ $registered->stakeholder->org_name }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50 ">
                <span>Status:</span>
                <span
                    class="font-bold {{ $registered->status == 'active' ? 'text-green-600' : 'text-red-600' }}"">{{ ucwords($registered->status) }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Type:</span>
                <span class="font-bold">{{ $registered->stakeholder->stakeholder_type }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Endorsement Letter:</span>
                <br>
                <span class="font-bold flex flex-col">
                    @foreach ($stakeholder->endorsement_letters as $attachment)
                        @if ($attachment->attachmentFor == 'endorsement_letter')
                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                class="underline text-blue-400
                hover:text-blue-600">{{ $attachment->attachmentFilename }}</a>
                        @endif
                    @endforeach
                </span>
            </div>
        </div>
    </div>
@stop
