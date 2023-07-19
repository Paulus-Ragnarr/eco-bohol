@extends('layouts.admin')

@section('title', 'Eco Bohol - Officer Monitoring Record')

@section('content')

    <div class="common-background flex-1 h-screen pt-5 px-5 pb-40 overflow-y-auto space-y-2">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucwords(str_replace('-', ' ', $action)) }}</h1>
            <button class=" w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex"
                onclick="history.back()">Back
            </button>
        </div>

        <form action={{ '/admin/manage-plantations/' . $action }}{{ $record ? '?monitor_id=' . $record->monitor_id : '' }}
            method="POST" enctype="multipart/form-data">
            @if ($action == 'update-officer-monitoring-record')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf

            <input type="hidden" name="plantation_id" value={{ $plantation->plantation_id }}>
            <input type="hidden" name="user_id" value{{ $user->user_id }}>
            <div class="py-4 border-b">
                <div class="flex items-center">
                    <div class="w-1/6">
                        <h6>Date Monitored</h6>
                    </div>
                    <div class="ml-10 flex flex-col">
                        {{-- <label for="date_started">Date Started</label> --}}
                        <input class="common-input" type="date" name="date_monitored"
                            value='{{ old('date_monitored', $record ? $record->date_monitored : null) }}'
                            {{-- {{ $record
                                ? '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        value=' .
                                    $record->date_monitored .
                                    ' disabled'
                                : null }} --}} required>
                        @error('date_monitored')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="py-4 border-b">
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div class="w-1/6">
                        <h6>Monitoring Location</h6>
                    </div>
                    <div class="flex flex-col md:flex-row">
                        {{-- <div class="lg:ml-10 flex flex-col">
                            <label for="latitude">Latitude</label>
                            <input class="common-input lg:w-80" type="text" name="latitude"
                                value='{{ old('latitude', $record ? $record->latitude : null) }}' required>
                            @error('latitude')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:ml-10 flex flex-col">
                            <label for="longitude">Longitude</label>
                            <input class="common-input lg:w-80" type="text" name="longitude"
                                value='{{ old('longitude', $record ? $record->longitude : null) }}' required>
                            @error('longitude')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="lg:ml-10 flex flex-col">
                            <label for="address">Address</label>
                            <input class="common-input lg:w-80" type="text" name="address"
                                value='{{ old('address', $record ? $record->address : null) }}' required>
                            @error('address')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-4 border-b">
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div class="w-1/6">
                        <h6>Monitoring Details</h6>
                    </div>
                    <div class="grid grid-rows lg:grid-cols-5 gap-y-3">
                        <div class="lg:ml-10 flex flex-col">
                            <label for="area">Area(ha)</label>
                            <input class="common-input" type="number" name="area" min="1"
                                value='{{ old('area', $record ? $record->area : null) }}' required>
                            @error('area')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:ml-10 flex flex-col">
                            <label for="spacing">Spacing</label>
                            <input class="common-input" type="text" name="spacing"
                                value='{{ old('spacing', $record ? $record->spacing : null) }}' required>
                            @error('spacing')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:ml-10 flex flex-col">
                            <label for="no_plots">No. Plots</label>
                            <input class="common-input" type="number" name="no_plots" min="1"
                                value='{{ old('no_plots', $record ? $record->no_plots : null) }}' required>
                            @error('no_plots')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:ml-10 flex flex-col">
                            <label for="total_planted">Total Planted(Monitoring Area)</label>
                            <input class="common-input" type="number" name="total_planted" min="1" max="10000"
                                value='{{ old('total_planted', $record ? $record->total_planted : null) }}' required>
                            @error('total_planted')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:ml-10 flex flex-col">
                            <label for="no_survived">No. Survived</label>
                            <input class="common-input" type="number" name="no_survived" min="0"
                                value='{{ old('no_survived', $record ? $record->no_survived : null) }}' required>
                            @error('no_survived')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:ml-10 flex flex-col">
                            <label for="no_dead">No. Dead</label>
                            <input class="common-input" type="number" name="no_dead" id="no_dead" min="0"
                                value='{{ old('no_dead', $record ? $record->no_dead : null) }}' required>
                            @error('no_dead')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:ml-10 flex flex-col">
                            <label for="survival_rate">Survival Rate</label>
                            <input class="common-input" type="text" name="survival_rate"
                                value='{{ old('survival_rate', $record ? $record->survival_rate : null) }}' required>
                            @error('survival_rate')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- @if ($action == 'update-officer-monitoring-record')
                            <div class="lg:ml-10 flex flex-col">
                                <label for="current_planted">Current No. Planted</label>
                                <input class="common-input" type="number" name="current_planted" id="current_planted"
                                    min="1"
                                    value='{{ old('current_planted', $record ? $record->current_planted : null) }}'
                                    required>
                            </div>
                            <div class="lg:ml-10 flex flex-col">
                                <input class="common-input" type="number" name="newcurrent_planted"
                                    id="newcurrent_planted" hidden
                                    value='{{ $record ? $record->current_planted : null }}' required>
                            </div>
                            <div class="lg:ml-10 flex flex-col">
                                <input class="common-input" hidden type="number" name="old_dead" id="old_dead"
                                    value='{{ $record ? $record->no_dead : null }}' required>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div class="w-1/6">
                        <h6>Tally Sheet Attachment</h6>
                    </div>
                    <div class="lg:ml-10 flex flex-col">
                        <label for="attachment">Physical Performance Validation Tally Sheet</label>
                        <input class="common-input lg:w-80" type="file" name="attachment[]">
                        @error('attachment')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($record)
                        <div class="md:ml-10 mt-5 flex">
                            <span class="flex-initial p-3 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Attachments: </span>
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
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col lg:flex-row lg:items-center">
                    <div class="w-1/6">
                        <h6>Remarks</h6>
                    </div>
                    <div class="lg:ml-10 flex flex-col lg:w-1/2">
                        <textarea class="common-input lg:h-52" name="remarks">{{ old('remarks', $record ? $record->remarks : null) }}</textarea>
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

    {{-- <script>
        const noDeadInput = document.getElementById('no_dead');
        const currentPlantedInput = document.getElementById('current_planted');

        noDeadInput.addEventListener('focus', () => {
            currentPlantedInput.classList.add('border-red-500');
        });

        noDeadInput.addEventListener('blur', () => {
            currentPlantedInput.classList.remove('focus:border-red-500');
        });
    </script> --}}

    <script type="text/javascript">
        var current_planted = document.getElementsByName('current_planted')[0];
        var newcurrent_planted = document.getElementsByName('newcurrent_planted')[0];
        var old_dead = document.getElementsByName('old_dead')[0];
        var total_planted = document.getElementsByName('total_planted')[0];
        var no_survived = document.getElementsByName('no_survived')[0];
        var no_dead = document.getElementsByName('no_dead')[0];
        var survival_rate = document.getElementsByName('survival_rate')[0];


        function update_survival_rate() {
            no_survived.value = total_planted.value - no_dead.value;
            survival_rate.value = (((total_planted.value - no_dead.value) / total_planted.value) * 100).toFixed(2);
        }
        total_planted.addEventListener('change', function() {
            update_survival_rate()
        })
        no_dead.addEventListener('change', function() {
            update_survival_rate()
            // current_planted.value = ((newcurrent_planted.value + old_dead.value) - no_dead.value);
        })
        no_survived.addEventListener('change', function() {
            no_dead.value = total_planted.value - no_survived.value;
            survival_rate.value = (((total_planted.value - no_dead.value) / total_planted.value) * 100).toFixed(2);
        })
        // survival_rate.addEventListener('change', update_survival_rate())
    </script>

@stop
