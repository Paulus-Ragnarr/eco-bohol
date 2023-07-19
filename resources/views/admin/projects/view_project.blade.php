@extends('layouts.admin')

@section('title', 'Eco Bohol - View Mangrove Projects')

@section('content')
    <div class="common-background flex-1 pt-5 ml-2 px-5 pb-40 overflow-y-auto space-y-2">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-sm md:text-2xl">{{ ucfirst($action) }} Mangrove Projects</h1>
            <a href="/admin/manage-projects"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="flex justify-end mb-5">
            <a href={{ '/admin/manage-projects/update?project_id=' . $mangroveproject->project_id }}
                class="primary-btn md:ml-4 mb-5">Edit Record</a>
        </div>
        <div class="flex flex-col md:flex-row border-b md:space-x-4 pb-5 mt-5">
            <div class="mb-2 md:mb-0">
                <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                    <span class="">Project ID:</span>
                    <span class="font-bold">{{ $mangroveproject->project_id }}</span>
                </span>
            </div>
            <div class="mb-2 md:mb-0">
                <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                    <span class="">Project Title:</span>
                    <span class="font-bold">{{ $mangroveproject->project_title }}</span>
                </span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 border-b md:space-x-0 pb-4 mt-5 gap-2">
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Date Started:</span>
                <span class="font-bold">{{ $mangroveproject->date_started }}</span>
            </span>
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Date End:</span>
                <span class="font-bold">{{ $mangroveproject->date_end }}</span>
            </span>
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Status:</span>
                <span class="font-bold">{{ $mangroveproject->status }}</span>
            </span>
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Project Status:</span>
                <span class="font-bold">{{ $mangroveproject->proj_status }}</span>
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 border-b md:space-x-0 pb-4 mt-5">
            <span class=" bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Project Description:</span>
                <br>
                <span class="font-bold">{{ $mangroveproject->project_descrp }}</span>
            </span>
            @if ($mangroveproject->proj_update)
                <span class=" bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                    <span>Project Update:</span>
                    <br>
                    <span class="font-bold">{{ $mangroveproject->proj_update }}</span>
                </span>
            @endif
            <span class=" bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Project Beneficiaries:</span>
                <br>
                <span class="font-bold">{{ $mangroveproject->beneficiaries }}</span>
            </span>
            <span class="bg-gray-100 p-2 rounded-xl hover:bg-green-50 block md:inline">
                <span>Project Attachment:</span>
                <br>
                <span class="font-bold flex flex-col">
                    @foreach ($mangroveproject->project_attachments as $attachment)
                        @if ($attachment->attachmentFor == 'project_attachment')
                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                class="underline text-blue-400
                    hover:text-blue-600">{{ $attachment->attachmentFilename }}</a>
                        @endif
                    @endforeach
                </span>
            </span>
        </div>
        <div class="flex flex-row gap-4 py-5 border-b pb-5">
            <div class="carousel">
                <div class="slider relative overflow-hidden h-60 w-72 rounded-md">
                    @foreach ($mangroveproject->project_images as $image)
                        @if ($image->imageFor == 'project_img')
                            <div class="slide h-60 w-72 absolute">
                                <img class="h-full w-full object-cover transition-all duration-75 ease-in-out"
                                    src="{{ ' /storage/' . $image->image }}" alt=""
                                    class="h-28 w-28 rounded-md border-solid
                            border-2
                            border-gray-100">
                                <div class="absolute top-0 left-0 h-full w-72 flex">
                                    <h4 class="text-base font-bold text-white w-full my-auto text-center pt-48">Project
                                        Image
                                    </h4>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="absolute flex h-full w-72 top-0 left-0">
                        <div class="my-auto w-full flex justify-between">
                            <button class="btn-prev bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button class="btn-next bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const carousels = document.querySelectorAll(".carousel");

        carousels.forEach((carousel) => {
            const slides = carousel.querySelectorAll(".slide");

            slides.forEach((slide, indx) => {
                slide.style.transform = `translateX(${indx * 100}%)`;
            });

            const nextSlide = carousel.querySelector(".btn-next");
            let curSlide = 0;
            const maxSlide = slides.length - 1;

            nextSlide.addEventListener("click", function() {
                if (curSlide === maxSlide) {
                    curSlide = 0;
                } else {
                    curSlide++;
                }

                slides.forEach((slide, indx) => {
                    slide.style.transform = `translateX(${100 * (indx - curSlide)}%)`;
                });
            });

            const prevSlide = carousel.querySelector(".btn-prev");

            prevSlide.addEventListener("click", function() {
                if (curSlide === 0) {
                    curSlide = maxSlide;
                } else {
                    curSlide--;
                }

                slides.forEach((slide, indx) => {
                    slide.style.transform = `translateX(${100 * (indx - curSlide)}%)`;
                });
            });
        });
    </script>
@stop
