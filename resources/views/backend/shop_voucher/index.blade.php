@extends('backend/master')
@section('title')
Danh sách phiếu giảm giá 
@endsection
@section('main-content')
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700" bis_skin_checked="1">
        <div class="w-full mb-1" bis_skin_checked="1">
            <div class="mb-4" bis_skin_checked="1">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center" bis_skin_checked="1">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Vouchers</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tất cả phiếu giảm giá</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700" bis_skin_checked="1">
                <div class="flex items-center mb-4 sm:mb-0" bis_skin_checked="1">
                <form method="GET" action="{{ route('backend.ShopVoucher.index') }}" class="sm:pr-3">
                    <label for="products-search" class="sr-only">Tìm kiếm</label>
                    <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                        <input type="text"
                            name="keyword"
                            id="products-search"
                            value="{{ request('keyword') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg 
                                    focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 
                                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Tìm theo tên sản phẩm">
                    </div>
                </form>


                    
                    <div class="flex items-center w-full sm:justify-end" bis_skin_checked="1">
                        <div class="flex pl-2 space-x-1" bis_skin_checked="1">
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" id= "btnBatchDelete" data-batch-delete-url="{{ route('backend.ShopVoucher.batchDelete') }}"
                                class="flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Xóa đã chọn
                            </a>
                            
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <button id="createProductButton" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800" type="button" data-drawer-target="drawer-create-product-default" data-drawer-show="drawer-create-product-default" aria-controls="drawer-create-product-default" data-drawer-placement="right">
                    Thêm  giảm giá
                </button>
            </div>
        </div>
    </div>
    <div class="flex flex-col" bis_skin_checked="1">
        <div class="overflow-x-auto" bis_skin_checked="1">
            <div class="inline-block min-w-full align-middle" bis_skin_checked="1">
                <div class="overflow-hidden shadow" bis_skin_checked="1">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                            <input type="checkbox"  id="checkAll" value="1"   class="checkbox-item w-4 h-4 border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                            {{-- <label for="checkbox-{{ $item->id }}" class="sr-only">checkbox</label> --}}
                                    </div>
                                    
                                </th>
                
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Mã phiếu giảm giá
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Tên phiếu giảm giá                                                                                                     
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Mô tả                                                                                                    
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Sử dụng                                                                                                  
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Giá trị giảm                                                                                                 
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ngày bắt đầu                                                                                                    
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ngày kết thúc                                                                                                     
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hoạt Động
                                </th>
                            </tr>
                        </thead>
                        <tbody id="voucher-table-body" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($dsShopVouchers as $index => $item)
                                <tr data-search="{{ Str::lower($item->voucher_name) }}" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <!-- Checkbox chọn nhiều -->
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="listSelectedIds[]" id="listSelectedIds_{{ $index + 1 }}" value="{{ $item->id }}" class="checkbox-item w-4 h-4 border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                        </div>
                                    </td>

                                    <!-- Mã voucher -->
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        {{ $item->voucher_code }}
                                    </td>

                                    <!-- Tên voucher -->
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        {{ $item->voucher_name }}
                                    </td>

                                    <!-- Mô tả -->
                                    <td class=" p-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $item->description }}
                                    </td>
                                    <td class="p-4 text-center text-gray-900 dark:text-white">
                                        {{ $item->uses }}/{{ $item->max_uses }} (Mỗi user: {{ $item->max_uses_user }})
                                    </td>

                                    <!-- Loại giảm giá -->
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        @if($item->is_fixed)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 border border-green-300 rounded-full shadow-sm dark:bg-green-900 dark:text-green-300 dark:border-green-700">
                                                {{ number_format($item->discount_amount, 0, ',', '.') }}₫
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-semibold text-orange-800 bg-orange-100 border border-orange-300 rounded-full shadow-sm dark:bg-orange-900 dark:text-orange-300 dark:border-orange-700">
                                                {{ $item->discount_amount }}%
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Giới hạn sử dụng -->
                                    

                                    <!-- Ngày bắt đầu -->
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y H:i:s') }}
                                    </td>

                                    <!-- Ngày kết thúc -->
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y H:i:s') }}
                                    </td>

                                    <!-- Nút hành động -->
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <!-- Cập nhật -->
                                        <button type="button"
                                            data-drawer-target="drawer-update-voucher-{{ $item->id }}"
                                            data-drawer-show="drawer-update-voucher-{{ $item->id }}"
                                            aria-controls="drawer-update-voucher-{{ $item->id }}"
                                            data-drawer-placement="right"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                            data-voucher_code="{{ $item->voucher_code }}"
                                            data-voucher_name="{{ $item->voucher_name }}"
                                            data-description="{{ $item->description }}"
                                            data-uses="{{ $item->uses }}"
                                            data-max_uses="{{ $item->max_uses }}"
                                            data-max_uses_user="{{ $item->max_uses_user }}"
                                            data-type="{{ $item->type }}"
                                            data-discount_amount="{{ $item->discount_amount }}"
                                            data-is_fixed="{{ $item->is_fixed }}"
                                            data-start_date="{{ $item->start_date }}"
                                            data-end_date="{{ $item->end_date }}"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Cập nhật
                                        </button>

                                        <!-- Xóa -->
                                        <button type="button"
                                            class="btn-delete inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                            data-id="{{ $item->id }}"
                                            data-delete-url="{{ route('backend.ShopVoucher.destroy', ['id' => $item->id]) }}"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @foreach ($dsShopVouchers as $item)
                        <div id="drawer-update-voucher-{{ $item->id }}" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label-{{ $item->id }}" bis_skin_checked="1" aria-hidden="true">
                            <h5 id="drawer-label-{{ $item->id }}" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                Cập nhật giảm giá sản phẩm - {{ $item->id }}</h5>
                            <button type="button" data-drawer-dismiss="drawer-update-product-{{ $item->id }}" aria-controls="drawer-update-product-{{ $item->id }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close menu</span>
                            </button>
                            <form action="{{ route('backend.ShopVoucher.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">

                                    <div>
                                        <label for="voucher_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mã phiếu giảm giá</label>
                                        <input value="{{ $item->voucher_code }}" type="text" name="voucher_code" id="voucher_code"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            placeholder="Nhập mã giảm giá" required>
                                    </div>
                                    {{-- Tên giảm giá --}}
                                    <div>
                                        <label for="voucher_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên giảm giá</label>
                                        <input value="{{ $item->voucher_name }}" type="text" name="voucher_name" id="voucher_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            placeholder="Nhập tên giảm giá" required>
                                    </div>

                                    <div>
                                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả</label>
                                        <input value="{{ $item->description }}" type="text" name="description" id="description"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            placeholder="Mô tả" required>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Sử dụng
                                        </label>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <!-- Số lần đã sử dụng -->
                                            <input value="{{ $item->uses }}" type="number" id="uses" name="uses" min="0"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                placeholder="Đã sử dụng" required>

                                            <!-- Số lần tối đa -->
                                            <input value="{{ $item->max_uses }}" type="number" id="max_uses" name="max_uses" min="1"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                placeholder="Tối đa" required>

                                            <!-- Mỗi user -->
                                            <input value="{{ $item->max_uses_user }}" type="number" id="max_uses_user" name="max_uses_user" min="1"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                placeholder="Mỗi user" required>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Ví dụ: 0/100 (Mỗi người dùng: 1)
                                        </p>
                                    </div>



                                    {{-- Giá trị giảm --}}
                                    <div>
                                        <label for="discount_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá trị giảm</label>
                                        <input value="{{ $item->discount_amount }}" type="number" step="0.01" min="0" name="discount_amount" id="discount_amount"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            placeholder="Nhập số tiền hoặc %" required>
                                    </div>

                                    {{-- Loại giảm giá --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kiểu giảm giá</label>
                                        <div class="flex items-center space-x-4">
                                            <label class="flex items-center">
                                                <input type="radio" name="is_fixed" value="1" {{ $item->is_fixed ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:border-gray-600">
                                                <span class="ml-2 text-sm text-gray-900 dark:text-white">Giảm số tiền cố định (₫)</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="is_fixed" value="0" {{ !$item->is_fixed ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:border-gray-600">
                                                <span class="ml-2 text-sm text-gray-900 dark:text-white">Giảm theo phần trăm (%)</span>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Ngày bắt đầu --}}
                                    <div>
                                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ngày bắt đầu</label>
                                        <input value="{{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}" type="date" name="start_date" id="start_date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            required>
                                    </div>

                                    {{-- Ngày kết thúc --}}
                                    <div>
                                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ngày kết thúc</label>
                                        <input value="{{ \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}" type="date" name="end_date" id="end_date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            required>
                                    </div>

                                </div>

                                <!-- Nút hành động -->
                                <div class="flex justify-center w-full pb-4 mt-4 space-x-4 sm:px-4">
                                    <button type="submit"
                                        class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Cập nhật
                                    </button>
                                    <button type="button"
                                        class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Hủy
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endforeach 
                    </table>
                    @php
                        $currentPage = $dsShopVouchers->currentPage();
                        $prevUrl = $dsShopVouchers->previousPageUrl()
                            ? request()->fullUrlWithQuery(['page' => $currentPage - 1])
                            : null;

                        $nextUrl = $dsShopVouchers->nextPageUrl()
                            ? request()->fullUrlWithQuery(['page' => $currentPage + 1])
                            : null;
                    @endphp

                    <div class="sticky bottom-0 right-0 w-full p-4 bg-white border-t border-gray-200 sm:flex sm:items-center sm:justify-between dark:bg-gray-800 dark:border-gray-700">

                        <!-- Bên trái: Nút điều hướng -->
                        <div class="flex items-center space-x-3 mb-4 sm:mb-0">
                            <!-- Nút Trước -->
                            <a href="{{ $prevUrl ?? '#' }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg 
                                    hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 
                                    {{ $dsShopVouchers->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Trước
                            </a>

                            <!-- Nút Tiếp -->
                            <a href="{{ $nextUrl ?? '#' }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg 
                                    hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 
                                    {{ !$dsShopVouchers->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
                                Tiếp
                                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>

                        <!-- Bên phải: Thông tin hiển thị -->
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Hiển thị 
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $dsShopVouchers->firstItem() ?? 0 }} - {{ $dsShopVouchers->lastItem() ?? 0 }}
                                </span> 
                                trên tổng 
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $dsShopVouchers->total() }}
                                </span> mục
                            </span>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Add Product Drawer -->
<div id="drawer-create-product-default"
    class="fixed top-0 right-0 z-40 w-full max-w-xs h-screen overflow-y-auto bg-gray-100 dark:bg-gray-900 transition-transform translate-x-full p-4"
    tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">

    <!-- Tiêu đề -->
    <h5 id="drawer-label"
        class="mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400 flex items-center">
        Phiếu giảm giá mới
    </h5>

    <!-- Nút đóng -->
    <button type="button" data-drawer-dismiss="drawer-create-product-default"
        aria-controls="drawer-create-product-default"
        class="absolute top-2.5 right-2.5 p-1.5 rounded-lg text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Đóng</span>
    </button>

    <!-- FORM -->
    <form id="frmCreateDiscount" name="frmCreateDiscount"
        action="{{ route('backend.ShopVoucher.store') }}"
        class="flex flex-col gap-4 p-6 bg-gray-100 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
        enctype="multipart/form-data" method="POST">
        @csrf
        <div>
            <label for="voucher_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Mã giảm giá
            </label>
            <input type="text" id="voucher_code" name="voucher_code"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Nhập mã giảm giá" required>
        </div>

        <!-- Tên giảm giá -->
        <div>
            <label for="voucher_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Tên giảm giá
            </label>
            <input type="text" id="voucher_name" name="voucher_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Nhập tên giảm giá" required>
        </div>
         <div>
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Mô tả
            </label>
            <input type="text" id="description" name="description"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Mô tả giảm giá" required>
        </div>
        <!-- Sử dụng -->
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Sử dụng
            </label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Số lần đã sử dụng -->
                <input type="number" id="uses" name="uses" min="0"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Đã sử dụng" required>

                <!-- Số lần tối đa -->
                <input type="number" id="max_uses" name="max_uses" min="1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Tối đa" required>

                <!-- Mỗi user -->
                <input type="number" id="max_uses_user" name="max_uses_user" min="1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Mỗi user" required>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Ví dụ: 0/100 (Mỗi người dùng: 1)
            </p>
        </div>


        <!-- Số tiền hoặc % giảm -->
        <div>
            <label for="discount_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Mức giảm
            </label>
            <input type="number" id="discount_amount" name="discount_amount" step="0.01" min="0"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Nhập số tiền hoặc %" required>
        </div>

        <!-- Loại giảm giá -->
        <div>
            <label for="is_fixed" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Loại giảm giá
            </label>
            <select id="is_fixed" name="is_fixed"
                class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
                required>
                <option value="1">Giảm cố định (VNĐ)</option>
                <option value="0">Giảm theo %</option>
            </select>
        </div>

        <!-- Ngày bắt đầu -->
        <div>
            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Ngày bắt đầu
            </label>
            <input type="date" id="start_date" name="start_date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                required>
        </div>

        <!-- Ngày kết thúc -->
        <div>
            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Ngày kết thúc
            </label>
            <input type="date" id="end_date" name="end_date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                required>
        </div>


        <!-- Nút hành động -->
        <div class="flex justify-center w-full pt-4 space-x-4">
            <button type="submit"
                class="text-white w-full md:w-1/2 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Thêm giảm giá
            </button>
            <button type="button" data-drawer-dismiss="drawer-create-product-discount"
                class="inline-flex w-full md:w-1/2 justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Hủy
            </button>
        </div>
    </form>
</div>
@if (session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: "#16a34a",
            close: true
        }).showToast();
    </script>
@endif

@endsection
<style>
    .input-style {
        @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500;
    }
    .submit-button {
        @apply text-white w-full justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800;
    }
    .cancel-button {
        @apply inline-flex w-full justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600;
    }
    .dropzone {
        border: 2px dashed #cbd5e1; /* Tailwind: slate-300 */
        background-color: #f8fafc; /* Tailwind: slate-50 */
        border-radius: 0.5rem; /* rounded-lg */
        padding: 2rem;
        text-align: center;
        color: #64748b; /* slate-500 */
        transition: background-color 0.3s ease;
    }

    .dropzone:hover {
        background-color: #f1f5f9; /* slate-100 */
    }
</style>
@section('custom.js')
<script>
  $(document).ready(function () {
    $('.btn-delete').on('click', function (e) {
      e.preventDefault(); // Ngăn trình duyệt chuyển trang (tránh GET)

      const id = $(this).data('id');
      const deleteUrl = $(this).data('delete-url');

      Swal.fire({
        title: "Bạn có chắc chắn?",
        text: "Hành động này sẽ xóa dữ liệu!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: deleteUrl,
            type: 'POST',
            data: {
              _method: 'DELETE',
              _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
              Swal.fire("Đã xóa!", "Dữ liệu đã bị xóa.", "success").then(() => {
                location.reload();
              });
            },
            error: function (xhr) {
              console.error(xhr);
              Swal.fire("Lỗi", "Không thể xóa. Vui lòng thử lại.", "error");
            }
          });
        }
      });
    });
  });
  $(function () {
    $('#frmCreate').validate({
        rules: {
            product_id: {
                required: true
            },
            discount_name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            discount_amount: {
                required: true,
                number: true,
                min: 0
            },
            is_fixed: {
                required: true
            },
            start_date: {
                required: true,
                date: true
            },
            end_date: {
                required: true,
                date: true
            }
        },
        messages: {
            product_id: {
                required: 'Vui lòng chọn sản phẩm.'
            },
            discount_name: {
                required: 'Vui lòng nhập tên giảm giá.',
                minlength: 'Tên giảm giá phải có ít nhất 3 ký tự.',
                maxlength: 'Tên giảm giá không được quá 100 ký tự.'
            },
            discount_amount: {
                required: 'Vui lòng nhập mức giảm.',
                number: 'Mức giảm phải là số.',
                min: 'Mức giảm không được nhỏ hơn 0.'
            },
            is_fixed: {
                required: 'Vui lòng chọn loại giảm giá.'
            },
            start_date: {
                required: 'Vui lòng chọn ngày bắt đầu.',
                date: 'Ngày bắt đầu không hợp lệ.'
            },
            end_date: {
                required: 'Vui lòng chọn ngày kết thúc.',
                date: 'Ngày kết thúc không hợp lệ.'
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("text-red-600 text-sm mt-1 block");
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass("border-red-600 ring-red-600 ring-1");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-600 ring-red-600 ring-1");
        }
    });
  });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById("create-image");
        const img = document.getElementById("create-preview-img");

        if (!fileInput || !img) return;

        fileInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith("image/")) {
                alert("File phải là hình ảnh!");
                fileInput.value = '';
                img.src = img.dataset.default;
                return;
            }

            const reader = new FileReader();
            reader.onload = function (ev) {
                img.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @foreach ($dsShopVouchers as $item)
            const fileInput{{ $item->id }} = document.getElementById("update-image-{{ $item->id }}");
            const img{{ $item->id }} = document.getElementById("update-preview-img-{{ $item->id }}");

            if (fileInput{{ $item->id }} && img{{ $item->id }}) {
                fileInput{{ $item->id }}.addEventListener("change", function (e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    if (!file.type.startsWith("image/")) {
                        alert("File phải là hình ảnh!");
                        fileInput{{ $item->id }}.value = '';
                        img{{ $item->id }}.src = img{{ $item->id }}.dataset.default;
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (ev) {
                        img{{ $item->id }}.src = ev.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }
        @endforeach
    });
</script>

<script>
    Dropzone.autoDiscover = false;

    const myDropzone = new Dropzone("#frmCreate", {
        url: "{{ route('backend.ShopVoucher.store') }}", // ép dùng route POST
        method: "post", 
        paramName: "image", // name cho từng file
        uploadMultiple: true,
        parallelUploads: 10,
        maxFiles: 10,
        maxFilesize: 5, // MB
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        dictDefaultMessage: "Kéo thả ảnh vào đây hoặc click để chọn",
        dictMaxFilesExceeded: "Bạn chỉ được tải lên tối đa 10 ảnh.",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        init: function () {
            this.on("successmultiple", function (files, response) {
                Toastify({
                    text: response.message || "Tải ảnh thành công!",
                    duration: 3000,
                    gravity: "top", // top hoặc bottom
                    position: "right", // left, center hoặc right
                    backgroundColor: "#16a34a", // màu xanh thành công
                    close: true,
                    onClick: function () {
                        window.location.href = "{{ route('backend.ShopVoucher.index') }}";
                    }
                }).showToast();

                // setTimeout(() => {
                //     window.location.href = "{{ route('backend.ProductImg.index') }}";
                // }, 2000); // đợi 2 giây để toast hiển thị
            });

            this.on("errormultiple", function (files, response) {
                Toastify({
                    text: "Đã xảy ra lỗi khi tải ảnh.",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc2626", // đỏ lỗi
                    close: true
                }).showToast();
                console.error(response);
            }); 
        }
    });
</script>
<script>
    $(function () {
        $('#checkAll').on('change',function(){
            var isCheckedAll = $(this).is(":checked");

            var listSelectedElements = $("input[type='checkbox'][name='listSelectedIds[]']");
            $.each(listSelectedElements, function (index, ele) {
                $(ele).attr('checked',isCheckedAll );
            });

        });
        $('#btnBatchDelete').on('click', function (e) {
            e.preventDefault();

            var batchDeleteUrl = $(this).data("batch-delete-url");
            var btnBatchDelete = $(this);
            var listSelectedIds = [];

            var listSelectedElements = $("input[type='checkbox'][name='listSelectedIds[]']:checked");
            $.each(listSelectedElements, function (index, ele) {
                var id = $(ele).val();
                listSelectedIds.push(id);
            });

            if (listSelectedIds.length === 0) {
                Swal.fire("Chưa chọn mục nào!", "Vui lòng chọn ít nhất một mục để xóa.", "warning");
                return;
            }

            Swal.fire({
                title: "Bạn có chắc chắn?",
                text: "Hành động này sẽ xóa dữ liệu!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    var postData = {
                        '_token': '{{ csrf_token() }}',
                        'listSelectedIds': listSelectedIds
                    };

                    $.post(batchDeleteUrl, postData)
                        .done(function (response) {
                            var list_deleted_ids = response.list_deleted_ids;
                            Swal.fire({
                                title: "Bạn có chắc chắn?",
                                text: response.message,
                                icon: "info",
                            });
                            $.each(list_deleted_ids,function(index,id){
                                var selector ="input[type='checkbox'][name ='listSelectedIds[]'][value="+id+"]";
                                $(selector).parent().parent().parent().remove();
                            });
                        })
                        .fail(function (e) {
                            Swal.fire("Lỗi", "Xóa thất bại.", "error");
                        });
                }
            });
        });
    });
    document.getElementById('products-search').addEventListener('input', function () {
        clearTimeout(this._timeout);
        this._timeout = setTimeout(() => {
            this.form.submit(); // Gửi form lên server để lọc toàn bộ kết quả
        }, 500); // chờ người dùng gõ xong 500ms rồi mới gửi
    });
</script>

@endsection