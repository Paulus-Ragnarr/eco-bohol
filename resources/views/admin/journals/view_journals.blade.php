@extends('layouts.admin')

@section('title', 'Eco Bohol - View Mangrove Projects')

@section('content')
    <div class="common-background flex-1 pt-5 ml-2 px-5 pb-40 overflow-y-auto space-y-2">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-sm md:text-2xl">{{ ucfirst($action) }} Journals</h1>
            <a href="/admin/manage-journals"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 pt-5 pb-5 border-b">
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Journal ID:</span>
                <span class="font-bold">{{ $journals->resjournal_id }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Journal Title: </span><br>
                <span class="font-bold text-justify">{{ $journals->title }}</span>
            </div>
            <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                <span>Species: </span><br>
                @foreach ($mangrove as $mangroves)
                    <span class="font-bold text-justify">{{ $mangroves->scientific_name }}, </span>
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 border-b md:space-x-0 pb-4 mt-5 gap-2">
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Author:</span>
                <span class="font-bold">{{ $journals->author }}</span>
            </span>
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Publisher:</span>
                <span class="font-bold">{{ $journals->publisher }}</span>
            </span>
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Date Published:</span>
                <span class="font-bold">{{ $journals->date_published }}</span>
            </span>
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Journal Attachment:</span>
                <br>
                <span class="font-bold flex flex-col">
                    @foreach ($journals->journal_file as $attachment)
                        @if ($attachment->attachmentFor == 'journal_file')
                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                class="underline text-blue-400
                    hover:text-blue-600">{{ $attachment->attachmentFilename }}</a>
                        @endif
                    @endforeach
                </span>
            </span>
        </div>
        <div class="flex">
            @foreach ($journals->journal_images as $image)
                @if ($image->imageFor == 'journal_img')
                    <div class="h-60 w-72 absolute">
                        <img class="h-full w-full object-cover" src="{{ ' /storage/' . $image->image }}" alt=""
                            class="h-28 w-28 rounded-md border-solid
                            border-2
                            border-gray-100">
                        <div class="absolute top-0 left-0 h-full w-72 flex">
                            <h4 class="text-base font-bold text-white w-full my-auto text-center pt-48">Journal
                                Image
                            </h4>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@stop
