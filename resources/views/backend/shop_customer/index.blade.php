@extends('backend/master')
@section('title')
Danh sách Khách hàng
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Customers</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tất cả khách hàng</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700" bis_skin_checked="1">
                <div class="flex items-center mb-4 sm:mb-0" bis_skin_checked="1">
                <form method="GET" action="{{ route('backend.ShopCustomer.index') }}" class="sm:pr-3">
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
                            <a href="#" id= "btnBatchDelete" data-batch-delete-url="{{ route('backend.ShopCustomer.batchDelete') }}"
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
                    Thêm khách hàng
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
                                    Tên
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    thông tin                                                                                                   
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Trạng thái                                                                                                   
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hoạt Động
                                </th>
                            </tr>
                        </thead>
                        <tbody id="voucher-table-body" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($dsShopCustomers as $index => $item)
                                <tr data-search="{{ Str::lower($item->username) }}" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <!-- Checkbox chọn nhiều -->
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="listSelectedIds[]" id="listSelectedIds_{{ $index + 1 }}" value="{{ $item->id }}" class="checkbox-item w-4 h-4 border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                        </div>
                                    </td>
                                    <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                        @php
                                            $avatarPath = $item->avatar 
                                                ? asset('storage/uploads/customers/avatar/' . $item->avatar)
                                                : asset('storage/uploads/users/avatar/avatar-default-nam.jpg');
                                        @endphp

                                        <img class="w-10 h-10 rounded-full" src="{{ $avatarPath }}" alt="Avatar">
                                        
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $item->last_name }} {{ $item->first_name }}
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                {{ $item->email }}
                                            </div>
                                        </div>
                                    </td>


                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                {{ $item->gender == 1 ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                {{ $item->gender == 1 ? 'Nam' : 'Nữ' }}
                                            </span>
                                            <span class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 
                                                    0 0 1 1.11-.21c1.21.49 2.53.76 3.88.76a1 1 0 0 
                                                    1 1 1V20a1 1 0 0 1-1 1C10.07 21 3 13.93 3 
                                                    5a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 
                                                    1.35.26 2.67.76 3.88a1 1 0 0 1-.21 
                                                    1.11l-2.43 2.43z"/>
                                                </svg>
                                                {{ $item->phone }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        @if($item->status == 1)
                                            <div class="flex items-center text-green-600 dark:text-green-400">
                                                <span class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></span> Active
                                            </div>
                                        @else
                                            <div class="flex items-center text-red-600 dark:text-red-400">
                                                <span class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></span> Offline
                                            </div>
                                        @endif
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
                                            data-delete-url="{{ route('backend.ShopCustomer.destroy', ['id' => $item->id]) }}"
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
                        @foreach ($dsShopCustomers as $item)
                        <div id="drawer-update-voucher-{{ $item->id }}" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label-{{ $item->id }}" bis_skin_checked="1" aria-hidden="true">
                            <h5 id="drawer-label-{{ $item->id }}" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                Cập nhật khách hàng - {{ $item->id }}</h5>
                            <button type="button" data-drawer-dismiss="drawer-update-product-{{ $item->id }}" aria-controls="drawer-update-product-{{ $item->id }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close menu</span>
                            </button>
                            <form action="{{ route('backend.ShopCustomer.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    {{-- Tên đăng nhập --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên đăng nhập</label>
                                        <input value="{{ old('username', $item->username) }}" type="text" name="username"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                                            placeholder="Nhập tên đăng nhập" required>
                                    </div>

                                    {{-- Họ --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Họ</label>
                                        <input value="{{ old('last_name', $item->last_name) }}" type="text" name="last_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                                            placeholder="Nhập họ" required>
                                    </div>

                                    {{-- Tên --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên</label>
                                        <input value="{{ old('first_name', $item->first_name) }}" type="text" name="first_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                                            placeholder="Nhập tên" required>
                                    </div>

                                    {{-- Giới tính --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giới tính</label>
                                        <select name="gender"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                                            <option value="0" {{ $item->gender == 0 ? 'selected' : '' }}>Nữ</option>
                                            <option value="1" {{ $item->gender == 1 ? 'selected' : '' }}>Nam</option>
                                        </select>
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input value="{{ old('email', $item->email) }}" type="email" name="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                                            placeholder="Nhập email" required>
                                    </div>

                                    {{-- Số điện thoại --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Số điện thoại</label>
                                        <input value="{{ old('phone', $item->phone) }}" type="text" name="phone"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                                            placeholder="Nhập số điện thoại" required>
                                    </div>

                                    {{-- Avatar --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ảnh đại diện</label>
                                        <input type="file" name="avatar"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                                    </div>

                                   

                                    {{-- Trạng thái --}}
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng thái</label>
                                        <select name="status"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                                            <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Ngừng hoạt động</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nút hành động -->
                                <div class="flex justify-center w-full pb-4 mt-4 space-x-4 sm:px-4">
                                    <button type="submit"
                                        class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                        Cập nhật
                                    </button>
                                    <a href="{{ route('backend.ShopCustomer.index') }}"
                                        class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5">
                                        Hủy
                                    </a>
                                </div>
                            </form>

                        </div>
                        @endforeach 
                    </table>
                    @php
                        $currentPage = $dsShopCustomers->currentPage();
                        $prevUrl = $dsShopCustomers->previousPageUrl()
                            ? request()->fullUrlWithQuery(['page' => $currentPage - 1])
                            : null;

                        $nextUrl = $dsShopCustomers->nextPageUrl()
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
                                    {{ $dsShopCustomers->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
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
                                    {{ !$dsShopCustomers->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
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
                                    {{ $dsShopCustomers->firstItem() ?? 0 }} - {{ $dsShopCustomers->lastItem() ?? 0 }}
                                </span> 
                                trên tổng 
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $dsShopCustomers->total() }}
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
        Khách hàng mới
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
        action="{{ route('backend.ShopCustomer.store') }}"
        class="flex flex-col gap-4 p-6 bg-gray-100 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
        enctype="multipart/form-data" method="POST">
        @csrf
        <div class="space-y-4">
            {{-- Tên đăng nhập --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên đăng nhập</label>
                <input value="{{ old('username') }}" type="text" name="username"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                    placeholder="Nhập tên đăng nhập" required>
            </div>

            {{-- Họ --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Họ</label>
                <input value="{{ old('last_name') }}" type="text" name="last_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                    placeholder="Nhập họ" required>
            </div>

            {{-- Tên --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên</label>
                <input value="{{ old('first_name') }}" type="text" name="first_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                    placeholder="Nhập tên" required>
            </div>

            {{-- Giới tính --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giới tính</label>
                <select name="gender"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                   <option value="0" {{ old('gender') == 0 ? 'selected' : '' }}>Nữ</option>
                   <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Nam</option>

                </select>
            </div>

            {{-- Email --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input value="{{ old('email') }}" type="email" name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                    placeholder="Nhập email" required>
            </div>

            {{-- Số điện thoại --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Số điện thoại</label>
                <input value="{{ old('phone') }}" type="text" name="phone"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white"
                    placeholder="Nhập số điện thoại" required>
            </div>

            {{-- Avatar --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ảnh đại diện</label>
                <input type="file" name="avatar"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
            </div>

            

            {{-- Trạng thái --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng thái</label>
                <select name="status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white">
                    <option value="1" selected>Hoạt động</option>
                    <option value="0">Ngừng hoạt động</option>
                </select>
            </div>
        </div>
        <!-- Nút hành động -->
        <div class="flex justify-center w-full pt-4 space-x-4">
            <button type="submit"
                class="text-white w-full md:w-1/2 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Thêm khách hàng
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
            username: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            last_name: {
                required: true,
                minlength: 1,
                maxlength: 100
            },
            first_name: {
                required: true,
                minlength: 1,
                maxlength: 100
            },
            gender: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                maxlength: 20
            },
            avatar: {
                extension: "jpg|jpeg|png|gif",
                filesize: 2048 // KB
            },
            status: {
                required: true
            }
        },
        messages: {
            username: {
                required: 'Vui lòng nhập tên đăng nhập.',
                minlength: 'Tên đăng nhập phải có ít nhất 3 ký tự.',
                maxlength: 'Tên đăng nhập không được quá 100 ký tự.'
            },
            last_name: {
                required: 'Vui lòng nhập họ.',
                minlength: 'Họ phải có ít nhất 1 ký tự.',
                maxlength: 'Họ không được quá 100 ký tự.'
            },
            first_name: {
                required: 'Vui lòng nhập tên.',
                minlength: 'Tên phải có ít nhất 1 ký tự.',
                maxlength: 'Tên không được quá 100 ký tự.'
            },
            gender: {
                required: 'Vui lòng chọn giới tính.'
            },
            email: {
                required: 'Vui lòng nhập email.',
                email: 'Email không hợp lệ.'
            },
            phone: {
                required: 'Vui lòng nhập số điện thoại.',
                maxlength: 'Số điện thoại không được quá 20 ký tự.'
            },
            avatar: {
                extension: 'Ảnh đại diện phải là định dạng JPG, JPEG, PNG hoặc GIF.',
                filesize: 'Ảnh đại diện không được vượt quá 2MB.'
            },
            status: {
                required: 'Vui lòng chọn trạng thái.'
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
        @foreach ($dsShopCustomers as $item)
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
        url: "{{ route('backend.ShopCustomer.store') }}", // ép dùng route POST
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
                        window.location.href = "{{ route('backend.ShopCustomer.index') }}";
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