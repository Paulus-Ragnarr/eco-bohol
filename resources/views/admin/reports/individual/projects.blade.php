@extends('layouts.admin')

@section('title', 'Eco Bohol - Reports')

@section('content')

    <div class="common-background flex-1 p-5">
        <div class="mb-5 border-b-2 pb-5 bg-white flex justify-between">
            <h1 class="text-2xl">Generate Mangrove Projects</h1>
            <a href="/admin/dashboard"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24  bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="flex justify-end">
            <form action="/admin/analytics-reports/projects" method="get" class="flex space-x-2">
                <select type="text" class="common-input w-64" name="proj_status" id="proj_status" required>
                    <option value="Upcoming" {{ $proj_status && $proj_status == 'Upcoming' ? 'selected' : '' }}>
                        Upcoming</option>
                    <option value="Ongoing" {{ $proj_status && $proj_status == 'Ongoing' ? 'selected' : '' }}>
                        Ongoing</option>
                    <option value="Completed" {{ $proj_status && $proj_status == 'Completed' ? 'selected' : '' }}>
                        Completed</option>
                </select>

                <button type="submit" class="secondary-btn md:ml-4">Filter</button>
            </form>
            <div>
                <button id="print-button" class="primary-btn md:ml-4">Print Report</button>
            </div>
        </div>
        <div class="mt-10" id="report-print">
            <div id="report-paper" class="flex flex-col h-full space-y-4 px-10 py-8 bg-white text-center">
                <div class="report-header-log">
                    <div class="">
                        <h1 class="underline text-2xl font-bold text-black">Mangrove Projects</h1>
                    </div>
                </div>
                <div class="flex space-x-10">
                    <div>
                        <span class="font-bold">Organization Name:</span>
                        <span>{{ $user->stakeholder->org_name }}</span>
                    </div>
                    <div>
                        <span class="font-bold">Organization Type:</span>
                        <span>{{ $user->stakeholder->stakeholder_type }}</span>
                    </div>
                    <div>
                        <span class="font-bold">Filtered Project Status:</span>
                        <span>{{ $proj_status }}</span>
                    </div>
                    <div>
                        <span class="font-bold">As of:</span>
                        <span id="record-date"></span>
                    </div>
                </div>
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500 report-table">
                        <thead class="text-xs uppercase">
                            <tr>
                                <th scope="col" class="py-2 px-4">
                                    Project Title
                                </th>
                                <th scope="col" class="py-2 px-4">
                                    Project Description
                                </th>
                                <th scope="col" class="py-2 px-4">
                                    Project Beneficiaries
                                </th>
                                <th scope="col" class="py-2 px-4">
                                    Date Start
                                </th>
                                <th scope="col" class="py-2 px-4">
                                    Date End
                                </th>
                                <th scope="col" class="py-2 px-4">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="py-2 px-3 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $project->project_title }}
                                    </th>
                                    <td class="py-2 px-3 text-justify">
                                        {{ $project->project_descrp }}
                                    </td>
                                    <td class="py-2 px-3">
                                        {{ $project->beneficiaries }}
                                    </td>
                                    <td class="py-2 px-3">
                                        {{ $project->date_started }}
                                    </td>
                                    <td class="py-2 px-3">
                                        {{ $project->date_end }}
                                    </td>
                                    <td class="py-2 px-3">
                                        {{ $project->status }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getCurrentDateAndTime() {
            const dateTime = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            return dateTime.toLocaleString(undefined, options);
        }

        const dateDisplay = document.getElementById('record-date');
        dateDisplay.innerHTML = getCurrentDateAndTime();
    </script>
@stop
@section('additional_scripts')
    @include('admin.reports.report_scripts')
@stop
