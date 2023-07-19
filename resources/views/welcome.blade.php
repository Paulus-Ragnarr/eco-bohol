<!-- Using layout\master.blade.php as base -->
@extends('layouts.master')

<!-- Editing the @yield('title') section in layout.master to dynamically change the title -->
@section('title', 'Eco Bohol - Home')

@section('header')
    @php
        $user = Auth::user();
        if ($user) {
            $user_permissions = $user->permissions();
        }
    @endphp


    <header class="z-20 flex w-full justify-between items-center fixed top-0 p-4 md:p-2 bg-black/25">
        <a href="/" class="text-2xl text-white">
            Eco Bohol
        </a>
        <div>
            <div class="md:hidden">
                <button id="show-menu-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                    </svg>
                </button>
            </div>
            {{-- medium screen menu --}}
            <div class="hidden md:flex items-center space-x-4 text-white">
                <div class="home-nav-link">
                    <div name="home" onclick="scrollToName(event)">
                        Home
                    </div>
                </div>
                <div class="home-nav-link">
                    <a name="mangrove" href="/mangroves">
                        Mangroves
                    </a>
                </div>
                <div class="home-nav-link">
                    <div name="heatmap" onclick="scrollToName(event)">
                        Heat Map
                    </div>
                </div>
                <div class="home-nav-link">
                    <div name="projects" onclick="scrollToName(event)">
                        Projects
                    </div>
                </div>
                {{-- <div class="home-nav-link">
                <div name="research" onclick="scrollToName(event)">
                    Research
                </div>
            </div> --}}
                <div class="home-nav-link">
                    <div name="about-us" onclick="scrollToName(event)">
                        About Us
                    </div>
                </div>
                <div class="primary-btn px-4 py-1 rounded">
                    @if ($user)
                        <a href="/admin">Dashboard</a>
                    @else
                        <a href="/login">Login</a>
                        <p hidden id="check-auth"></p>
                    @endif
                </div>
            </div>

            {{-- small screen menu --}}
            <div id="mobile-menu"
                class="hidden md:hidden fixed top-0 right-4 bg-white w-32 rounded space-y-2 shadow-md px-4 py-5 mt-12">
                <div class="home-dropdown-link">
                    <div name="home" onclick="scrollToName(event)">
                        Home
                    </div>
                </div>
                <div class="home-dropdown-link">
                    <a name="mangroves" href="/mangroves">
                        Mangroves
                    </a>
                </div>
                <div class="home-dropdown-link">
                    <div name="heatmap" onclick="scrollToName(event)">
                        Heat Map
                    </div>
                </div>
                <div class="home-dropdown-link">
                    <div name="projects" onclick="scrollToName(event)">
                        Projects
                    </div>
                </div>
                {{-- <div class="home-dropdown-link">
                <div name="research" onclick="scrollToName(event)">
                    Research
                </div>
            </div> --}}
                <div class="home-dropdown-link">
                    <div name="about-us" onclick="scrollToName(event)">
                        About Us
                    </div>
                </div>
                <div class="primary-btn px-4 py-1 rounded">
                    @if ($user)
                        <a href="/admin">Dashboard</a>
                    @else
                        <a href="/login">Login</a>
                        <p hidden id="check-auth"></p>
                    @endif
                </div>
            </div>
        </div>
    </header>
@stop


@section('content')
    <div class="h-screen flex flex-col items-center justify-center bg-bottom" id="home">
        <div>
            <h2 class="text-white text-sm md:text-xl">Department of Environment and Natural Resources</h2>
        </div>
        <div class="md:w-1/2">
            <h1 class="text-white font-bold text-4xl md:text-6xl mb-5 md:mb-10 text-center">Free Access to Mangrove Data
            </h1>
        </div>
        <form class="md:w-full flex justify-center" method="GET" action="/search">
            <select name="searchType" id="searchType" class="rounded-l-md bg-gray-100 px-2 text-sm md:text-xl">
                <option value="mangroves">Mangroves</option>
                <option value="projects">Projects</option>
                {{-- <option value="journals">Journals</option> --}}
            </select>
            <input class="py-2 md:py-5 px-2 md:w-1/2 focus:outline-none text-md md:text-xl text-gray-600" type="text"
                placeholder="Search" name="search-term" />
            <button class="mangrove-search-btn" type='submit'>
                Search
            </button>
        </form>
    </div>
    <div class="h-screen flex items-center justify-center relative" id="heatmap">
        {{-- <div id="floating-panel">
            <button id="toggle-heatmap">Toggle Heatmap</button>
            <button id="change-gradient">Change gradient</button>
            <button id="change-radius">Change radius</button>
            <button id="change-opacity">Change opacity</button>
        </div> --}}
        {{-- <div
            class="md:w-1/4 absolute top-20 left-2 md:left-20 z-10 bg-white p-4 rounded-md shadow-md flex flex-col space-y-2">
            <select class="bg-gray-100 py-2 px-4" name="location">
                <option value="1">location 1</option>
                <option value="2">location 2</option>
                <option value="3">location 3</option>
                <option value="4">location 4</option>
                <option value="5">location 5</option>
            </select>
            <button class="primary-btn" id='get-map-image'>Print</button>
            <button class="secondary-btn" id='change-data'>Change Data</button>
        </div> --}}
        <div class="md:w-1/4 absolute bottom-20 left-2 md:left-20 z-10 bg-black/20 p-2 rounded-md shadow-md text-white"
            id="summary_div">
            <div class="items-center">
                <div class="summary_label">
                    <span>Naturally Grown: </span>
                </div>
                <div class="h-2 w-full plan-gradient"></div>
            </div>
            <div class="items-center">
                <div class="summary_label">
                    <span>Plantation: </span>
                </div>
                <div class="h-2 w-full nat-gradient"></div>
            </div>
        </div>
        <div id="map" style="height: 100%; width: 100%"></div>
    </div>
    <div class="h-screen bg-[#edeeef] flex items-center justify-center relative w-full" id="projects">
        <img class="absolute -bottom-24 right-[10%] h-[600px] w-[600px] hidden md:block"
            src="/static/img/Pngtree-mangrove-tree.png" alt="mangrove-tree">
        {{-- <img class="absolute top-5 left-[20%] h-[300px] w-[300px] hidden md:block"
        src="/static/img/Pngtree-flat-cute-cartoon-happy-sun.png" alt="mangrove-tree"> --}}
        <div class="md:z-10 mt-32 p-5 bg-[#3d7938]/60 rounded-md shadow-md w-3/4 md:w-1/2">
            <h2 class="text-4xl font-bold text-white mb-5">Bohol Mangrove Projects</h2>
            {{-- @if ($project)
        <div>
            <h2 class="text-2xl mb-5 text-white">{{$project->project_title}}</h2>
            <div class="flex space-x-8">
                <img class="w-1/2 shadow-lg rounded-3xl" src="/storage/{{$project->project_images[0]->image}}" alt="">
                <div class="flex flex-col space-y-2 text-white">
                    <p>
                        {{$project->project_descrp}}
                    </p>
                    <a href="/search/project?id={{$project->project_id}}" class="project_learn_more">Learn More</a>
                </div>
            </div>
        </div>
        @endif --}}
            <div class="grid grid-flow-row md:grid-cols-3 gap-4">
                @foreach ($project as $project)
                    <div class="overflow-hidden bg-white border rounded-lg shadow-lg">
                        <img class="h-48 w-full object-cover" alt="Image"
                            src="/storage/{{ $project->project_images[0]->image }}" alt="">
                        <h3 class="mt-5 text-center text-1xl font-bold">{{ $project->project_title }}</h3>
                        <h3 class="mt-2 text-center text-md">{{ $project->stakeholder->org_name }}</h3>
                        <div class="mt-5 mb-5 flex justify-center text-white">
                            <a href="/search/project?id={{ $project->project_id }}" class="project_learn_more">Learn
                                More</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center mt-8 mb-2">
                <a href="/projects" class="browse_more h-12 text-lg">Browse More
                    Projects</a>
            </div>
        </div>
        {{-- <div class="absolute bottom-0 right-0 flex flex-col text-gray-400 text-xs">
        <a href='https://pngtree.com/so/flat'>flat png from pngtree.com/</a>
        <a href='https://pngtree.com/freepng/mangrove-tree_6385912.html'>mangrove-tree
            from pngtree.com/</a>
    </div> --}}
    </div>
    {{-- <div class="h-screen bg-white flex items-center justify-center relative w-full" id="research">
    <div class="z-10 p-5 bg-[#3d7938]/60 rounded-md shadow-md w-3/4 md:w-1/2">
        <h2 class="text-4xl font-bold text-white mb-5">Recent Research Journals</h2>
        <div class="grid grid-cols-3 gap-4">
            @foreach ($journals as $journals)
            <div class="overflow-hidden bg-white border rounded-lg shadow-lg">
                <img class="h-48 w-full object-cover" alt="Image"
                    src="/storage/{{ $journals->journal_images[0]->image }}" alt="">
                <h3 class="mt-5 text-center text-1xl font-bold">{{ $journals->title }}</h3>
                <div class="mt-5 mb-5 flex justify-center text-white">
                    <a href="/search/journals?id={{ $journals->resjournal_id }}" class="project_learn_more">Learn
                        More</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-center mt-8 mb-2">
            <a href="/journals" class="browse_more h-12 text-lg">Browse More
                Journals</a>
        </div>
    </div>
</div> --}}
    <div class="h-screen bg-[#edeeef] flex items-center relative justify-center" id="about-us">
        <div class="md:z-10 p-5 bg-[#3d7938]/60 rounded-md shadow-md w-3/4 md:w-1/2">
            <h2 class="text-4xl font-bold text-white mb-5 text-center">About Us</h2>
            <img src="/static/img/EcoBohol.png" alt="" class="mx-auto w-72 h-72">
            <p class="text-lg text-white text-justify px-10 pb-3">EcoBohol is a web-based Mangrove Information System
                designed for guests,
                researchers, POs (People's Organizations), NGOs (Non-Governmental Organizations), and government agencies.
                It serves as a comprehensive platform that showcases the diverse mangrove species found in Bohol. Users can
                access scientific details, research journals, papers, and a heat map for locating these mangroves.
                Additionally, EcoBohol offers a managing and monitoring feature enabling POs to effectively track and record
                data related to their mangrove plantation and nursery. The system also highlights ongoing and upcoming
                mangrove projects conducted by various organizations and agencies in Bohol.</p>
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
    <script src="{{ asset('static/js/html2canvas.min.js') }}"></script>
    <script src="{{ asset('static/js/heatmap_2.js') }}"></script>
    <script src="{{ asset('static/js/saveheatmapimage.js') }}"></script>
    <script src="{{ asset('static/js/jquery-3.6.3.min.js') }}"></script>
    <script
        src="
                            https://maps.googleapis.com/maps/api/js?key=AIzaSyD3EnVFiQGl-stBLE-pR_dCBpT0H3JeDzM&callback=initMap&libraries=visualization"
        async defer></script>

@stop
