@extends('backend/master')
@section('title')
    Danh sách đơn hàng
@endsection
@section('main-content')
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700"
        bis_skin_checked="1">
        <div class="w-full mb-1" bis_skin_checked="1">
            <div class="mb-4" bis_skin_checked="1">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center" bis_skin_checked="1">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                    aria-current="page">Orders</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tất cả đơn đặt hàng</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                bis_skin_checked="1">
                <div class="flex items-center mb-4 sm:mb-0" bis_skin_checked="1">
                    <form method="GET" action="{{ route('backend.ShopOrder.index') }}" class="sm:pr-3">
                        <label for="products-search" class="sr-only">Tìm kiếm</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="keyword" id="products-search" value="{{ request('keyword') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg 
                                    focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 
                                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Tìm theo tên sản phẩm">
                        </div>
                    </form>



                    <div class="flex items-center w-full sm:justify-end" bis_skin_checked="1">
                        <div class="flex pl-2 space-x-1" bis_skin_checked="1">
                            {{-- <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a> --}}
                            <a href="#" id= "btnBatchDelete"
                                data-batch-delete-url="{{ route('backend.ShopVoucher.batchDelete') }}"
                                class="flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Xóa đã chọn
                            </a>
                            <div class="relative inline-block text-left">

                                <button type="button"
                                    class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50"
                                    onclick="toggleFilter()">
                                    🔍 Lọc trạng thái
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div id="filterMenu"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-50">

                                    <a href="{{ route('backend.ShopOrder.index') }}"
                                        class="block px-4 py-2 text-sm hover:bg-gray-100">📋 Tất cả</a>

                                    <a href="{{ route('backend.ShopOrder.index', ['status' => 'Pending']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-yellow-100">⏳ Chờ xử lý</a>

                                    <a href="{{ route('backend.ShopOrder.index', ['status' => 'Delivered']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-blue-100">🚚 Đã giao</a>

                                    <a href="{{ route('backend.ShopOrder.index', ['status' => 'Shipped']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-green-100">📦 Đã gửi</a>

                                    <a href="{{ route('backend.ShopOrder.index', ['status' => 'Cancelled']) }}"
                                        class="block px-4 py-2 text-sm hover:bg-red-100">❌ Đã hủy</a>
                                </div>
                            </div>
                            <script>
                                function toggleFilter() {
                                    document.getElementById('filterMenu').classList.toggle('hidden');
                                }
                            </script>
                            @if (request('status') === 'Pending')
                                <a href="{{ route('backend.ShopOrder.printPending') }}" target="_blank"
                                    class="flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700">
                                    🖨 In đơn chờ xử lý (PDF)
                                </a>
                            @endif

                        </div>
                    </div>
                </div>


                <button id="createProductButton"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                    type="button" data-drawer-target="drawer-create-product-default"
                    data-drawer-show="drawer-create-product-default" aria-controls="drawer-create-product-default"
                    data-drawer-placement="right">
                    Thêm đơn hàng
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
                                        <input type="checkbox" id="checkAll" value="1"
                                            class="checkbox-item w-4 h-4 border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                        {{-- <label for="checkbox-{{ $item->id }}" class="sr-only">checkbox</label> --}}
                                    </div>

                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Khách hàng
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Thông tin đơn hàng
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Trạng thái đơn hàng
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hoạt Động
                                </th>
                            </tr>
                        </thead>
                        <tbody id="voucher-table-body"
                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($dsShopOrders as $index => $item)
                                <tr data-search="{{ Str::lower($item->ship_address1) }}"
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <!-- Checkbox chọn nhiều -->
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="listSelectedIds[]"
                                                id="listSelectedIds_{{ $index + 1 }}" value="{{ $item->id }}"
                                                class="checkbox-item w-4 h-4 border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                        </div>
                                    </td>

                                    <td class="p-4 flex items-center space-x-3">
                                        @php
                                            $avatar = $item->customer?->avatar
                                                ? asset('storage/uploads/customers/avatar/' . $item->customer->avatar)
                                                : asset('storage/uploads/users/avatar/avatar-default-nam.jpg');
                                        @endphp

                                        <img class="w-10 h-10 rounded-full" src="{{ $avatar }}" alt="Avatar">

                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                {{ $item->customer?->last_name }} {{ $item->customer?->first_name }}
                                            </p>
                                            <p class="text-sm text-gray-500">{{ $item->customer->email }}</p>
                                        </div>
                                    </td>

                                    {{-- Thông tin đơn hàng --}}
                                    <td class="p-6 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="flex space-x-12"> <!-- Tăng space giữa 2 cột -->
                                            {{-- Cột trái --}}
                                            <div class="flex flex-col space-y-4 min-w-[180px]">
                                                <!-- Tăng khoảng cách dòng, tăng min-width -->
                                                <div
                                                    class="flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                    <span
                                                        class="font-semibold w-32 text-gray-600 dark:text-gray-400 flex-shrink-0">👨‍💼
                                                        Nhân viên:</span>
                                                    @if ($item->user)
                                                        {{ $item->user->last_name }} {{ $item->user->first_name }}
                                                    @else
                                                        Không có nhân viên
                                                    @endif
                                                </div>
                                                <div
                                                    class="flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                    <span
                                                        class="font-semibold w-32 text-gray-600 dark:text-gray-400 flex-shrink-0">📅
                                                        Ngày đặt hàng:</span>
                                                    <span
                                                        class="text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}</span>
                                                </div>
                                                <div
                                                    class="flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                    <span
                                                        class="font-semibold w-32 text-gray-600 dark:text-gray-400 flex-shrink-0">💰
                                                        Phí vận chuyển:</span>
                                                    <span class="text-green-600 font-semibold">
                                                        {{ number_format($item->shipping_fee, 0, ',', '.') }}₫
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Cột phải --}}
                                            <div class="flex flex-col space-y-4 min-w-[180px]">
                                                <div
                                                    class="flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                    <span
                                                        class="font-semibold w-32 text-gray-600 dark:text-gray-400 flex-shrink-0">📍
                                                        Người nhận:</span>
                                                    <span
                                                        class="text-gray-800 dark:text-gray-200">{{ $item->ship_name }}</span>
                                                </div>
                                                <div
                                                    class="flex items-center space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                    <span
                                                        class="font-semibold w-32 text-gray-600 dark:text-gray-400 flex-shrink-0">🚚
                                                        Ngày giao dự kiến:</span>
                                                    <span
                                                        class="text-gray-800 dark:text-gray-200">{{ $item->shipped_date ? \Carbon\Carbon::parse($item->shipped_date)->format('d/m/Y') : 'Chưa có' }}</span>
                                                </div>
                                                <div
                                                    class="flex items-start space-x-2 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                    <span
                                                        class="font-semibold w-32 text-gray-600 dark:text-gray-400 flex-shrink-0">🏠
                                                        Địa chỉ:</span>
                                                    <span
                                                        class="text-gray-800 dark:text-gray-200 line-clamp-2">{{ $item->ship_address1 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        @if ($item->order_status == 'Pending')
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                ⏳ Chờ xử lý
                                            </span>
                                        @elseif($item->order_status == 'Cancelled')
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                ❌ Đã hủy
                                            </span>
                                        @elseif($item->order_status == 'Delivered')
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                🚚 Đã giao
                                            </span>
                                        @elseif($item->order_status == 'Shipped')
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                📦 Đã gửi hàng
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                                ℹ️ Không xác định
                                            </span>
                                        @endif
                                    </td>


                                    <!-- Nút hành động -->
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <!-- Cập nhật -->
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 dark:bg-primary-500 dark:hover:bg-primary-600 dark:focus:ring-primary-700"
                                            data-drawer-target="drawer-update-voucher-{{ $item->id }}"
                                            data-drawer-show="drawer-update-voucher-{{ $item->id }}"
                                            aria-controls="drawer-update-voucher-{{ $item->id }}"
                                            data-drawer-placement="right" data-voucher_code="{{ $item->voucher_code }}"
                                            data-voucher_name="{{ $item->voucher_name }}"
                                            data-description="{{ $item->description }}" data-uses="{{ $item->uses }}"
                                            data-max_uses="{{ $item->max_uses }}"
                                            data-max_uses_user="{{ $item->max_uses_user }}"
                                            data-type="{{ $item->type }}"
                                            data-discount_amount="{{ $item->discount_amount }}"
                                            data-is_fixed="{{ $item->is_fixed }}"
                                            data-start_date="{{ $item->start_date }}"
                                            data-end_date="{{ $item->end_date }}">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Cập nhật
                                        </button>

                                        <!-- Xóa -->
                                        <button type="button"
                                            class="btn-delete inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                            data-id="{{ $item->id }}"
                                            data-delete-url="{{ route('backend.ShopOrder.destroy', ['id' => $item->id]) }}">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @foreach ($dsShopOrders as $item)
                            <div id="drawer-update-voucher-{{ $item->id }}"
                                class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full"
                                tabindex="-1" aria-labelledby="drawer-label-{{ $item->id }}" bis_skin_checked="1"
                                aria-hidden="true">
                                <h5 id="drawer-label-{{ $item->id }}"
                                    class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                    Cập nhật đơn hàng - {{ $item->id }}</h5>
                                <button type="button" data-drawer-dismiss="drawer-update-product-{{ $item->id }}"
                                    aria-controls="drawer-update-product-{{ $item->id }}"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close menu</span>
                                </button>
                                <form action="{{ route('backend.ShopOrder.update', ['id' => $item->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-4">
                                        {{-- Khách hàng --}}
                                        {{-- Khách hàng --}}
                                        <div>
                                            <label for="customer_id"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Khách
                                                hàng</label>
                                            <select name="customer_id" id="customer_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                                @foreach ($dsShopCustomer as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        data-phone="{{ $customer->phone }}"
                                                        {{ $item->customer_id == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->last_name }} {{ $customer->first_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Số điện thoại --}}
                                        <div>
                                            <label for="ship_phone"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Số
                                                điện thoại</label>
                                            <input value="{{ $item->ship_phone ?? '' }}" type="text"
                                                name="ship_phone" id="ship_phone"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                required>
                                        </div>

                                        {{-- Script đổi số điện thoại khi chọn khách hàng --}}
                                        <script>
                                            document.getElementById('customer_id').addEventListener('change', function() {
                                                let phone = this.options[this.selectedIndex].getAttribute('data-phone');
                                                document.getElementById('ship_phone').value = phone || '';
                                            });
                                        </script>


                                        {{-- Địa chỉ giao hàng --}}
                                        <div>
                                            <label for="ship_address1"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Địa
                                                chỉ</label>
                                            <textarea name="ship_address1" id="ship_address1" rows="3"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                required>{{ $item->ship_address1 }}</textarea>
                                        </div>

                                        {{-- Nhân viên phụ trách --}}
                                        <div>
                                            <label for="employee_id"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nhân
                                                viên phụ trách</label>
                                            <select name="employee_id" id="employee_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                                @foreach ($dsAclUsers as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $item->employee_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->last_name }} {{ $user->first_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="ship_name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên
                                                người nhận</label>
                                            <input type="text" name="ship_name" id="ship_name"
                                                value="{{ old('ship_name', $item->ship_name ?? '') }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                required>
                                        </div>
                                        {{-- Hình thức thanh toán --}}
                                        <div>
                                            <label for="payment_type_id"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình
                                                thức thanh toán</label>
                                            <select name="payment_type_id" id="payment_type_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                                @foreach ($dsShopPaymentType as $paymentType)
                                                    <option value="{{ $paymentType->id }}"
                                                        {{ $item->payment_type_id == $paymentType->id ? 'selected' : '' }}>
                                                        {{ $paymentType->payment_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="shipping_fee"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phí
                                                vận chuyển</label>
                                            <input type="number" name="shipping_fee" id="shipping_fee"
                                                value="{{ old('shipping_fee', $item->shipping_fee ?? '') }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                placeholder="Nhập phí vận chuyển" step="0.01" min="0">
                                        </div>
                                        <div>
                                            <label for="order_date"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ngày
                                                đặt hàng</label>
                                            <input type="date" name="order_date" id="order_date"
                                                value="{{ \Carbon\Carbon::parse($item->order_date)->format('Y-m-d') }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                                required>
                                        </div>

                                        {{-- Trạng thái --}}
                                        <div>
                                            <label for="order_status"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng
                                                thái</label>
                                            <select name="order_status" id="order_status"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                                <option value="Pending"
                                                    {{ $item->order_status == 'Pending' ? 'selected' : '' }}>Chờ xử lý
                                                </option>
                                                <option value="Delivered"
                                                    {{ $item->order_status == 'Delivered' ? 'selected' : '' }}>Đã giao
                                                </option>
                                                <option value="Shipped"
                                                    {{ $item->order_status == 'Shipped' ? 'selected' : '' }}>Đã gửi hàng
                                                </option>
                                                <option value="Cancelled"
                                                    {{ $item->order_status == 'Cancelled' ? 'selected' : '' }}>Hủy</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Nút hành động --}}
                                    <div class="flex justify-center w-full pb-4 mt-4 space-x-4 sm:px-4">
                                        <button type="submit"
                                            class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none
                                        focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600
                                        dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            Cập nhật
                                        </button>
                                        <a href="{{ route('backend.ShopOrder.index') }}"
                                            class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600
                                        hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm
                                        px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600
                                        dark:focus:ring-red-900">
                                            Hủy
                                        </a>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </table>
                    @php
                        $currentPage = $dsShopOrders->currentPage();
                        $prevUrl = $dsShopOrders->previousPageUrl()
                            ? request()->fullUrlWithQuery(['page' => $currentPage - 1])
                            : null;

                        $nextUrl = $dsShopOrders->nextPageUrl()
                            ? request()->fullUrlWithQuery(['page' => $currentPage + 1])
                            : null;
                    @endphp

                    <div
                        class="sticky bottom-0 right-0 w-full p-4 bg-white border-t border-gray-200 sm:flex sm:items-center sm:justify-between dark:bg-gray-800 dark:border-gray-700">

                        <!-- Bên trái: Nút điều hướng -->
                        <div class="flex items-center space-x-3 mb-4 sm:mb-0">
                            <!-- Nút Trước -->
                            <a href="{{ $prevUrl ?? '#' }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg 
                                    hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 
                                    {{ $dsShopOrders->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Trước
                            </a>

                            <!-- Nút Tiếp -->
                            <a href="{{ $nextUrl ?? '#' }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg 
                                    hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
                                    dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 
                                    {{ !$dsShopOrders->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
                                Tiếp
                                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>

                        <!-- Bên phải: Thông tin hiển thị -->
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Hiển thị
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $dsShopOrders->firstItem() ?? 0 }} - {{ $dsShopOrders->lastItem() ?? 0 }}
                                </span>
                                trên tổng
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $dsShopOrders->total() }}
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
            Đơn hàng mới
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
        <form id="frmCreateOrder" action="{{ route('backend.ShopOrder.store') }}"
            class="flex flex-col gap-4 p-6 bg-gray-100 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
            method="POST">
            @csrf

            {{-- Tên người nhận hàng --}}
            <div>
                <label for="ship_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Tên người nhận
                </label>
                <input type="text" id="ship_name" name="ship_name" value="{{ old('ship_name') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Nhập tên người nhận(Shipper)" required>
            </div>

            {{-- Địa chỉ giao hàng --}}
            <div>
                <label for="ship_address1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Địa chỉ giao hàng
                </label>
                <textarea id="ship_address1" name="ship_address1" rows="2"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Nhập địa chỉ" required>{{ old('ship_address1') }}</textarea>
            </div>

            {{-- Nhân viên phụ trách --}}
            <div>
                <label for="employee_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Nhân viên phụ trách
                </label>
                <select id="employee_id" name="employee_id"
                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
                    <option value="">-- Chọn nhân viên --</option>
                    @foreach ($dsAclUsers as $user)
                        <option value="{{ $user->id }}" {{ old('employee_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->last_name }} {{ $user->first_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Khách hàng --}}
            <div>
                <label for="customer_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Khách hàng
                </label>
                <select id="customer_id" name="customer_id"
                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
                    <option value="">-- Chọn khách hàng --</option>
                    @foreach ($dsShopCustomer as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->last_name }} {{ $customer->first_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Phương thức thanh toán --}}
            <div>
                <label for="payment_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Phương thức thanh toán
                </label>
                <select id="payment_type_id" name="payment_type_id"
                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
                    <option value="">-- Chọn phương thức --</option>
                    @foreach ($dsShopPaymentType as $payment)
                        <option value="{{ $payment->id }}"
                            {{ old('payment_type_id') == $payment->id ? 'selected' : '' }}>
                            {{ $payment->payment_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Phí vận chuyển --}}
            <div>
                <label for="shipping_fee" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Phí vận chuyển (VNĐ)
                </label>
                <input type="number" id="shipping_fee" name="shipping_fee" min="0" step="0.01"
                    value="{{ old('shipping_fee') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
            </div>

            {{-- Ngày đặt hàng --}}
            <div>
                <label for="order_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Ngày đặt hàng
                </label>
                <input type="date" id="order_date" name="order_date" value="{{ old('order_date') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
            </div>

            {{-- Ngày giao hàng --}}
            <div>
                <label for="shipped_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Ngày giao hàng (nếu có)
                </label>
                <input type="date" id="shipped_date" name="shipped_date" value="{{ old('shipped_date') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            {{-- Ngày thanh toán --}}
            <div>
                <label for="paid_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Ngày thanh toán (nếu có)
                </label>
                <input type="date" id="paid_date" name="paid_date" value="{{ old('paid_date') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 
                   dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            {{-- Trạng thái đơn hàng --}}
            <div>
                <label for="order_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Trạng thái đơn hàng
                </label>
                <select id="order_status" name="order_status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5
                                            dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    required>
                    <option value="Pending" {{ old('order_status') == 'Pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="Shipped" {{ old('order_status') == 'Shipped' ? 'selected' : '' }}>Đang giao</option>
                    <option value="Delivered" {{ old('order_status') == 'Delivered' ? 'selected' : '' }}>Hoàn thành
                    </option>
                    <option value="Cancelled" {{ old('order_status') == 'Cancelled' ? 'selected' : '' }}>Hủy</option>
                </select>
            </div>


            {{-- Nút hành động --}}
            <div class="flex justify-center w-full pt-4 space-x-4">
                <button type="submit"
                    class="text-white w-full md:w-1/2 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none 
                   focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                   dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Thêm đơn hàng
                </button>
                <button type="button" data-drawer-dismiss="drawer-create-order"
                    class="inline-flex w-full md:w-1/2 justify-center text-gray-500 items-center bg-white hover:bg-gray-100 
                   focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 
                   text-sm font-medium px-5 py-2.5 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 
                   dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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
        border: 2px dashed #cbd5e1;
        /* Tailwind: slate-300 */
        background-color: #f8fafc;
        /* Tailwind: slate-50 */
        border-radius: 0.5rem;
        /* rounded-lg */
        padding: 2rem;
        text-align: center;
        color: #64748b;
        /* slate-500 */
        transition: background-color 0.3s ease;
    }

    .dropzone:hover {
        background-color: #f1f5f9;
        /* slate-100 */
    }
</style>
@section('custom.js')
    <script>
        $(document).ready(function() {
            $('.btn-delete').on('click', function(e) {
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
                            success: function(response) {
                                Swal.fire("Đã xóa!", "Dữ liệu đã bị xóa.", "success")
                                    .then(() => {
                                        location.reload();
                                    });
                            },
                            error: function(xhr) {
                                console.error(xhr);
                                Swal.fire("Lỗi", "Không thể xóa. Vui lòng thử lại.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });
        $(function() {
            $('#frmCreateOrder').validate({
                rules: {
                    order_date: {
                        required: true,
                        date: true
                    },
                    shipped_date: {
                        date: true
                    },
                    ship_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    ship_address1: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    ship_state: {
                        maxlength: 100
                    },
                    ship_postal_code: {
                        maxlength: 20
                    },
                    shipping_fee: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    paid_date: {
                        date: true
                    },
                    order_status: {
                        required: true
                    },
                    employee_id: {
                        required: true
                    },
                    customer_id: {
                        required: true
                    },
                    payment_type_id: {
                        required: true
                    }
                },
                messages: {
                    order_date: {
                        required: 'Vui lòng chọn ngày đặt hàng.',
                        date: 'Ngày đặt hàng không hợp lệ.'
                    },
                    shipped_date: {
                        date: 'Ngày giao hàng không hợp lệ.'
                    },
                    ship_name: {
                        required: 'Vui lòng nhập tên người nhận.',
                        minlength: 'Tên người nhận phải có ít nhất 3 ký tự.',
                        maxlength: 'Tên người nhận không được quá 255 ký tự.'
                    },
                    ship_address1: {
                        required: 'Vui lòng nhập địa chỉ giao hàng.',
                        minlength: 'Địa chỉ phải có ít nhất 3 ký tự.',
                        maxlength: 'Địa chỉ không được quá 255 ký tự.'
                    },
                    ship_state: {
                        maxlength: 'Tên tỉnh/thành không được quá 100 ký tự.'
                    },
                    ship_postal_code: {
                        maxlength: 'Mã bưu điện không được quá 20 ký tự.'
                    },
                    shipping_fee: {
                        required: 'Vui lòng nhập phí vận chuyển.',
                        number: 'Phí vận chuyển phải là số.',
                        min: 'Phí vận chuyển không được nhỏ hơn 0.'
                    },
                    paid_date: {
                        date: 'Ngày thanh toán không hợp lệ.'
                    },
                    order_status: {
                        required: 'Vui lòng chọn trạng thái đơn hàng.'
                    },
                    employee_id: {
                        required: 'Vui lòng chọn nhân viên.'
                    },
                    customer_id: {
                        required: 'Vui lòng chọn khách hàng.'
                    },
                    payment_type_id: {
                        required: 'Vui lòng chọn phương thức thanh toán.'
                    }
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                    error.addClass("text-red-600 text-sm mt-1 block");
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("border-red-600 ring-red-600 ring-1");
                },
                unhighlight: function(element) {
                    $(element).removeClass("border-red-600 ring-red-600 ring-1");
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById("create-image");
            const img = document.getElementById("create-preview-img");

            if (!fileInput || !img) return;

            fileInput.addEventListener("change", function(e) {
                const file = e.target.files[0];
                if (!file) return;

                if (!file.type.startsWith("image/")) {
                    alert("File phải là hình ảnh!");
                    fileInput.value = '';
                    img.src = img.dataset.default;
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(ev) {
                    img.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($dsShopOrders as $item)
                const fileInput{{ $item->id }} = document.getElementById("update-image-{{ $item->id }}");
                const img{{ $item->id }} = document.getElementById(
                    "update-preview-img-{{ $item->id }}");

                if (fileInput{{ $item->id }} && img{{ $item->id }}) {
                    fileInput{{ $item->id }}.addEventListener("change", function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        if (!file.type.startsWith("image/")) {
                            alert("File phải là hình ảnh!");
                            fileInput{{ $item->id }}.value = '';
                            img{{ $item->id }}.src = img{{ $item->id }}.dataset.default;
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(ev) {
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
            url: "{{ route('backend.ShopOrder.store') }}", // ép dùng route POST
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
            init: function() {
                this.on("successmultiple", function(files, response) {
                    Toastify({
                        text: response.message || "Tải ảnh thành công!",
                        duration: 3000,
                        gravity: "top", // top hoặc bottom
                        position: "right", // left, center hoặc right
                        backgroundColor: "#16a34a", // màu xanh thành công
                        close: true,
                        onClick: function() {
                            window.location.href =
                                "{{ route('backend.ShopOrder.index') }}";
                        }
                    }).showToast();

                    // setTimeout(() => {
                    //     window.location.href = "{{ route('backend.ProductImg.index') }}";
                    // }, 2000); // đợi 2 giây để toast hiển thị
                });

                this.on("errormultiple", function(files, response) {
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
        $(function() {
            $('#checkAll').on('change', function() {
                var isCheckedAll = $(this).is(":checked");

                var listSelectedElements = $("input[type='checkbox'][name='listSelectedIds[]']");
                $.each(listSelectedElements, function(index, ele) {
                    $(ele).attr('checked', isCheckedAll);
                });

            });
            $('#btnBatchDelete').on('click', function(e) {
                e.preventDefault();

                var batchDeleteUrl = $(this).data("batch-delete-url");
                var btnBatchDelete = $(this);
                var listSelectedIds = [];

                var listSelectedElements = $("input[type='checkbox'][name='listSelectedIds[]']:checked");
                $.each(listSelectedElements, function(index, ele) {
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
                            .done(function(response) {
                                var list_deleted_ids = response.list_deleted_ids;
                                Swal.fire({
                                    title: "Bạn có chắc chắn?",
                                    text: response.message,
                                    icon: "info",
                                });
                                $.each(list_deleted_ids, function(index, id) {
                                    var selector =
                                        "input[type='checkbox'][name ='listSelectedIds[]'][value=" +
                                        id + "]";
                                    $(selector).parent().parent().parent().remove();
                                });
                            })
                            .fail(function(e) {
                                Swal.fire("Lỗi", "Xóa thất bại.", "error");
                            });
                    }
                });
            });
        });
        document.getElementById('products-search').addEventListener('input', function() {
            clearTimeout(this._timeout);
            this._timeout = setTimeout(() => {
                this.form.submit(); // Gửi form lên server để lọc toàn bộ kết quả
            }, 500); // chờ người dùng gõ xong 500ms rồi mới gửi
        });
    </script>
@endsection
