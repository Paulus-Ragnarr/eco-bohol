<!-- Using layout\master.blade.php as base -->
@extends('resultsview')

<!-- Editing the @yield('title') section in layout.master to dynamically change the title -->
@section('title', 'Eco Bohol - Home')

@section('content')
    <div class="flex h-screen bg-transparent">
        {{-- <div class="w-1/5 bg-gray-100 shadow-lg">
        <div class="bg-green-500 text-center text-white py-2">search term</div>
    </div> --}}
        <div class="flex-1">
            <div class="pt-4 pl-2">
                <div class="mt-6 md:mt-0 text-center text-xl mb-2 border-b-2">Mangroves</div>
                <form action="/mangroves" class="flex items-center justify-center mt-5">
                    <input class="px-2 py-2 bg-gray-100 focus:outline-green-600 text-black w-3/5 md:w-[53.4rem]"
                        type="text" placeholder="Search" value="{{ $searchTerm }}" name="searchTerm">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-800 text-white px-5 py-2">Search</button>
                </form>
                <div class="flex justify-center mt-5">
                    @if ($searchTerm)
                        <h2>Search: {{ $searchTerm }}</h2>
                    @endif
                </div>
                <div class="flex justify-center mt-5">
                    <ul class="flex-col w-4/5 md:w-1/2 space-y-2">
                        @if ($searchTerm)
                            @if (count($data) == 0)
                                <div>
                                    <h3 class="mt-10 text-center text-bold">No Mangrove Species found</h3>
                                </div>
                            @endif
                        @endif
                        @foreach ($data as $item)
                            <li>
                                <div class="shadow-md">
                                    {{-- {{$item}} --}}
                                    <div class="border p-1 flex justify-between">
                                        <a href="search/mangrove?id={{ $item->species_id }}"
                                            class="text-green-800 font-semibol hover:text-green-500">{{ $item->scientific_name }}</a>
                                        <div class="bg-gray-500 text-white px-2 cursor-default">{{ $item->family }}</div>
                                    </div>
                                    <div class="border py-5 px-2 flex flex-row gap-2 justify-between">
                                        <div>
                                            <p><span class="text-gray-500">Common Name: </span>{{ $item->common_name }}</p>
                                            <p class="text-justify">
                                                {{ strlen($item->species_descrp) > 200 ? substr($item->species_descrp, 0, 200) . '...' : $item->species_descrp }}
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
