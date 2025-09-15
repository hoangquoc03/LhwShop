@extends('auth/master')
@section('title')
Đăng nhập
@endsection
@section('main-content')
<main class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
        @if ($errors->any())
        <div class="flex items-start p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l6.518 11.592c.75 1.334-.213 2.993-1.742 2.993H3.48c-1.53 0-2.492-1.66-1.742-2.993L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-2a1 1 0 01-1-1V7a1 1 0 112 0v3a1 1 0 01-1 1z" clip-rule="evenodd" />
        </svg>
        <ul class="list-none space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
        @endif
        <a href="/" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="https://flowbite-admin-dashboard.vercel.app/images/logo.svg" class="mr-4 h-11" alt="FlowBite Logo">
            <span>Lw Shop</span>  
        </a>

        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Đăng nhập</h2>

            <div class="flex justify-center gap-4 mt-4">
    <!-- GitHub -->
    <form action="/accounts/github/login/" method="post">
        <input type="hidden" name="csrfmiddlewaretoken" value="...">
        <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-gray-700">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 .297c-6.63 0-12 5.373-12 12 
                    0 5.303 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416
                    -.546-1.387-1.333-1.757-1.333-1.757-1.089-.745.083-.729.083-.729
                    1.205.084 1.84 1.236 1.84 1.236
                    1.07 1.834 2.809 1.304 3.495.997
                    .108-.776.418-1.305.76-1.604
                    -2.665-.3-5.466-1.335-5.466-5.931
                    0-1.31.47-2.381 1.235-3.221
                    -.135-.303-.54-1.523.105-3.176
                    0 0 1.005-.322 3.3 1.23a11.5 11.5 0 0 1 3.003-.404
                    c1.018.005 2.045.138 3.003.404
                    2.28-1.552 3.285-1.23 3.285-1.23
                    .645 1.653.24 2.873.12 3.176
                    .765.84 1.23 1.911 1.23 3.221
                    0 4.609-2.805 5.625-5.475 5.921
                    .435.375.81 1.096.81 2.215v3.293
                    c0 .319.21.694.825.576C20.565 22.092 24 17.592 24 12.297
                    24 5.67 18.627.297 12 .297z"/>
            </svg>
        </button>
    </form>

    <!-- Google -->
    <a href="/accounts/google/login/" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border hover:bg-gray-100">
        <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5">
    </a>

    <!-- Facebook -->
    <a href="/accounts/facebook/login/" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700">
        <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook" class="w-5 h-5">
    </a>
    </div>

            <hr>
            <!-- Normal Login Form -->
            <form action="{{ route('login.post') }}" class="mt-8 space-y-6" method="post">
                @csrf
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên đăng nhập</label>
                    <input type="text" name="username"  required class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="email@tencongty.com" id="id_username">
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mật khẩu</label>
                    <input type="password" name="password"  required class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" id="id_password">
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember" class="font-medium text-gray-900 dark:text-white">Ghi nhớ đăng nhập</label>
                    </div>
                    <a href="/users/password-reset/" class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Đăng nhập</button>

                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    <a href="{{ route('auth.register.index') }}" class="text-primary-700 hover:underline dark:text-primary-500">Đăng ký</a>
                    &nbsp; • &nbsp;
                    <a href="https://docs.appseed.us/products/rocket/django-pro/" target="_blank" class="text-primary-700 hover:underline dark:text-primary-500">Tài liệu hướng dẫn</a>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection

@section('custom.js')

@endsection