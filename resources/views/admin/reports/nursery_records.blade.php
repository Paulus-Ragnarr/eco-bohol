@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')


@section('content')

<div class="common-background flex-1 p-5">
    <div class="mb-5 border-b-2 pb-5 bg-white">
        <h1 class="text-2xl">Nursery Records</h1>
    </div>
    <div class="flex justify-end mb-2">
        <form action="/admin/analytics-reports/nursery_records" class="flex items-center">
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
                            Nursery Address
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Date Established
                        </th>
                        {{-- <th scope="col" class="py-3 px-6">
                            Manager
                        </th> --}}
                        <th scope="col" class="py-3 px-6">
                            Organization Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($searchTerm)
                            @if (count($nursery_records) == 0)
                                <tr>
                                    <td colspan="6" class="text-center py-6">
                                        <h3>No Nursery Records found</h3>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @foreach ($nursery_records as $nursery_record)
                    <tr class="bg-white border-b ">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            {{ $nursery_record->nursery_address}}
                        </th>
                        <td class="py-4 px-6">
                            {{ $nursery_record->date_established}}
                        </td>
                        {{-- <td class="py-4 px-6">
                            {{ $nursery_record->manager->manager_name}}
                        </td> --}}
                        <td class="py-4 px-6">
                            {{ $nursery_record->manager->org_name}}
                        </td>
                        <td class="py-4 px-6">
                            <a href={{ '/admin/analytics-reports/nursery_records?id=' . $nursery_record->nursery_id }}
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