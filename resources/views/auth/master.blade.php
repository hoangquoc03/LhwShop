<!DOCTYPE html>
<html lang="en" class="dark">
    <script src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/content/location/location.js" id="eppiocemhmnlbhjplcgkofciiegomcon"></script>
    <script src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/libs/extend-native-history-api.js"></script>
    <script src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/libs/requests.js"></script>
<head>

    @include('auth/includes/head')

</head>
<body class="bg-gray-50 dark:bg-gray-800" __processed_d9eade7f-9a9f-4d2f-b67d-b23eaf2fe2c9__="true" bis_register="W3sibWFzdGVyIjp0cnVlLCJleHRlbnNpb25JZCI6ImVwcGlvY2VtaG1ubGJoanBsY2drb2ZjaWllZ29tY29uIiwiYWRibG9ja2VyU3RhdHVzIjp7IkRJU1BMQVkiOiJkaXNhYmxlZCIsIkZBQ0VCT09LIjoiZGlzYWJsZWQiLCJUV0lUVEVSIjoiZGlzYWJsZWQiLCJSRURESVQiOiJkaXNhYmxlZCIsIlBJTlRFUkVTVCI6ImRpc2FibGVkIiwiSU5TVEFHUkFNIjoiZGlzYWJsZWQiLCJUSUtUT0siOiJkaXNhYmxlZCIsIkxJTktFRElOIjoiZGlzYWJsZWQiLCJDT05GSUciOiJkaXNhYmxlZCJ9LCJ2ZXJzaW9uIjoiMi4wLjI2Iiwic2NvcmUiOjIwMDI2fV0=">

<main class="bg-gray-50 dark:bg-gray-900">
      <div class="page-content">
        @yield('main-content')
      </div>
    {{-- <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900" bis_skin_checked="1">
        <a href="/" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="https://flowbite-admin-dashboard.vercel.app/images/logo.svg" class="mr-4 h-11" alt="FlowBite Logo">
            <span>Rocket PRO</span>  
        </a>
        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800" bis_skin_checked="1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Sign IN
            </h2>
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert" bis_skin_checked="1">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"></path>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div bis_skin_checked="1">
                            Please enter a correct username and password. Note that both fields may be case-sensitive.
                        </div>
                    </div>
                
            

            <!-- 
            <div class="flex justify-center">
                <form action="/accounts/github/login/" method="post">
                    <input type="hidden" name="csrfmiddlewaretoken" value="TDTpaYY9dkiUAluiaHS65xPI67wDT2KHmCDcHeTvSkVm6E5InA0hXyBRiRw1BL96">
                    <button type="submit" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2">
                        <svg class="h-4 mr-1 -ml-1 w-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
                        </svg>
                        Log in with Github
                    </button>
                </form>
            </div>
            -->    
            <hr>

            <form class="mt-8 space-y-6" method="post">
                <input type="hidden" name="csrfmiddlewaretoken" value="TDTpaYY9dkiUAluiaHS65xPI67wDT2KHmCDcHeTvSkVm6E5InA0hXyBRiRw1BL96">
                
                <div bis_skin_checked="1">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <input type="text" value="test" name="username" autofocus="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="name@company.com" autocapitalize="none" autocomplete="username" maxlength="150" required="" id="id_username">
                </div>

                <div bis_skin_checked="1">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" value="Pass12__" name="password" autocomplete="current-password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="••••••••" required="" id="id_password">
                </div>

                <div class="flex items-start" bis_skin_checked="1">
                    <div class="flex items-center h-5" bis_skin_checked="1">
                        <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="ml-3 text-sm" bis_skin_checked="1">
                    <label for="remember" class="font-medium text-gray-900 dark:text-white">Remember me</label>
                    </div>
                    <a href="/users/password-reset/" class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500">Lost Password?</a>
                </div>
                <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login to your account</button>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400" bis_skin_checked="1">
                    <a href="/users/signup/" class="text-primary-700 hover:underline dark:text-primary-500">Register</a>
                    &nbsp; • &nbsp; 
                    <a href="https://docs.appseed.us/products/rocket/django-pro/" target="_blank" class="text-primary-700 hover:underline dark:text-primary-500">Documentation</a>
                </div>
            </form>
        </div>
    </div> --}}
</main>
@include('auth/includes/scripts')
@yield('custom.js')
@if(session('toastify'))
<script>
    Toastify({
        text: "{{ session('toastify') }}",
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "#4CAF50"
    }).showToast();
</script>
@endif
</body>
</html>