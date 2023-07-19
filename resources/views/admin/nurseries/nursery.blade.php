@extends('layouts.admin')


@section('title', 'Eco Bohol - Nursery Record')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-lg md:text-2xl">{{ ucfirst($action) }} Nursery</h1>
            <a href='/admin/manage-nurseries'
                class=" h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form action={{ '/admin/manage-nurseries/' . $action }}{{ $nursery ? '?nursery_id=' . $nursery->nursery_id : '' }}
            method="POST">
            @if ($action == 'update')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row lg:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Nursery Details</h6>
                    </div>
                    <div class="flex flex-col md:flex-row md:ml-10">
                        <div class="flex flex-col mb-2 md:mr-10">
                            <label for="nursery_address">Address</label>
                            <input class="common-input w-72" type="text" name="nursery_address"
                                value="{{ old('nursery_address', $nursery ? $nursery->nursery_address : null) }}">
                            @error('nursery_address')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="date_established">Date Established</label>
                            <input class="common-input" type="date" name="date_established"
                                value='{{ old('date_established', $nursery ? $nursery->date_established : null) }}'>
                            @error('date_established')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href='/admin/manage-nurseries'
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Cancel</a>
            </div>
        </form>
    </div>
@stop
