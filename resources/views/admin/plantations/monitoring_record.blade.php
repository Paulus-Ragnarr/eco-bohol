@extends('layouts.admin')


@section('title', 'Eco Bohol - Plantation Record')


@section('content')

    <div class="common-background flex-1 h-screen pt-5 px-5 pb-40 overflow-y-auto space-y-2">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucwords(str_replace('-', ' ', $action)) }}</h1>
            <a href={{ '/admin/manage-plantations/view?plantation_id=' . $plantation->plantation_id }}
                class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form action={{ '/admin/manage-plantations/' . $action }}{{ $record ? '?monitor_id=' . $record->monitor_id : '' }}
            method="POST">
            @if ($action == 'update-monitoring-record')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf
            <input type="hidden" name="plantation_id" value={{ $plantation->plantation_id }} />
            <input type="hidden" name="manager_id" value={{ $plantation->manager_id }} />
            <div class="py-4 border-b">
                <div class="flex items-center">
                    <div class="w-1/6">
                        <h6>Date Monitored</h6>
                    </div>
                    <div class="ml-10 flex flex-col">
                        {{-- <label for="date_started">Date Started</label> --}}
                        <input class="common-input" type="date" name="date_monitored"
                            value='{{ old('date_monitored', $record ? $record->date_monitored : null) }}' required>
                        @error('date_monitored')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex items-center">
                    <div class="w-1/6">
                        <h6>Area Monitored (sq. m.)</h6>
                    </div>
                    <div class="ml-10 flex flex-col">
                        {{-- <label for="date_started">Date Started</label> --}}
                        <input class="common-input" type="number" name="area" min="1"
                            value='{{ old('area', $record ? $record->area : null) }}' required>
                        @error('area')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex items-center">
                    <div class="w-1/6">
                        <h6>Plants</h6>
                    </div>
                    <div class="ml-10 flex flex-col">
                        <label for="no_survived">No. Survived</label>
                        <input class="common-input" type="number" name="no_survived" min="0"
                            value='{{ old('no_survived', $record ? $record->no_survived : null) }}' required>
                        @error('no_survived')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ml-10 flex flex-col">
                        <label for="no_dead">No. Dead</label>
                        <input class="common-input" type="number" name="no_dead" min="0"
                            value='{{ old('no_dead', $record ? $record->no_dead : null) }}' required>
                        @error('no_dead')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ml-10 flex flex-col">
                        <label for="no_replanted">No. Replanted</label>
                        <input class="common-input" type="number" name="no_replanted" min="0"
                            value='{{ old('no_replanted', $record ? $record->no_replanted : null) }}' required>
                        @error('no_replanted')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex items-center">
                    <div class="w-1/6">
                        <h6>Remarks</h6>
                    </div>
                    <div class="ml-10 flex flex-col w-1/2">
                        <textarea class="common-input h-60" name="remarks">{{ old('remarks', $record ? $record->remarks : null) }}</textarea>
                        @error('remarks')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href={{ ' /admin/manage-plantations/view?plantation_id=' . $plantation->plantation_id }}
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center
                flex">Cancel</a>
            </div>
        </form>
    </div>


@stop
