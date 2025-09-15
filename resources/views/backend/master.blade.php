<!DOCTYPE html>
<html lang="vi">
    <head>
        @include('backend/includes/head')
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        @toastifyCss
    </head>
    <body
        class="bg-gray-50 dark:bg-gray-800"
        __processed_acdd207a-2f5d-4f77-8fe2-cfa3e9d5090e__="true"
        bis_register="W3sibWFzdGVyIjp0cnVlLCJleHRlbnNpb25JZCI6ImVwcGlvY2VtaG1ubGJoanBsY2drb2ZjaWllZ29tY29uIiwiYWRibG9ja2VyU3RhdHVzIjp7IkRJU1BMQVkiOiJkaXNhYmxlZCIsIkZBQ0VCT09LIjoiZGlzYWJsZWQiLCJUV0lUVEVSIjoiZGlzYWJsZWQiLCJSRURESVQiOiJkaXNhYmxlZCIsIlBJTlRFUkVTVCI6ImRpc2FibGVkIiwiSU5TVEFHUkFNIjoiZGlzYWJsZWQiLCJUSUtUT0siOiJkaXNhYmxlZCIsIkxJTktFRElOIjoiZGlzYWJsZWQiLCJDT05GSUciOiJkaXNhYmxlZCJ9LCJ2ZXJzaW9uIjoiMi4wLjI2Iiwic2NvcmUiOjIwMDI2fV0="
    >
        @include('backend/includes/navigation')

        <div
            class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900"
            bis_skin_checked="1"
        >
            @include('backend/includes/sidebar')

            <div
                class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90"
                id="sidebarBackdrop"
                bis_skin_checked="1"
            ></div>

            <div
                id="main-content"
                class=" flex flex-col min-h-screen w-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900"
                bis_skin_checked="1"
            >
                <main class="px-4 py-6 mt-5 mb-12">

                    @include('backend/includes/error_message')
                    @yield('main-content')
                </main>
                    <div class = "bg-white dark:bg-gray-800 shadow px-4 py-3">@include('backend/includes/footer')</div>
            </div>
        </div>

        <script
            async=""
            defer=""
            src="https://buttons.github.io/buttons.js"
        ></script>
        <!-- <script src="/static/dist/main.bundle.js"></script> -->
        <svg
            id="SvgjsSvg1006"
            width="2"
            height="0"
            xmlns="http://www.w3.org/2000/svg"
            version="1.1"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            xmlns:svgjs="http://svgjs.dev"
            style="
                overflow: hidden;
                top: -100%;
                left: -100%;
                position: absolute;
                opacity: 0;
            "
        >
            <defs id="SvgjsDefs1007"></defs>
            <polyline id="SvgjsPolyline1008" points="0,0"></polyline>
            <path id="SvgjsPath1009" d="M0 0 "></path>
        </svg>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>

        <div
            class="datepicker hidden datepicker-dropdown dropdown absolute top-0 left-0 z-50 pt-2 datepicker-orient-top datepicker-orient-left"
            bis_skin_checked="1"
            style="top: 2170px; left: 33px">
            <div
                class="datepicker-picker inline-block rounded-lg bg-white dark:bg-gray-700 shadow-lg p-4"
                bis_skin_checked="1"
            >
                <div class="datepicker-header" bis_skin_checked="1">
                    <div
                        class="datepicker-title bg-white dark:bg-gray-700 dark:text-white px-2 py-3 text-center font-semibold"
                        bis_skin_checked="1"
                        style="display: none"
                    ></div>
                    <div
                        class="datepicker-controls flex justify-between mb-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 prev-btn"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg></button
                        ><button
                            type="button"
                            class="text-sm rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 font-semibold py-2.5 px-5 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-200 view-switch"
                        >
                            July 2025</button
                        ><button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 next-btn"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="datepicker-main p-1" bis_skin_checked="1">
                    <div class="datepicker-view flex" bis_skin_checked="1">
                        <div class="days" bis_skin_checked="1">
                            <div
                                class="days-of-week grid grid-cols-7 mb-1"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Su</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Mo</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Tu</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >We</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Th</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Fr</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Sa</span
                                >
                            </div>
                            <div
                                class="datepicker-grid w-64 grid grid-cols-7"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751130000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751216400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751302800000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751389200000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751475600000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751562000000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751648400000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751734800000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751821200000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751907600000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751994000000"
                                    >9</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752080400000"
                                    >10</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752166800000"
                                    >11</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752253200000"
                                    >12</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752339600000"
                                    >13</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752426000000"
                                    >14</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752512400000"
                                    >15</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752598800000"
                                    >16</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752685200000"
                                    >17</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day focused"
                                    data-date="1752771600000"
                                    >18</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752858000000"
                                    >19</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752944400000"
                                    >20</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753030800000"
                                    >21</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753117200000"
                                    >22</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753203600000"
                                    >23</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753290000000"
                                    >24</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753376400000"
                                    >25</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753462800000"
                                    >26</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753549200000"
                                    >27</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753635600000"
                                    >28</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753722000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753808400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753894800000"
                                    >31</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1753981200000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754067600000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754154000000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754240400000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754326800000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754413200000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754499600000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754586000000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754672400000"
                                    >9</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="datepicker-footer" bis_skin_checked="1">
                    <div
                        class="datepicker-controls flex space-x-2 mt-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="button today-btn text-white bg-blue-700 dark:bg-blue-600 hover:bg-blue-800 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Today</button
                        ><button
                            type="button"
                            class="button clear-btn text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="datepicker hidden datepicker-dropdown dropdown absolute top-0 left-0 z-50 pt-2 datepicker-orient-top datepicker-orient-left"
            bis_skin_checked="1"
            style="top: 2170px; left: 209.5px">
            <div
                class="datepicker-picker inline-block rounded-lg bg-white dark:bg-gray-700 shadow-lg p-4"
                bis_skin_checked="1"
            >
                <div class="datepicker-header" bis_skin_checked="1">
                    <div
                        class="datepicker-title bg-white dark:bg-gray-700 dark:text-white px-2 py-3 text-center font-semibold"
                        bis_skin_checked="1"
                        style="display: none"
                    ></div>
                    <div
                        class="datepicker-controls flex justify-between mb-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 prev-btn"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg></button
                        ><button
                            type="button"
                            class="text-sm rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 font-semibold py-2.5 px-5 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-200 view-switch"
                        >
                            July 2025</button
                        ><button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 next-btn"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="datepicker-main p-1" bis_skin_checked="1">
                    <div class="datepicker-view flex" bis_skin_checked="1">
                        <div class="days" bis_skin_checked="1">
                            <div
                                class="days-of-week grid grid-cols-7 mb-1"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Su</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Mo</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Tu</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >We</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Th</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Fr</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Sa</span
                                >
                            </div>
                            <div
                                class="datepicker-grid w-64 grid grid-cols-7"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751130000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751216400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751302800000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751389200000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751475600000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751562000000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751648400000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751734800000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751821200000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751907600000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751994000000"
                                    >9</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752080400000"
                                    >10</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752166800000"
                                    >11</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752253200000"
                                    >12</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752339600000"
                                    >13</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752426000000"
                                    >14</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752512400000"
                                    >15</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752598800000"
                                    >16</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752685200000"
                                    >17</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day focused"
                                    data-date="1752771600000"
                                    >18</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752858000000"
                                    >19</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752944400000"
                                    >20</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753030800000"
                                    >21</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753117200000"
                                    >22</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753203600000"
                                    >23</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753290000000"
                                    >24</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753376400000"
                                    >25</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753462800000"
                                    >26</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753549200000"
                                    >27</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753635600000"
                                    >28</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753722000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753808400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753894800000"
                                    >31</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1753981200000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754067600000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754154000000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754240400000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754326800000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754413200000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754499600000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754586000000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754672400000"
                                    >9</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="datepicker-footer" bis_skin_checked="1">
                    <div
                        class="datepicker-controls flex space-x-2 mt-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="button today-btn text-white bg-blue-700 dark:bg-blue-600 hover:bg-blue-800 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Today</button
                        ><button
                            type="button"
                            class="button clear-btn text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="datepicker hidden datepicker-dropdown dropdown absolute top-0 left-0 z-50 pt-2 datepicker-orient-bottom datepicker-orient-left"
            bis_skin_checked="1"
            style="top: 2212px; left: 33px">
            <div
                class="datepicker-picker inline-block rounded-lg bg-white dark:bg-gray-700 shadow-lg p-4"
                bis_skin_checked="1"
            >
                <div class="datepicker-header" bis_skin_checked="1">
                    <div
                        class="datepicker-title bg-white dark:bg-gray-700 dark:text-white px-2 py-3 text-center font-semibold"
                        bis_skin_checked="1"
                        style="display: none"
                    ></div>
                    <div
                        class="datepicker-controls flex justify-between mb-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 prev-btn"
                        >
                            <svg
                                class="w-4 h-4 rtl:rotate-180 text-gray-800 dark:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 5H1m0 0 4 4M1 5l4-4"
                                ></path>
                            </svg></button
                        ><button
                            type="button"
                            class="text-sm rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 font-semibold py-2.5 px-5 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-200 view-switch"
                        >
                            July 2025</button
                        ><button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 next-btn"
                        >
                            <svg
                                class="w-4 h-4 rtl:rotate-180 text-gray-800 dark:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="datepicker-main p-1" bis_skin_checked="1">
                    <div class="datepicker-view flex" bis_skin_checked="1">
                        <div class="days" bis_skin_checked="1">
                            <div
                                class="days-of-week grid grid-cols-7 mb-1"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Su</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Mo</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Tu</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >We</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Th</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Fr</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Sa</span
                                >
                            </div>
                            <div
                                class="datepicker-grid w-64 grid grid-cols-7"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751130000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751216400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751302800000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751389200000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751475600000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751562000000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751648400000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751734800000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751821200000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751907600000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751994000000"
                                    >9</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752080400000"
                                    >10</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752166800000"
                                    >11</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752253200000"
                                    >12</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752339600000"
                                    >13</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752426000000"
                                    >14</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752512400000"
                                    >15</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752598800000"
                                    >16</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752685200000"
                                    >17</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day focused"
                                    data-date="1752771600000"
                                    >18</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752858000000"
                                    >19</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752944400000"
                                    >20</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753030800000"
                                    >21</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753117200000"
                                    >22</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753203600000"
                                    >23</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753290000000"
                                    >24</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753376400000"
                                    >25</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753462800000"
                                    >26</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753549200000"
                                    >27</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753635600000"
                                    >28</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753722000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753808400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753894800000"
                                    >31</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1753981200000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754067600000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754154000000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754240400000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754326800000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754413200000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754499600000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754586000000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754672400000"
                                    >9</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="datepicker-footer" bis_skin_checked="1">
                    <div
                        class="datepicker-controls flex space-x-2 rtl:space-x-reverse mt-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="button today-btn text-white bg-blue-700 !bg-primary-700 dark:bg-blue-600 dark:!bg-primary-600 hover:bg-blue-800 hover:!bg-primary-800 dark:hover:bg-blue-700 dark:hover:!bg-primary-700 focus:ring-4 focus:ring-blue-300 focus:!ring-primary-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Today</button
                        ><button
                            type="button"
                            class="button clear-btn text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:ring-blue-300 focus:!ring-primary-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="datepicker hidden datepicker-dropdown dropdown absolute top-0 left-0 z-50 pt-2 datepicker-orient-bottom datepicker-orient-left"
            bis_skin_checked="1"
            style="top: 2212px; left: 209.5px">
            <div
                class="datepicker-picker inline-block rounded-lg bg-white dark:bg-gray-700 shadow-lg p-4"
                bis_skin_checked="1"
            >
                <div class="datepicker-header" bis_skin_checked="1">
                    <div
                        class="datepicker-title bg-white dark:bg-gray-700 dark:text-white px-2 py-3 text-center font-semibold"
                        bis_skin_checked="1"
                        style="display: none"
                    ></div>
                    <div
                        class="datepicker-controls flex justify-between mb-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 prev-btn"
                        >
                            <svg
                                class="w-4 h-4 rtl:rotate-180 text-gray-800 dark:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 5H1m0 0 4 4M1 5l4-4"
                                ></path>
                            </svg></button
                        ><button
                            type="button"
                            class="text-sm rounded-lg text-gray-900 dark:text-white bg-white dark:bg-gray-700 font-semibold py-2.5 px-5 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-200 view-switch"
                        >
                            July 2025</button
                        ><button
                            type="button"
                            class="bg-white dark:bg-gray-700 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white text-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-gray-200 next-btn"
                        >
                            <svg
                                class="w-4 h-4 rtl:rotate-180 text-gray-800 dark:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="datepicker-main p-1" bis_skin_checked="1">
                    <div class="datepicker-view flex" bis_skin_checked="1">
                        <div class="days" bis_skin_checked="1">
                            <div
                                class="days-of-week grid grid-cols-7 mb-1"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Su</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Mo</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Tu</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >We</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Th</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Fr</span
                                ><span
                                    class="dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"
                                    >Sa</span
                                >
                            </div>
                            <div
                                class="datepicker-grid w-64 grid grid-cols-7"
                                bis_skin_checked="1"
                            >
                                <span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751130000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day prev text-gray-500"
                                    data-date="1751216400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751302800000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751389200000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751475600000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751562000000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751648400000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751734800000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751821200000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751907600000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1751994000000"
                                    >9</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752080400000"
                                    >10</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752166800000"
                                    >11</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752253200000"
                                    >12</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752339600000"
                                    >13</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752426000000"
                                    >14</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752512400000"
                                    >15</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752598800000"
                                    >16</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752685200000"
                                    >17</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day focused"
                                    data-date="1752771600000"
                                    >18</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752858000000"
                                    >19</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1752944400000"
                                    >20</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753030800000"
                                    >21</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753117200000"
                                    >22</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753203600000"
                                    >23</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753290000000"
                                    >24</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753376400000"
                                    >25</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753462800000"
                                    >26</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753549200000"
                                    >27</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753635600000"
                                    >28</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753722000000"
                                    >29</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753808400000"
                                    >30</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day"
                                    data-date="1753894800000"
                                    >31</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1753981200000"
                                    >1</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754067600000"
                                    >2</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754154000000"
                                    >3</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754240400000"
                                    >4</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754326800000"
                                    >5</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754413200000"
                                    >6</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754499600000"
                                    >7</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754586000000"
                                    >8</span
                                ><span
                                    class="datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm day next text-gray-500"
                                    data-date="1754672400000"
                                    >9</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="datepicker-footer" bis_skin_checked="1">
                    <div
                        class="datepicker-controls flex space-x-2 rtl:space-x-reverse mt-2"
                        bis_skin_checked="1"
                    >
                        <button
                            type="button"
                            class="button today-btn text-white bg-blue-700 !bg-primary-700 dark:bg-blue-600 dark:!bg-primary-600 hover:bg-blue-800 hover:!bg-primary-800 dark:hover:bg-blue-700 dark:hover:!bg-primary-700 focus:ring-4 focus:ring-blue-300 focus:!ring-primary-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Today</button
                        ><button
                            type="button"
                            class="button clear-btn text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:ring-blue-300 focus:!ring-primary-300 font-medium rounded-lg text-sm px-5 py-2 text-center w-1/2"
                            style="display: none"
                        >
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    @toastifyJs
   @include('backend/includes/scripts')
    <!-- <script src="/public/static/assets/dark-mode.js"></script> -->
    @yield('custom.js')
    {{-- <script>
    Toastify({
        text: "{{ session('toastify') }}",
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "#4CAF50"
    }).showToast();
</script> --}}

</html>
