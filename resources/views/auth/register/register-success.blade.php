@extends('auth/master')

@section('title')
Đăng kí thành công
@endsection

@section('main-content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-800 px-4">
    <div class="max-w-2xl w-full bg-white p-10 rounded-2xl shadow-lg dark:bg-gray-800 transition-all">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414L9 13.414l4.707-4.707z" />
            </svg>
            <h1 class="text-3xl font-extrabold text-green-600 dark:text-green-400">Đăng ký thành công!</h1>
        </div>

        <p class="text-lg text-gray-800 dark:text-gray-200 mb-2">
            Xin chào <span class="font-semibold">{{ $newUser->first_name }} {{ $newUser->last_name }}</span>,
        </p>

        <p class="text-base text-gray-600 dark:text-gray-400 mb-4">
            Tài khoản của bạn đã được tạo thành công 🎉<br>
            Vui lòng kiểm tra email: 
            <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $newUser->email }}</span>
            và nhấn vào liên kết kích hoạt tài khoản.
        </p>

        <div class="flex items-start gap-3 bg-blue-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <svg class="w-5 h-5 text-blue-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v0.5l-8 5-8-5V5z" />
                <path d="M2 8.5v6A2.5 2.5 0 004.5 17h11a2.5 2.5 0 002.5-2.5v-6l-8 5-8-5z" />
            </svg>
            <span class="text-sm text-gray-700 dark:text-gray-300">
                Nếu không thấy email, hãy kiểm tra hộp thư <strong>Spam / Quảng cáo</strong>.
            </span>
        </div>

        <a href="https://mail.google.com" target="_blank"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
            📬 Mở Gmail
        </a>

@if ($newUser && $newUser->status == 1)
    <a href="{{ route('home') }}"
       class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg 
              hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto 
              dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
       Quay về trang chủ
    </a>
@else
    <button disabled
       class="w-full px-5 py-3 text-base font-medium text-center text-white bg-gray-400 rounded-lg cursor-not-allowed sm:w-auto">
       Quay về trang chủ (Chưa kích hoạt)
    </button>
@endif


    </div>
</div>
@endsection

@section('custom.js')
@endsection
