@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')


@section('content')

<div class="common-background flex-1 p-5">
    <div class="mb-5 border-b-2 pb-5 bg-white">
        <h1 class="text-2xl">Plantation Records</h1>
    </div>
    <div class="flex justify-end mb-2">
        <form action="/admin/analytics-reports/plantation_records" class="flex items-center">
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
                            Plantation ID
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Plantation Address
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Component
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Commodity
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Manager
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
                            @if (count($plantation_records) == 0)
                                <tr>
                                    <td colspan="6" class="text-center py-6">
                                        <h3>No Plantation Records found</h3>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @foreach ($plantation_records as $plantation_record)
                    <tr class="bg-white border-b ">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            {{ $plantation_record->unique_code}}
                        </th>
                        <td class="py-4 px-6">
                            {{ $plantation_record->plantation_address }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $plantation_record->component}}
                        </td>
                        <td class="py-4 px-6">
                            {{ $plantation_record->commodity}}
                        </td>
                        <td class="py-4 px-6">
                            {{ $plantation_record->manager->org_name}}
                        </td>
                        <td
                            class="py-4 px-6 {{ $plantation_record->status == 'Completed' ? 'text-green-600' : 'text-orange-600' }}">
                            {{ $plantation_record->status }}
                        </td>
                        <td class="py-4 px-6">
                            <a href={{ '/admin/analytics-reports/plantation_records?id=' .
                                $plantation_record->plantation_id }}
                                class="font-medium text-blue-600 hover:underline">Print</a>
                        </td>
                    </tr>
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