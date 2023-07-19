<!-- Using layout\master.blade.php as base -->
@extends('resultsview')

<!-- Editing the @yield('title') section in layout.master to dynamically change the title -->
@section('title', 'Eco Bohol - Home')

@section('content')
    <div class="flex h-screen bg-transparent">
        @if ($searchType == 'mangrove')
            <div class="w-full h-full">
                <div class="py-5 border-b-2 my-5">
                    <h2 class="text-center font-semibold">{{ $data->scientific_name }} | {{ $data->common_name }}</h2>
                </div>
                <div class="flex flex-col md:flex-row justify-center h-full mt-80 md:mt-0">
                    <input type="text" value={{ $data->species_id }} id="species_id" hidden>
                    <div class="w-1/4 hidden md:block"></div>
                    {{-- <div id="map" class="h-1/3 w-1/4 mx-0 mt-0"></div> --}}
                    <div class="md:w-1/2 space-y-4 px-4 mt-96 md:mt-0">
                        <div>
                            <h6>Taxonomy:</h6>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 pb-5 border-b">
                                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Kingdom: </span>
                                    <span class="">{{ $data->kingdom }}</span>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Phylum: </span>
                                    <span class="">{{ $data->phylum }}</span>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Class: </span>
                                    <span class="">{{ $data->class }}</span>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Order: </span>
                                    <span class="">{{ $data->order }}</span>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Family: </span>
                                    <span class="">{{ $data->family }}</span>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Genus: </span>
                                    <span class="">{{ $data->genus }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h6>Species Images</h6>
                            <div class="mangrove_images items-center flex flex-row pb-5 space-x-1 border-b overflow-x-auto">
                                @foreach ($data->images as $image)
                                    @if ($image->imageFor == 'species_img')
                                        <a href="/storage/{{ $image->image }}" class="hover:border hover:shadow-xl">
                                            <img class="h-48 w-48" src="/storage/{{ $image->image }}"
                                                alt="{{ $image->image_id }}">
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <h6>Species Description</h6>
                            <div class="pb-5 border-b">
                                <p class="text-justify">{{ $data->species_descrp }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-1 border-b">
                            <h6>Other Species Details</h6>
                            <div class="py-3 space-y-2 border-b">
                                <h6>Propagule Images</h6>
                                <div class="mangrove_images flex space-x-1 overflow-x-auto">
                                    @foreach ($data->images as $image)
                                        @if ($image->imageFor == 'propagule_img')
                                            <a href="/storage/{{ $image->image }}" class="hover:border hover:shadow-xl">
                                                <img class="h-48 w-48" src="/storage/{{ $image->image }}"
                                                    alt="{{ $image->image_id }}">
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Propagule Description: </span><br>
                                    <span class="">{{ $data->propagule_descrp }}</span>
                                </div>
                            </div>
                            <div class="py-3 space-y-2 border-b">
                                <h6>Flower Images</h6>
                                <div class="mangrove_images flex space-x-1 overflow-x-auto">
                                    @foreach ($data->images as $image)
                                        @if ($image->imageFor == 'flower_img')
                                            <a href="/storage/{{ $image->image }}" class="hover:border hover:shadow-xl">
                                                <img class="h-48 w-48" src="/storage/{{ $image->image }}"
                                                    alt="{{ $image->image_id }}">
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Flower Description: </span><br>
                                    <span class="">{{ $data->flower_descrp }}</span>
                                </div>
                            </div>
                            <div class="py-3 space-y-2 border-b">
                                <h6>Leaves Images</h6>
                                <div class="mangrove_images flex space-x-1 overflow-x-auto">
                                    @foreach ($data->images as $image)
                                        @if ($image->imageFor == 'leaves_img')
                                            <a href="/storage/{{ $image->image }}" class="hover:border hover:shadow-xl">
                                                <img class="h-48 w-48" src="/storage/{{ $image->image }}"
                                                    alt="{{ $image->image_id }}">
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Leaves Description: </span><br>
                                    <span class="">{{ $data->leaves_descrp }}</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 pt-5 pb-3 border-b">
                                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Zonation Description: </span><br>
                                    <span class="">{{ $data->zonation }}</span>
                                </div>
                                <div class="text-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Relevance to the Community: </span><br>
                                    <span class="">{{ $data->relev_com }}</span>
                                </div>
                                <div class="items-justify p-4 bg-gray-100 rounded-xl hover:bg-green-50">
                                    <span class="text-gray-500">Conservation Status: </span><br>
                                    <span class="">{{ $data->conserv_status }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col text-center w-full h-96 border-b my-1">
                            <h4>Heat Map</h4>
                            <div id="map" style="height: 90%; width: 100%"></div>
                        </div>
                        <div class="flex flex-col text-center w-full border-b mt-1 pb-4">
                            <h4>Location</h4>
                            <input id="mangrove_locations" value="{{ $locations }}" hidden>
                            <canvas id="location_graph"></canvas>
                        </div>
                    </div>
                    <div class="md:w-1/4 pb-5 mx-4 md:mx-0 mt-2 md:mt-0">
                        <div class="border rounded-md h-auto p-2 overflow-y-auto scrollbar-hide">
                            <div class="border-b pb-2">
                                <h6>Related</h6>
                                <div class="grid grid-cols-2">
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=mangroves&search-term={{ $data->conserv_status }}">{{ $data->conserv_status }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=mangroves&search-term={{ $data->kingdom }}">{{ $data->kingdom }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=mangroves&search-term={{ $data->phylum }}">{{ $data->phylum }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=mangroves&search-term={{ $data->class }}">{{ $data->class }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=mangroves&search-term={{ $data->order }}">{{ $data->order }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=mangroves&search-term={{ $data->family }}">{{ $data->family }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=mangroves&search-term={{ $data->genus }}">{{ $data->genus }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="pb-1">
                                <h6 class="my-2">Research Journals</h6>
                                <div class="grid grid-rows-1 md:grid-cols-2 gap-3 my-3">
                                    @foreach ($journals as $journal)
                                        <div
                                            class="flex flex-col text-center bg-white border rounded-lg shadow-md transition ease-in-out delay-100 hover:border-black hover:-translate-y-1 hover:scale-105 duration-100">
                                            <div class="justify-between">
                                                <img class="rounded-md h-20 w-20 mx-auto mt-2" alt="Image"
                                                    src="/storage/{{ $journal->journal_images[0]->image }}"
                                                    alt="">
                                                <p class="text-sm font-semibold mt-1 px-3">{{ $journal->title }}</p>
                                            </div>
                                            <div class="flex flex-col justify-between py-3 space-y-1">
                                                <p class="text-xs">Date Published: {{ $journal->date_published }}</p>
                                                <p class="text-xs">{{ $journal->author }}</p>
                                                <p class="text-xs">{{ $journal->publisher }}</p>
                                                <div class="flex justify-center items-center">
                                                    @foreach ($journal->journal_file as $attachment)
                                                        @if ($attachment->attachmentFor == 'journal_file')
                                                            <a href="{{ '/storage/' . $attachment->attachment }}"
                                                                class="text-xs px-2 text-blue-400 hover:text-blue-600 hover:underline">
                                                                {{ $attachment->attachmentFilename }}
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($searchType == 'project')
            <div class="w-full h-full">
                <div class="py-5 border-b-2 mb-5">
                    <h2 class="text-center font-semibold">Project Title: {{ $data->project_title }}</h2>
                </div>
                <div class="flex flex-col md:flex-row md:justify-center h-full">
                    <div class="w-1/4 hidden md:block"></div>
                    <div class="md:w-1/2 space-y-4 px-4">
                        <div class="pb-4 border-b space-y-2">
                            <div class="flex w-full space-x-2">
                                <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                    <span class="text-gray-500">Date Started: </span>
                                    <span class="">{{ $data->date_started }}</span>
                                </div>
                                <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                    <span class="text-gray-500">Date End: </span>
                                    <span class="">{{ $data->date_end }}</span>
                                </div>
                            </div>
                            <div class="flex w-full space-x-2">
                                <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                    <span class="text-gray-500">Status: </span>
                                    <span class="">{{ $data->status }}</span>
                                </div>
                                <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                    <span class="text-gray-500">Project Status: </span>
                                    <span class="">{{ $data->proj_status }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h6>Images</h6>
                            <div class="mangrove_images flex space-x-2 overflow-x-auto pb-5 border-b">
                                @foreach ($data->project_images as $image)
                                    <a href="/storage/{{ $image->image }}" class="hover:border hover:shadow-xl">
                                        <img class="h-48 w-48" src="/storage/{{ $image->image }}"
                                            alt="{{ $image->image_id }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <h6>Project Description</h6>
                            <div class="flex gap-3 pt-2 pb-5 border-b">
                                <span
                                    class="p-4 bg-gray-100 text-justify rounded-xl hover:bg-green-50">{{ $data->project_descrp }}</span>
                            </div>
                        </div>
                        @if ($data->proj_update)
                            <div>
                                <h6>Project Update</h6>
                                <div class="flex gap-3 pt-2 pb-5 border-b">
                                    <span
                                        class="p-4 bg-gray-100 text-justify rounded-xl hover:bg-green-50">{{ $data->proj_update }}</span>
                                </div>
                            </div>
                        @endif
                        <div>
                            <h6>Project Beneficiaries</h6>
                            <div class="flex gap-3 pt-2 pb-5 border-b">
                                <span
                                    class="p-4 bg-gray-100 text-justify rounded-xl hover:bg-green-50 text-bold">{{ $data->beneficiaries }}</span>
                            </div>
                        </div>
                        <div class="md:pb-5">
                            <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                <span class="text-gray-500">Stakeholder Name: </span>
                                <span class="text-bold">{{ $data->stakeholder->org_name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/4 mt-2 md:mt-0 mx-4 md:mx-0 pb-5">
                        <div class="border rounded-md h-full p-2">
                            <div class="border-b pb-2">
                                <h6>Project Attachment</h6>
                                <div class="flex flex-col">
                                    @foreach ($data->project_attachments as $attachment)
                                        @if ($attachment->attachmentFor == 'project_attachment')
                                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                                class="underline text-blue-400
                            hover:text-blue-600">{{ $attachment->attachmentFilename }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="">
                                <h6>Related</h6>
                                <div class="grid grid-cols-2">
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=projects&search-term={{ $data->status }}">{{ $data->status }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=projects&search-term={{ $data->proj_status }}">{{ $data->proj_status }}</a>
                                    </div>
                                    <div>
                                        <a class="text-blue-500 hover:underline"
                                            href="/search?searchType=projects&search-term={{ $data->stakeholder_id }}">{{ $data->stakeholder->org_name }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($searchType == 'journals')
                <div class="w-full h-full">
                    <div class="py-5 border-b-2 mb-5">
                        <h2 class="text-center font-semibold">Journal Title: {{ $data->title }}</h2>
                    </div>
                    <div class="flex flex-col md:flex-row md:justify-center h-full">
                        <div class="w-1/4 hidden md:block"></div>
                        <div class="md:w-1/2 space-y-4 px-4">
                            <div class="pb-4 border-b space-y-2">
                                <div class="flex w-full space-x-2">
                                    <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                        <span class="text-gray-500">Author: </span>
                                        <span class="">{{ $data->author }}</span>
                                    </div>
                                    <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                        <span class="text-gray-500">Publisher: </span>
                                        <span class="">{{ $data->publisher }}</span>
                                    </div>
                                </div>
                                <div class="flex w-full space-x-2">
                                    <div class="items-center p-2 bg-gray-100 rounded-xl hover:bg-green-50 w-full">
                                        <span class="text-gray-500">Status: </span>
                                        <span class="">{{ $data->status }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h6>Images</h6>
                                <div class="journal_images flex space-x-2 overflow-x-auto pb-5 border-b">
                                    @foreach ($data->journal_images as $image)
                                        <a href="/storage/{{ $image->image }}" class="hover:border hover:shadow-xl">
                                            <img class="h-40 w-40" src="/storage/{{ $image->image }}"
                                                alt="{{ $image->image_id }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="md:w-1/4 mt-2 md:mt-0 mx-4 md:mx-0 pb-5">
                            <div class="border rounded-md h-full p-2">
                                <div class="border-b pb-2">
                                    <h6>Attachments</h6>
                                    <div class="flex flex-col">
                                        @foreach ($data->journal_file as $attachment)
                                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                                class="underline text-blue-400
                            hover:text-blue-600">{{ $attachment->attachmentFilename }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="">
                                    <h6>Related</h6>
                                    <div class="grid grid-cols-2">
                                        <div>
                                            <a class="text-blue-500 hover:underline"
                                                href="/search?searchType=journals&search-term={{ $data->status }}">{{ $data->status }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endif
    </div>
@stop

@section('script')
    <script>
        let menu_button = document.getElementById("show-menu-btn");
        let mobile_menu = document.getElementById("mobile-menu");

        function scrollToName(e) {
            document
                .getElementById(e.target.getAttribute("name"))
                .scrollIntoView({
                    behavior: "smooth"
                });

            mobile_menu.classList.add('hidden')
        }


        menu_button.addEventListener("click", function() {
            mobile_menu.classList.toggle("hidden")
            if (!mobile_menu.classList.contains("hidden")) {
                mobile_menu.focus();
            }
        });

        menu_button.addEventListener("focusout", function() {
            // mobile_menu.classList.add('hidden')
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script src="{{ asset('static/js/heatmap_3.js') }}"></script>
    <script src="{{ asset('static/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('static/js/mangrove_locations_graph.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3EnVFiQGl-stBLE-pR_dCBpT0H3JeDzM&callback=initMap&libraries=visualization"
        async defer></script>
@stop
