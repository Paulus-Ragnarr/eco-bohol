<!-- Using layout\master.blade.php as base -->
@extends('resultsview')

<!-- Editing the @yield('title') section in layout.master to dynamically change the title -->
@section('title', 'Eco Bohol - Home')

@section('content')
    <div class="flex h-screen bg-transparent">
        <div class="flex-1">
            <div class="pt-4 pl-2">
                <div class="mt-6 md:mt-0 text-center text-xl mb-2 border-b-2">Mangrove Projects</div>
                <form action="/projects" class="flex items-center justify-center mt-5">
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
                                    <h3 class="mt-10 text-center text-bold">No Mangrove Projects found</h3>
                                </div>
                            @endif
                        @endif
                        @foreach ($data as $item)
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
