@extends('layouts.admin')


@section('title', 'Eco Bohol - Officer Monitoring Record')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-20 overflow-y-auto space-y-2">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="md:text-2xl text-lg">Officer Monitoring Record</h1>
            <a href={{ '/admin/manage-plantations/view?plantation_id=' . $plantation->plantation_id }}
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="grid grid=cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4 pt-5 pb-5">
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Date Monitored: </span>
                <span class="font-bold">{{ $record->date_monitored }}</span>
            </div>
            {{-- <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Latitude </span>
                <span class="font-bold">{{ $record->latitude }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Longitude: </span>
                <span class="font-bold">{{ $record->longitude }}</span>
            </div> --}}
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Address: </span>
                <span class="font-bold">{{ $record->address }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Area(ha): </span>
                <span class="font-bold">{{ $record->area }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Spacing: </span>
                <span class="font-bold">{{ $record->spacing }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>No. Plots: </span>
                <span class="font-bold">{{ $record->no_plots }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Total Planted: </span>
                <span class="font-bold">{{ $record->total_planted }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>No. Survived: </span>
                <span class="font-bold">{{ $record->no_survived }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>No. Dead: </span>
                <span class="font-bold">{{ $record->no_dead }}</span>
            </div>
            <div
                class="p-2 rounded-xl  {{ $record->survival_rate > 85 ? 'bg-green-300 hover:bg-green-200' : 'bg-red-300 hover:bg-red-200' }}">
                <span>Survival Rate: </span>
                <span class="font-bold">{{ $record->survival_rate }}%</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Evaluator: </span>
                <span class="font-bold">
                    @foreach ($officer as $officers)
                        @if ($officers->user_id == $record->user_id)
                            {{ $officers->name }}
                        @endif
                    @endforeach
                </span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Attachments: </span>
                <span class="font-bold">
                    @foreach ($record->monitorattachment as $attachment)
                        @if ($attachment->attachmentFor == 'monitor_attachment')
                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                class="text-blue-400
                hover:text-blue-600">{{ $attachment->attachmentFilename }},
                            </a>
                        @endif
                    @endforeach
                </span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Remarks: </span>
                <span class="font-bold">{{ $record->remarks }}</span>
            </div>
        </div>
    </div>


@stop
