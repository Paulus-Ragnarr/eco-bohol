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
                <div class="text-center text-xl mb-2">Research Journals</div>
                <div class="flex space-x-2 border-b-2">
                    {{-- <button class="px-2 py-1 border-b-2 border-lime-600">button</button>
                <button class="px-2 py-1">button 2</button> --}}
                </div>
                <div class="flex justify-center mt-10">
                    <ul class="flex-col w-4/5 md:w-1/2 space-y-2">
                        @if (count($data) == 0)
                        @endif
                        @foreach ($data as $item)
                            <li>
                                <div class="shadow-md">
                                    {{-- {{$item}} --}}
                                    <div class="border p-1 flex justify-between">
                                        <a href="search/journals?id={{ $item->resjournal_id }}"
                                            class="text-green-800 font-semibol hover:text-green-500">{{ $item->title }}</a>
                                        <div class="bg-gray-500 text-white px-2 cursor-default p-2">{{ $item->author }}
                                        </div>
                                    </div>
                                    <div class="border py-5 px-2 text-justify">
                                        {{ strlen($item->project_publisher) > 200 ? substr($item->publisher, 0, 200) . '...' : $item->publisher }}
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
