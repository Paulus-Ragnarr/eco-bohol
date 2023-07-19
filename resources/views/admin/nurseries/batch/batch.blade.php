@extends('layouts.admin')


@section('title', 'Eco Bohol - Nursery Batch Record')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucwords(str_replace('-', ' ', $action)) }}</h1>
            <a href={{ '/admin/manage-nurseries/view?nursery_id=' . $nursery->nursery_id }}
                class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form
            action={{ '/admin/manage-nurseries/' . $action }}{{ $nursery ? '?nursery_id=' . $nursery->nursery_id . ('&batch_id=' . ($batch ? $batch->batch_id : '')) : '' }}
            method="POST">
            @if ($action == 'update-batch')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Species</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <select class="common-input" type="text" name="species_id" required>
                            <option value="">Select a Species</option>
                            @foreach ($speciesrecord as $mangrove)
                                <option value="{{ $mangrove->species_id }}"
                                    {{ $batch ? ($batch->species_id == $mangrove->species_id ? 'selected' : null) : '' }}>
                                    {{ $mangrove->common_name }}</option>
                            @endforeach
                        </select>
                        @error('species_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row lg:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Propagules Potted</h6>
                    </div>
                    <div class="flex flex-col md:flex-row md:ml-10">
                        <div class="flex flex-col mb-2 md:mr-10">
                            <label for="no_potted">Intial No. Potted</label>
                            <input class="common-input" type="number" name="no_potted"
                                value="{{ old('no_potted', $batch ? $batch->no_potted : null) }}" required>
                            @error('no_potted')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col mb-2 md:mr-10 {{ $action == 'update-batch' ? 'visible' : 'hidden' }} ">
                            <label for="current_no_potted">Current No. Potted</label>
                            <input class="common-input" type="number" name="current_no_potted"
                                value="{{ old('current_no_potted', $batch ? $batch->current_no_potted : null) }}">
                            @error('current_no_potted')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="date_potted">Date Potted</label>
                            <input class="common-input" type="date" name="date_potted"
                                value='{{ old('date_potted', $batch ? $batch->date_potted : null) }}' required>
                            @error('date_potted')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="md:w-1/6 w-full mb-2 font-bold">
                        <h6>Remarks</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col w-full mt-2 md:w-1/2">
                        <textarea class="common-input h-60" type="date" name="remarks">{{ old('remarks', $batch ? $batch->remarks : null) }}</textarea>
                        @error('remarks')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href={{ '/admin/manage-nurseries/view?nursery_id=' . $nursery->nursery_id }}
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Cancel</a>
            </div>
        </form>
    </div>
@stop
