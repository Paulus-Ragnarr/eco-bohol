@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')


@section('content')

    <div class="common-background flex-1 p-5">
        <div class="mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Nursery Monitoring Records</h1>
        </div>
        <div class="flex justify-end mb-2">
            <form action="/admin/analytics-reports/nursery_monitoring" class="flex items-center">
                <input class="px-2 py-2 bg-gray-100 focus:outline-green-600 text-black" type="text" placeholder="Search"
                    value="{{ $searchTerm }}" name="searchTerm">
                <button type="submit" class="bg-gray-600 hover:bg-gray-800 text-white px-5 py-2">Search</button>
            </form>
        </div>
        <div class="mb-2">
            @if ($searchTerm)
                <h2>Search: {{ $searchTerm }}</h2>
            @endif
        </div>
        <div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-50 uppercase bg-green-600">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Batch ID
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Nursery Address
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Species
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Date Potted
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Initial No. Potted
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Current No. Potted
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Status
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($searchTerm)
                            @if (count($batch_infos) == 0)
                                <tr>
                                    <td colspan="6" class="text-center py-6">
                                        <h3>No Batch Records found</h3>
                                    </td>
                                </tr>
                            @endif
                        @endif
                        {{-- @foreach ($nursery_records as $nursery)
                    <tr class="bg-white border-b ">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            {{$nursrey_monitoring->nursery_id }}
                        </th>
                    </tr> --}}
                        @foreach ($batch_infos as $batch_info)
                            <tr class="bg-white border-b ">
                                {{-- <th scope="row" class="py-4 px-6 font-medium text-gray-900">
                                    <div class="text-xs">
                                        <p>ID: {{ $batch_info->nursery->nursery_id }}</p>
                                        <p>Address: {{ $batch_info->nursery->nursery_address }}</p>
                                    </div>
                                </th> --}}
                                <td class="py-4 px-6">
                                    {{ $batch_info->batch_id }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_info->nursery->nursery_address }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_info->species_record->common_name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_info->date_potted }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_info->no_potted }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $batch_info->current_no_potted }}
                                </td>
                                <td
                                    class="py-4 px-6 {{ $batch_info->status == 'Active' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $batch_info->status }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href={{ '/admin/analytics-reports/nursery_monitoring?id=' .
                                        $batch_info->batch_id .
                                        '&start_date=2023-01-01&end_date=2023-12-31' }}
                                        class="font-medium text-blue-600 hover:underline">View</a>
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@stop

@section('additional_scripts')
    @include('admin.reports.report_scripts')
@stop
