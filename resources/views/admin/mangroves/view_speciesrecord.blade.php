@extends('layouts.admin')

@section('title', 'Eco Bohol - Mangrove Records')

@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-20 overflow-y-auto space-y-2">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucfirst($action) }} Species Record</h1>
            <a href="/admin/manage-speciesrecords"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <div class="flex flex-col ">
            <div class="flex flex-col md:flex-row border-b md:space-x-4 pb-5 mt-5">
                <div class="mb-2 md:mb-0">
                    <span class="p-2 bg-gray-100 rounded-xl hover:bg-green-50 block md:inline">
                        <span>Species ID: </span>
                        <span class="font-bold">{{ $speciesrecord->mangrove_id }}</span>
                    </span>
                </div>
                <div class="mb-2 md:mb-0">
                    <span class="p-2 bg-gray-100 rounded-xl hover:bg-green-50 block md:inline">
                        <span>Scientific Name: </span>
                        <span class="font-bold">{{ $speciesrecord->scientific_name }}</span>
                    </span>
                </div>
                <div class="mb-2 md:mb-0">
                    <span class="p-2 bg-gray-100 rounded-xl hover:bg-green-50 block md:inline">
                        <span>Common Name: </span>
                        <span class="font-bold">{{ $speciesrecord->common_name }}</span>
                    </span>
                </div>
            </div>
            <div class="flex space-y-6 space-x-3 pb-4 mt-5 border-b">
                <span class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span class="">Conservation Status: </span>
                    <span class="font-bold">{{ $speciesrecord->conserv_status }}</span>
                </span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 pt-5 pb-5 border-b">
                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span>Kingdom: </span>
                    <span class="font-bold">{{ $speciesrecord->kingdom }}</span>
                </div>
                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span>Phylum: </span>
                    <span class="font-bold">{{ $speciesrecord->phylum }}</span>
                </div>
                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span>Class: </span>
                    <span class="font-bold">{{ $speciesrecord->class }}</span>
                </div>
                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span>Order: </span>
                    <span class="font-bold">{{ $speciesrecord->order }}</span>
                </div>
                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span>Family: </span>
                    <span class="font-bold">{{ $speciesrecord->family }}</span>
                </div>
                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span>Genus: </span>
                    <span class="font-bold">{{ $speciesrecord->genus }}</span>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 pt-5 pb-5 border-b">
                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span class="">Species Description: </span><br>
                    <span class="font-bold">{{ $speciesrecord->species_descrp }}</span>
                </div>
                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span class="">Propagule Description: </span><br>
                    <span class="font-bold">{{ $speciesrecord->propagule_descrp }}</span>
                </div>
                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span class="">Flower Description: </span><br>
                    <span class="font-bold">{{ $speciesrecord->flower_descrp }}</span>
                </div>
                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span class="">Leaves Description: </span><br>
                    <span class="font-bold">{{ $speciesrecord->leaves_descrp }}</span>
                </div>
                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span class="">Zonation Description: </span><br>
                    <span class="font-bold">{{ $speciesrecord->zonation }}</span>
                </div>
                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                    <span class="">Relevance to the Community: </span><br>
                    <span class="font-bold">{{ $speciesrecord->relev_com }}</span>
                </div>
            </div>
            <div class="grid grid-col lg:grid-cols-4 md:grid-cols-2 gap-6 pt-5 border-b pb-5">
                <div class="carousel">
                    <div class="slider relative overflow-hidden h-60 md:w-72 rounded-md">
                        @foreach ($speciesrecord->images as $image)
                            @if ($image->imageFor == 'species_img')
                                <div class="slide h-60 w-72 absolute">
                                    <img class="h-full w-full object-cover transition-all duration-75 ease-in-out"
                                        src="{{ ' /storage/' . $image->image }}" alt=""
                                        class="h-28 w-28 rounded-md border-solid
                                    border-2
                                    border-gray-100">
                                    <div class="absolute top-0 left-0 h-full w-72 flex">
                                        <h4 class="text-base font-bold text-white w-full my-auto text-center pt-48">Species
                                            Image
                                        </h4>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="absolute flex h-full w-72 top-0 left-0">
                            <div class="my-auto w-full flex justify-between">
                                <button
                                    class="btn-prev bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button
                                    class="btn-next bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
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
                <div class="carousel">
                    <div class="slider relative overflow-hidden h-60 md:w-72 rounded-md">
                        @foreach ($speciesrecord->images as $image)
                            @if ($image->imageFor == 'propagule_img')
                                <div class="slide h-60 w-72 absolute">
                                    <img class="h-full w-full object-cover transition-all duration-75 ease-in-out"
                                        src="{{ ' /storage/' . $image->image }}" alt=""
                                        class="h-28 w-28 rounded-md border-solid
                                    border-2
                                    border-gray-100">
                                    <div class="absolute top-0 left-0 h-full w-72 flex">
                                        <h4 class="text-base font-bold text-white w-full my-auto text-center pt-48">
                                            Propagule
                                            Image
                                        </h4>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="absolute flex h-full w-72 top-0 left-0">
                            <div class="my-auto w-full flex justify-between">
                                <button
                                    class="btn-prev bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button
                                    class="btn-next bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
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
                <div class="carousel">
                    <div class="slider relative overflow-hidden h-60 md:w-72 rounded-md">
                        @foreach ($speciesrecord->images as $image)
                            @if ($image->imageFor == 'flower_img')
                                <div class="slide h-60 w-72 absolute">
                                    <img class="h-full w-full object-cover transition-all duration-75 ease-in-out"
                                        src="{{ ' /storage/' . $image->image }}" alt=""
                                        class="h-28 w-28 rounded-md border-solid
                                    border-2
                                    border-gray-100">
                                    <div class="absolute top-0 left-0 h-full w-72 flex">
                                        <h4 class="text-base font-bold text-white w-full my-auto text-center pt-48">
                                            Flower
                                            Image
                                        </h4>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="absolute flex h-full w-72 top-0 left-0">
                            <div class="my-auto w-full flex justify-between">
                                <button
                                    class="btn-prev bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button
                                    class="btn-next bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
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
                <div class="carousel">
                    <div class="slider relative overflow-hidden h-60 md:w-72 rounded-md">
                        @foreach ($speciesrecord->images as $image)
                            @if ($image->imageFor == 'leaves_img')
                                <div class="slide h-60 w-72 absolute">
                                    <img class="h-full w-full object-cover transition-all duration-75 ease-in-out"
                                        src="{{ ' /storage/' . $image->image }}" alt=""
                                        class="h-28 w-28 rounded-md border-solid
                                    border-2
                                    border-gray-100">
                                    <div class="absolute top-0 left-0 h-full w-72 flex">
                                        <h4 class="text-base font-bold text-white w-full my-auto text-center pt-48">
                                            Leaves
                                            Image
                                        </h4>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="absolute flex h-full w-72 top-0 left-0">
                            <div class="my-auto w-full flex justify-between">
                                <button
                                    class="btn-prev bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button
                                    class="btn-next bg-white p-3 rounded-full bg-opacity-50 shadow-lg hover:bg-green-100">
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
