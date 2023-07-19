@extends('layouts.admin')

@section('title', 'Eco Bohol - Add Purchased or Planted')

@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucwords(str_replace('-', ' ', $action)) }}</h1>
            <a href={{ '/admin/manage-nurseries/view-batch?batch_id=' . $batch->batch_id . '&nursery_id=' . $nursery->nursery_id }}
                class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>

        <form
            action={{ '/admin/manage-nurseries/' . $action }}{{ $nursery ? '?nursery_id=' . $nursery->nursery_id . ('&batch_id=' . ($batch ? $batch->batch_id : '')) . ('&acquire_id=' . ($purchase ? $purchase->acquire_id : '')) : '' }}
            method="POST">
            @if ($action == 'update-purchased-planted')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf

            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Batch Details</h6>
                    </div>
                    <div class="md:ml-2 flex flex-col md:flex-row">
                        <div class="flex flex-col mb-2 md:mb-0">
                            <label for="species">Species Potted</label>
                            <input class="common-input" type="text" name="species"
                                value='{{ $batch->species_record->common_name }}' disabled>
                        </div>
                        <div class="md:ml-10 flex flex-col">
                            <label for="current_potted">Current Potted</label>
                            <input class="common-input" type="number" name="current_no_potted" id="current_no   _potted"
                                {{ ' value=' . $batch->current_no_potted }} readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Purchased or Planted Details</h6>
                    </div>
                    <div class="md:ml-2 flex flex-col md:flex-row">
                        <div class="flex flex-col mb-2 md:mb-0">
                            <label for="date_acquired">Date Acquired</label>
                            <input class="common-input" name="date_acquired" type="date"
                                value="{{ old('date_acquired', $purchase ? $purchase->date_acquired : null) }}" required>
                            @error('date_acquired')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="md:ml-10 flex flex-col md:flex-row">
                        <div class="flex flex-col mb-2 md:mb-0">
                            <label for="taken_values">Value</label>
                            <input class="common-input" name="taken_values" type="number" min="0"
                                value="{{ old('taken_values', $purchase ? $purchase->no_acquired : null) }}" required>
                            @error('taken_values')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="md:ml-10 flex flex-col md:flex-row">
                        <div class="flex flex-col mb-2 md:mb-0">
                            <label for="type">Type</label>
                            <select class="common-input" name="type" id="type">
                                <option value="Purchased"
                                    {{ old('type') == 'Purchased' || ($purchase && $purchase->type == 'Purchased') ? 'selected' : '' }}>
                                    Purchased</option>
                                <option value="Planted"
                                    {{ old('type') == 'Planted' || ($purchase && $purchase->type == 'Planted') ? 'selected' : '' }}>
                                    Planted</option>
                            </select>
                            @error('type')
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
                    <div class="md:ml-2 flex flex-col w-full mt-2 md:w-5/12">
                        <textarea class="common-input h-60" type="date" name="remarks" required>{{ old('remarks', $purchase ? $purchase->remarks : null) }}</textarea>
                        @error('remarks')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
            </div>
        </form>
    </div>
@stop
