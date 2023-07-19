<!-- Using layout\master.blade.php as base -->
@extends('resultsview')

<!-- Editing the @yield('title') section in layout.master to dynamically change the title -->
@section('title', 'Eco Bohol - Home')

@section('content')
    <div class="flex h-screen bg-transparent">
        {{-- <div class="w-1/5 bg-gray-100 shadow-lg">
        <div class="bg-green-500 text-center text-white py-2">search term</div>
    </div> --}}
        <div class="flex-1 mt-16 md:mt-0">
            <div class="pt-4 pl-2">
                @if ($searchTerm)
                    <div class="text-center text-sm mb-2">Search Results: {{ count($data) }}</div>
                @else
                    <div class="text-center text-xl mb-2">{{ ucwords($searchType) }}</div>
                @endif
                <div class="flex space-x-2 border-b-2">
                    {{-- <button class="px-2 py-1 border-b-2 border-lime-600">button</button>
                <button class="px-2 py-1">button 2</button> --}}
                </div>
                <div class="flex justify-center my-2">
                    @if ($searchTerm)
                        <div class="text-left w-4/5 md:w-1/2">
                            <h2><span class="text-gray-500">Search: </span>{{ $searchTerm }}</h2>
                        </div>
                    @endif
                </div>
                <div class="flex justify-center">
                    <ul class="flex-col w-4/5 md:w-1/2 space-y-2">
                        @if (count($data) == 0)
                            <div>
                                <h3 class="text-center">No matching records</h3>
                            </div>
                        @endif
                        @foreach ($data as $item)
                            @if ($searchType == 'mangroves')
                                <li>
                                    <div class="shadow-md">
                                        {{-- {{$item}} --}}
                                        <div class="border p-1 flex justify-between">
                                            <a href="search/mangrove?id={{ $item->species_id }}"
                                                class="text-green-800 font-semibol hover:text-green-500">{{ $item->scientific_name }}</a>
                                            <div class="bg-gray-500 text-white px-2 cursor-default">{{ $item->kingdom }}
                                            </div>
                                        </div>
                                        <div class="border py-5 px-2 flex flex-row gap-2 justify-between">
                                            <div>
                                                <p><span class="text-gray-500">Common Name: </span>{{ $item->common_name }}
                                                </p>
                                                <p>{{ strlen($item->species_descrp) > 200 ? substr($item->species_descrp, 0, 200) . '...' : $item->species_descrp }}
                                                </p>
                                            </div>
                                            @if ($item->images->first())
                                                <div>
                                                    <img class="w-28 h-24"
                                                        src="/storage/{{ $item->images->first() ? $item->images->first()->image : null }}"
                                                        alt="">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @elseif ($searchType == 'projects')
                                <li>
                                    <div class="shadow-md">
                                        {{-- {{$item}} --}}
                                        <div class="border p-1 flex justify-between">
                                            <a href="search/project?id={{ $item->project_id }}"
                                                class="text-green-800 font-semibol hover:text-green-500">{{ $item->project_title }}</a>
                                            <div class="bg-gray-500 text-white px-2 cursor-default">
                                                {{ $item->proj_status }}</div>
                                        </div>
                                        <div class="border py-5 px-2">
                                            <div class="space-y-1">
                                                <p class="text-justify"><span class="text-gray-500">Project
                                                        Description:</span>
                                                    {{ strlen($item->project_descrp) > 200 ? substr($item->project_descrp, 0, 200) . '...' : $item->project_descrp }}
                                                </p>
                                                <p class="text-justify"><span class="text-gray-500">Stakeholder
                                                        Name:</span>
                                                    <span class="text-bold">{{ $item->stakeholder->org_name }}</span>
                                                </p>
                                                <p class="text-justify"><span class="text-gray-500">Project
                                                        Beneficiaries:</span>
                                                    <span class="text-bold">{{ $item->beneficiaries }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @elseif ($searchType == 'journals')
                                <li>
                                    <div class="shadow-md">
                                        {{-- {{$item}} --}}
                                        <div class="border p-1 flex justify-between">
                                            <a href="search/journals?id={{ $item->resjournal_id }}"
                                                class="text-green-800 font-semibol hover:text-green-500">{{ $item->title }}</a>
                                            <div class="bg-gray-500 text-white px-2 cursor-default">{{ $item->author }}
                                            </div>
                                        </div>
                                        <div class="border py-5 px-2">
                                            content here
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
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

@stop
