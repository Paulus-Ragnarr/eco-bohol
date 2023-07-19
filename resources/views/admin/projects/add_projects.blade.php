@extends('layouts.admin')

@section('title', 'Eco Bohol - Add Mangrove Projects')

@section('content')

    <div class="common-background flex-1 pt-5 px-5 overflow-y-auto">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-lg md:text-2xl">{{ ucfirst($action) }} Mangrove Projects</h1>
            <a href="/admin/manage-projects"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form action="{{ '/admin/manage-projects/' . ($action == 'update' ? $mangroveproject->project_id : 'add') }}"
            method="POST" enctype="multipart/form-data" id="projectform">
            @if ($action == 'update')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Project Title</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="project_title">Title</label>
                        <input type="text" class="common-input w-96" name="project_title"
                            value=" {{ old('project_title', $mangroveproject ? $mangroveproject->project_title : null) }}"
                            required>
                        @error('project_title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Status</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="proj_status">Project Status</label>
                        <input type="hidden" id="selectedProj_status"
                            value="{{ $mangroveproject ? $mangroveproject->proj_status : null }}">
                        <select type="text" class="common-input" name="proj_status" id="proj_status" required>
                            <option value="Upcoming"
                                {{ old('proj_status') == 'Upcoming' || ($mangroveproject && $mangroveproject->proj_status == 'Upcoming') ? 'selected' : '' }}>
                                Upcoming</option>
                            <option value="Ongoing"
                                {{ old('proj_status') == 'Ongoing' || ($mangroveproject && $mangroveproject->proj_status == 'Ongoing') ? 'selected' : '' }}>
                                Ongoing</option>
                            <option value="Completed"
                                {{ old('proj_status') == 'Completed' || ($mangroveproject && $mangroveproject->proj_status == 'Completed') ? 'selected' : '' }}>
                                Completed</option>
                        </select>
                        @error('proj_status')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <select type="text" class="common-input" name="status" id="status" hidden>
                            <option value="Active" selected></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row lg-items-center">
                    <div class=" w-full md:w-1/6 mb-2 font-bold">
                        <h6>Date</h6>
                    </div>
                    <div class="flex flex-col lg:flex-row">
                        <div class="md:ml-10 flex flex-col">
                            <label for="date_start">Date Started</label>
                            <input class="common-input md:w-60" type="date" name="date_started" id="date_started"
                                value='{{ old('date_started', $mangroveproject ? $mangroveproject->date_started : null) }}'
                                required>
                            <span id="date-start-error" class="text-red-500"></span>
                            @error('date_started')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col">
                            <label for="date_end">Date Ended</label>
                            <input class="common-input md:w-60" type="date" name="date_end" id="date_end"
                                value='{{ old('date_end', $mangroveproject ? $mangroveproject->date_end : null) }}'
                                required>
                            <span id="date-end-error" class="text-red-500"></span>
                            @error('date_end')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row lg-items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Project Details</h6>
                    </div>
                    <div class="flex flex-col lg:flex-row">
                        <div class="md:ml-10 flex flex-col w-full">
                            <label for="beneficiaries">Project Beneficiaries</label>
                            <input class="common-input w-96" type="text" name="beneficiaries" id="beneficiaries"
                                value='{{ old('beneficiaries', $mangroveproject ? $mangroveproject->beneficiaries : null) }}'
                                required>
                        </div>
                    </div>
                </div>

            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Images and Attachments</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="project_img">Image</label>
                        <input type="file" class="common-input md:w-64" name="project_img[]" id="image" multiple
                            accept="image/*">
                        @error('project_img')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="project_attachment">Project Attachment</label>
                        <input type="file" class="common-input md:w-64" name="project_attachment[]" multiple
                            id="project_attachment">
                        @error('project_attachment')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($mangroveproject)
                        <div class="md:ml-10 mt-5 flex">
                            <span class="flex-initial p-3 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Attachments: </span>
                                <span class="font-bold">
                                    @foreach ($mangroveproject->project_attachments as $attachment)
                                        @if ($attachment->attachmentFor == 'project_attachment')
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
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="md:w-1/6 w-full mb-2 font-bold">
                        <h6>Project Description</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col w-full mt-2 md:w-1/2">
                        <textarea name="project_descrp" class="common-input h-60" required>{{ old('project_descrp', $mangroveproject ? $mangroveproject->project_descrp : null) }}</textarea>
                        @error('project_descrp')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b" id="projectUpdateDiv">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Project Update</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col w-full mt-2 md:w-1/2">
                        <textarea name="proj_update" class="common-input h-60" id="proj_update" placeholder="This is Optional">{{ old('proj_update', $mangroveproject ? $mangroveproject->proj_update : null) }}</textarea>
                        @error('proj_update')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href='/admin/manage-projects'
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        const projStatusSelect = document.getElementById('proj_status');
        const projectUpdateDiv = document.getElementById('projectUpdateDiv');
        const dateStartInput = document.getElementById('date_started');
        const dateEndInput = document.getElementById('date_end');
        const dateStartError = document.getElementById('date-start-error');
        const dateEndError = document.getElementById('date-end-error');
        const form = document.getElementById('projectform');

        projStatusSelect.addEventListener('change', function() {
            const selectedStatus = projStatusSelect.value;
            if (selectedStatus === 'Ongoing' || selectedStatus === 'Completed') {
                projectUpdateDiv.style.display = 'block';
            } else {
                projectUpdateDiv.style.display = 'none';
            }
        });

        projStatusSelect.addEventListener('change', validateDates);
        dateStartInput.addEventListener('input', validateDates);
        dateEndInput.addEventListener('input', validateDates);

        form.addEventListener('submit', function(event) {
            // Check if there are any validation errors
            if (dateStartError.textContent !== '' || dateEndError.textContent !== "") {
                event.preventDefault();
            }
        });

        function validateDates() {
            dateStartError.textContent = '';
            dateEndError.textContent = '';

            const projectStatus = projStatusSelect.value;
            const startDate = new Date(dateStartInput.value);
            const endDate = new Date(dateEndInput.value);
            const today = new Date();

            if (projectStatus === 'Ongoing') {
                if (startDate > today) {
                    dateStartError.textContent = 'Start date cannot be a future date.';
                }
                if (endDate < today) {
                    dateEndError.textContent = 'End date must be today or a future date.';
                }
                if (endDate < startDate) {
                    dateEndError.textContent = 'End date must be greater than or equal to the start date.';
                }
            } else if (projectStatus === 'Upcoming') {
                if (startDate <= today) {
                    dateStartError.textContent = 'Start Date must be a future date.';
                }
                if (endDate <= today) {
                    dateEndError.textContent = 'End date must be a future date.';
                }
                if (endDate <= startDate) {
                    dateEndError.textContent = 'End date must not be before the start date.';
                }
            } else if (projectStatus === 'Completed') {
                if (startDate >= today || startDate >= endDate) {
                    dateStartError.textContent = 'Start date must be a before date.';
                }
                if (endDate >= today) {
                    dateEndError.textContent = 'End date must be a before date.';
                }
                if (endDate <= startDate) {
                    dateEndError.textContent = 'End date must not be before the start date.';
                }
            }
        }

        // Check the initial value on page load
        const initialSelectedStatus = projStatusSelect.value;
        if (initialSelectedStatus === 'Ongoing' || initialSelectedStatus === 'Completed') {
            projectUpdateDiv.style.display = 'block';
        } else {
            projectUpdateDiv.style.display = 'none';
        }
    </script>

@stop
