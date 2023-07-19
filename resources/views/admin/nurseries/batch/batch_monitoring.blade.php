@extends('layouts.admin')


@section('title', 'Eco Bohol - Nursery Batch Monitoring Record')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucwords(str_replace('-', ' ', $action)) }}</h1>
            <a href={{ '/admin/manage-nurseries/view-batch?batch_id=' . $batch->batch_id . '&nursery_id=' . $nursery->nursery_id }}
                class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form
            action={{ '/admin/manage-nurseries/' . $action }}{{ $nursery
                ? '?nursery_id=' .
                    $nursery->nursery_id .
                    '&batch_id=' .
                    $batch->batch_id .
                    ('&monitor_id=' . ($batch_monitoring ? $batch_monitoring->monitor_id : ''))
                : '' }}
            method="POST">
            @if ($action == 'update-batch-monitoring')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf
            <div class="py-4 border-b">
                <div class="flex items-center">
                    <div class="w-1/6">
                        <h6>Date Monitored</h6>
                    </div>
                    <div class="ml-10 flex flex-col">
                        <input class="common-input" type="date" name="date_monitored"
                            value="{{ old('date_monitored', $batch_monitoring ? $batch_monitoring->date_monitored : null) }}"
                            required>
                        @error('date_monitored')
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
                    <div class="grid grid-cols-4 gap-2">
                        <div class="ml-10 flex flex-col">
                            <label for="initial_no_potted">Initial No. Potted</label>
                            <input class="common-input" type="number" name="initial_no_potted"
                                value="{{ $batch ? $batch->no_potted : null }}" disabled>
                        </div>
                        <div class="ml-10 flex flex-col">
                            <label for="current_no_potted">Current No. Potted</label>
                            <input class="common-input" type="number" name="current_no_potted"
                                {{ $batch_monitoring ? ' value=' . $batch_monitoring->current_no_potted : ' value=' . $batch->current_no_potted }}
                                required>
                            @error('current_no_potted')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ml-10 flex flex-col">
                            <label for="no_survived">No. Survived</label>
                            <input class="common-input" type="number" name="no_survived"
                                {{ $batch_monitoring ? ' value=' . $batch_monitoring->no_survived : null }} required>
                            @error('no_survived')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ml-10 flex flex-col">
                            <label for="no_dead">No. Dead</label>
                            <input class="common-input" type="number" name="no_dead"
                                {{ $batch_monitoring ? ' value=' . $batch_monitoring->no_dead : null }} required>
                            @error('no_dead')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ml-10 flex flex-col">
                            <label for="total_no_dead">Total No. Dead</label>
                            <input class="common-input" type="number" name="total_no_dead"
                                {{ $batch_monitoring ? ' value=' . $batch_monitoring->total_no_dead : null }}>
                            @error('total_no_dead')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="ml-10 flex flex-col">
                            <label for="total_no_dead">Total No. Dead</label>
                            <input class="common-input" type="number" name="total_no_dead"
                                value="{{ $batch_monitoring ? ' value=' . $batch_monitoring->total_no_dead : null }}">
                        </div> --}}
                        <div class="ml-10 flex flex-col">
                            <label for="survival_rate">Survival Rate</label>
                            <input class="common-input" type="text" name="survival_rate"
                                {{ $batch_monitoring ? ' value=' . $batch_monitoring->survival_rate : null }} required>
                            @error('survival_rate')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex items-center">
                    <div class="w-1/6">
                        <h6>Remarks</h6>
                    </div>
                    <div class="ml-10 flex flex-col w-1/2">
                        <textarea class="common-input h-60" type="date" name="remarks">{{ old('remarks', $batch_monitoring ? $batch_monitoring->remarks : null) }}</textarea>
                        @error('remarks')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href={{ '/admin/manage-nurseries/view-batch?batch_id=' . $batch->batch_id . '&nursery_id=' . $nursery->nursery_id }}
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Cancel</a>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        var initial_no_potted = document.getElementsByName('initial_no_potted')[0];
        var current_no_potted = document.getElementsByName('current_no_potted')[0];
        var no_survived = document.getElementsByName('no_survived')[0];
        var no_dead = document.getElementsByName('no_dead')[0];
        var total_no_dead = document.getElementsByName('total_no_dead')[0];
        var survival_rate = document.getElementsByName('survival_rate')[0];

        function update_survival_rate() {
            no_survived.value = current_no_potted.value - no_dead.value;
            total_no_dead.value = initial_no_potted.value - (current_no_potted.value - no_dead.value);
            survival_rate.value = (((initial_no_potted.value - total_no_dead.value) / initial_no_potted.value) * 100)
                .toFixed(2);
        }

        current_no_potted.addEventListener('change', function() {
            update_survival_rate()
        });

        no_dead.addEventListener('change', function() {
            update_survival_rate()
        });

        no_survived.addEventListener('change', function() {
            no_dead.value = current_no_potted.value - no_survived.value;
            total_no_dead.value = initial_no_potted.value - (current_no_potted.value - no_dead.value);
            survival_rate.value = (((initial_no_potted.value - total_no_dead.value) / initial_no_potted.value) *
                    100)
                .toFixed(2);
            // survival_rate.value = (((current_no_potted.value - no_dead.value) / current_no_potted.value) *
            //     100).toFixed(2);
        });
    </script>
@stop
