@extends('layouts.admin')


@section('title', 'Eco Bohol - Nurseries')


@section('content')

    <div class="common-background flex-1 h-screen pt-5 px-5 pb-40 overflow-y-auto space-y-2">
        <div class="mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">Mangrove Nursery</h1>
        </div>
        <div class="my-2 flex justify-end items-center">
            {{-- <form action="/admin/manage-nurseries" class="flex items-center">
            <input class="px-2 py-2 bg-gray-100 focus:outline-green-600 text-black" type="text" placeholder="Search"
                value="{{$searchTerm}}" name="searchTerm">
            <button type="submit" class="bg-gray-600 hover:bg-gray-800 text-white px-5 py-2">Search</button>
        </form> --}}
            <div class="mb-2">
                <a class="primary-btn" href="/admin/manage-nurseries/add">Add</a>
            </div>
        </div>
        {{-- <div>
        @if ($searchTerm)
        <h2>Search: {{$searchTerm}}</h2>
        @endif
    </div> --}}
        @if (Session::has('success'))
            @if (Session::has('success'))
                <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ Session::get('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="document.getElementById('success-alert').style.display = 'none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 5.652a.5.5 0 0 0-.707 0L10 9.293 6.354 5.647a.5.5 0 0 0-.707.707L9.293 10l-3.646 3.646a.5.5 0 1 0 .707.707L10 10.707l3.646 3.646a.5.5 0 0 0 .707-.707L10.707 10l3.646-3.646a.5.5 0 0 0 0-.707z" />
                        </svg>
                    </span>
                </div>
            @endif
        @endif
        <div>
            {{ $nurseries->links('vendor.pagination.tailwind') }}
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
                            <th scope="col" class="py-3 px-6">
                                Organization Name
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nurseries as $nursery)
                            <tr class="bg-white border-b ">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $nursery->nursery_address }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ $nursery->date_established }}
                                </td>
                                <td class="py-4 px-6">
                                    @foreach ($managers as $manager)
                                        @if ($manager->manager_id == $nursery->manager_id)
                                            {{ $manager->org_name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="py-4 px-6">
                                    <a href={{ '/admin/manage-nurseries/view?nursery_id=' . $nursery->nursery_id }}
                                        class="font-medium
                                text-blue-600
                                hover:underline">View</a>
                                    <span>|</span>
                                    <a href={{ ' /admin/manage-nurseries/update?nursery_id=' . $nursery->nursery_id }}
                                        class="font-medium
                                text-blue-600
                                hover:underline">Update</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
