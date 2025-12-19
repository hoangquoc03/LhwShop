@extends('backend/master')
@section('title')
Danh sách Sản phẩm
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Product</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tất cả sản phẩm</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700" bis_skin_checked="1">
                <div class="flex items-center mb-4 sm:mb-0" bis_skin_checked="1">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="products-search" class="sr-only">Tìm kiếm</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96" bis_skin_checked="1">
                            <input type="text" name="email" id="products-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search for settings">
                        </div>
                    </form>
                    <div class="flex items-center w-full sm:justify-end" bis_skin_checked="1">
                        <div class="flex pl-2 space-x-1" bis_skin_checked="1">
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
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
                    Thêm sản phẩm
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
                                    <div class="flex items-center" bis_skin_checked="1">
                                        <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">Chọn tất cả</label>
                                    </div>
                                </th>
                
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ảnh
                                </th>
                                {{-- <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Tên sản phẩm                                                                                                      
                                </th> --}}
                                {{-- <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Mô tả
                                </th> --}}
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Giá
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Số lượng
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Tình trạng
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Danh mục
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Danh mục 2
                                
                                </th>
                                {{-- <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ngày tạo
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ngày cập nhật
                                </th> --}}
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hoạt Động
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($dsShopProducts as $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-{{ $item->id }}" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-{{ $item->id }}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <img 
                                            src="{{ Str::startsWith($item->image, ['http://', 'https://']) 
                                                    ? $item->image 
                                                    : asset('storage/uploads/products/' . $item->image) }}"
                                            alt="Product Image"
                                            class="w-16 h-16 object-cover rounded">
                                    </td>


                                    <td class="hidden p-4 text-base font-medium text-gray-900 dark:text-white view-field-name-{{ $item->id }}">
                                        {{ $item->product_name }}
                                    </td>


                                    <td class="hidden view-field-description-{{ $item->id }} p-4 text-sm text-gray-500 truncate dark:text-gray-400 max-w-xs">
                                        {{ $item->short_description }}
                                    </td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        <div class=" rounded-xl p-3 space-y-2 shadow-sm">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="font-semibold text-gray-600 dark:text-gray-300">Giá chuẩn:</span>
                                                <span class="text-blue-600 dark:text-blue-400 font-medium">
                                                    {{ number_format($item->standard_cost, 0, ',', '.') }}₫
                                                </span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="font-semibold text-gray-600 dark:text-gray-300">Giá bán:</span>
                                                <span class="text-green-600 dark:text-green-400 font-medium">
                                                    {{ number_format($item->list_price, 0, ',', '.') }}₫
                                                </span>
                                            </div>
                                        </div>
                                    </td>



                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        {{ $item->quantity_per_unit }}
                                    </td>

                                    <td class="p-4 text-base font-medium">
                                        <div class="flex flex-wrap items-center gap-2">
                                            {{-- Tình trạng bán --}}
                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full 
                                                {{ $item->discontinued 
                                                    ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' 
                                                    : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' }}">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                                                </svg>
                                                {{ $item->discontinued ? 'Ngừng bán' : 'Đang bán' }}
                                            </span>

                                            {{-- Sản phẩm mới --}}
                                            @if ($item->is_new)
                                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.386 2.46a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.386-2.46a1 1 0 00-1.176 0l-3.386 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.045 9.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                                    </svg>
                                                    Mới
                                                </span>
                                            @endif

                                            {{-- Nổi bật --}}
                                            @if ($item->is_featured)
                                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 2a1 1 0 01.894.553l1.382 2.764 3.05.444a1 1 0 01.554 1.705l-2.21 2.154.522 3.041a1 1 0 01-1.451 1.054L10 12.347l-2.741 1.444a1 1 0 01-1.451-1.054l.522-3.041-2.21-2.154a1 1 0 01.554-1.705l3.05-.444L9.106 2.553A1 1 0 0110 2z"/>
                                                    </svg>
                                                    Nổi bật
                                                </span>
                                            @endif
                                        </div>
                                    </td>


                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        @if ($item->category)
                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 3a1 1 0 011-1h10a1 1 0 011 1v2H4V3zm0 4h12v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7z" />
                                                </svg>
                                                {{ $item->category->categories_text }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400 italic">Không có danh mục</span>
                                        @endif
                                    </td>




                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                        @if ($item->supplier)
                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2H2V5zm0 4h16v6a2 2 0 01-2 2H4a2 2 0 01-2-2V9z" />
                                                </svg>
                                                {{ $item->supplier->supplier_text }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400 italic">Không có nhà danh mục 2</span>
                                        @endif
                                    </td>




                                    {{-- <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->created_at->diffForHumans() }}
                                    </td>

                                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->updated_at ? $item->updated_at->diffForHumans() : 'Chưa cập nhật' }}
                                    </td> --}}

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <!-- Nút cập nhật -->
                                        <button type="button"
                                                data-view-id="{{ $item->id }}"
                                                class="btn-view inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-600">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zM10 15a5 5 0 110-10 5 5 0 010 10z"/>
                                                    <path d="M10 7a3 3 0 100 6 3 3 0 000-6z"/>
                                                </svg>
                                                Xem
                                        </button>
                                        <button type="button"
                                            id="updateProductButton"
                                            data-drawer-target="drawer-update-product-{{ $item->id }}"
                                            data-drawer-show="drawer-update-product-{{ $item->id }}"
                                            aria-controls="drawer-update-product-{{ $item->id }}"
                                            data-drawer-placement="right"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                            data-id="{{ $item->id }}"
                                            data-image="{{ $item->image }}"
                                            data-product_name="{{ $item->product_name }}"
                                            data-short_description="{{ $item->short_description }}"
                                            data-list_price="{{ $item->list_price }}"
                                            data-quantity_per_unit="{{ $item->quantity_per_unit }}"
                                            data-discontinued="{{ $item->discontinued }}"
                                            >
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/></svg>
                                            Cập nhật
                                        </button>

                                        <!-- Nút xóa -->
                                        <button type="button" id="deleteProductButton" 
                                        class="btn-delete inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                        data-id="{{ $item->id }}"
                                        data-delete-url = "{{ route('backend.Product.destroy', ['id' => $item->id]) }}"
                                        >
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Xóa
                                    </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @foreach ($dsShopProducts as $item)
                        <div id="drawer-update-product-{{ $item->id }}" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label-{{ $item->id }}" bis_skin_checked="1" aria-hidden="true">
                            <h5 id="drawer-label-{{ $item->id }}" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                Cập nhật sản phẩm - {{ $item->id }}</h5>
                            <button type="button" data-drawer-dismiss="drawer-update-product-{{ $item->id }}" aria-controls="drawer-update-product-{{ $item->id }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close menu</span>
                            </button>
                            <form action="{{ route('backend.Product.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">

                                    <div>
                                        <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên sản phẩm</label>
                                        <input value="{{ $item->product_name }}" type="text" name="product_name" id="product_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Nhập tên sản phẩm" required>
                                    </div>
                                    <div>
                                        <label for="quantity_per_unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Số lượng mỗi đơn vị</label>
                                        <input value="{{ $item->quantity_per_unit }}" type="text" name="quantity_per_unit" id="quantity_per_unit"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            placeholder="Số lượng" required>
                                    </div>
                                    <div>
                                        <label for="standard_cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá chuẩn</label>
                                        <input value="{{ $item->standard_cost }}" type="text" name="standard_cost" id="standard_cost"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Nhập giá chuẩn" required>
                                    </div>
                                    <div>
                                        <label for="list_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá bán</label>
                                        <input value="{{ $item->list_price }}" type="text" name="list_price" id="list_price"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Nhập giá bán" required>
                                    </div>
                                    <div>
                                        <label for="is_featured" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sản phẩm nổi bật?</label>
                                        <select name="is_featured" id="is_featured"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            required>
                                            <option value="">-- Chọn --</option>
                                            <option value="1" {{ old('is_featured',$item->is_featured) == '1' ? 'selected' : '' }}>Có</option>
                                            <option value="0" {{ old('is_featured',$item->is_featured) == '0' ? 'selected' : '' }}>Không</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="is_new" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sản phẩm mới?</label>
                                        <select name="is_new" id="is_new"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            required>
                                            <option value="">-- Chọn --</option>
                                            <option value="1" {{ old('is_new',$item->is_new) == '1' ? 'selected' : '' }}>Có</option>
                                            <option value="0" {{ old('is_new',$item->is_new) == '0' ? 'selected' : '' }}>Không</option>
                                        </select>
                                    </div>


                                    
                                    {{-- Chọn danh mục --}}
                                    <div>
                                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Danh mục</label>
                                        <select name="category_id" id="category_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            required>
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach ($dsShopCategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->categories_text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Chọn nhà cung cấp --}}
                                    <div>
                                        <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Danh mục 2</label>
                                        <select name="supplier_id" id="supplier_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            required>
                                            <option value="">-- Chọn danh mục 2 --</option>
                                            @foreach ($dsShopSupplier as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ $item->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->supplier_text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div>
                                        <label for="image-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình ảnh</label>
                                        <input type="file" name="image" id="update-image-{{ $item->id }}" accept="image/*"
                                            class="input border border-gray-300 text-sm rounded-lg w-full p-2.5">
                                        <img src="{{ asset('storage/uploads/products/' . $item->image) }}"
                                            data-default="{{ asset('storage/uploads/products/' . $item->image) }}"
                                            class="w-32 mt-2 preview-img-container"
                                            id="update-preview-img-{{ $item->id }}"
                                            alt="Xem trước ảnh">
                                    </div>
                                    <div class="mb-3">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hoặc nhập link ảnh</label>
                                        <input type="text" name="image_url" 
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="https://example.com/image.jpg"
                                            value="{{ old('image_url', $item->image) }}">
                                    </div>


                                    <div>
                                        <label for="short_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả ngắn</label>
                                        <textarea name="short_description" id="short_description" rows="3"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Nhập mô tả ngắn sản phẩm">{{ $item->short_description }}</textarea>
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
                        <div id="viewModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                            <div id="modalContent" class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 border border-gray-200">
                                <h2 class="text-2xl font-bold text-gray-800 mb-6">🛒 Chi tiết sản phẩm</h2>

                                <div class="mb-5">
                                    <strong class="block text-gray-600 mb-1">📄 Mô tả:</strong>
                                    <p id="view-description" class="text-gray-800 whitespace-pre-line leading-relaxed"></p>
                                </div>

                                <div class="mb-5">
                                    <strong class="block text-gray-600 mb-1">🏷️ Tên sản phẩm:</strong>
                                    <p id="view-name" class="text-gray-800 font-medium"></p>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Product Drawer -->
    <div id="drawer-create-product-default" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label" bis_skin_checked="1" aria-hidden="true">
        <h5 id="drawer-label" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Sản phẩm mới</h5>
        <button type="button" data-drawer-dismiss="drawer-create-product-default" aria-controls="drawer-create-product-default" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <form id="frmCreate" action="{{ route('backend.Product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">

                <!-- Tên sản phẩm & Số lượng -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên sản phẩm</label>
                        <input value="{{ old('product_name') }}" type="text" name="product_name" id="product_name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            placeholder="Nhập tên sản phẩm" required>
                    </div>

                    <div>
                        <label for="quantity_per_unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Số lượng mỗi đơn vị</label>
                        <input value="{{ old('quantity_per_unit') }}" type="text" name="quantity_per_unit" id="quantity_per_unit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            placeholder="Số lượng" required>
                    </div>
                </div>

                <!-- Danh mục & danh mục 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Danh mục</label>
                        <select name="category_id" id="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($dsShopCategory as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->categories_text }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">danh mục 2</label>
                        <select name="supplier_id" id="supplier_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            <option value="">-- Chọn danh mục 2 --</option>
                            @foreach ($dsShopSupplier as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->supplier_text }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Trạng thái: discontinued, is_featured, is_new -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="discontinued" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ngừng kinh doanh?</label>
                        <select name="discontinued" id="discontinued"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ old('discontinued') == '1' ? 'selected' : '' }}>Ngừng bán</option>
                            <option value="0" {{ old('discontinued') == '0' ? 'selected' : '' }}>Đang bán</option>
                        </select>
                    </div>

                    <div>
                        <label for="is_featured" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sản phẩm nổi bật?</label>
                        <select name="is_featured" id="is_featured"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            <option value="">-- Chọn --</option>
                            <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Có</option>
                            <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>Không</option>
                        </select>
                    </div>

                    <div>
                        <label for="is_new" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sản phẩm mới?</label>
                        <select name="is_new" id="is_new"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            <option value="">-- Chọn --</option>
                            <option value="1" {{ old('is_new') == '1' ? 'selected' : '' }}>Có</option>
                            <option value="0" {{ old('is_new') == '0' ? 'selected' : '' }}>Không</option>
                        </select>
                    </div>
                </div>

                <!-- Mô tả ngắn -->
                <div>
                    <label for="short_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả ngắn</label>
                    <textarea name="short_description" id="short_description" rows="3"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        placeholder="Nhập mô tả ngắn" required>{{ old('short_description') }}</textarea>
                </div>

                <!-- Hình ảnh -->
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình ảnh</label>
                    <input type="file" name="image" id="create-image" accept="image/*"
                        class="input border border-gray-300 text-sm rounded-lg w-full p-2.5">
                    <img src="{{ asset('static/dist/images/default-image.jpg') }}"
                        data-default="{{ asset('static/dist/images/default-image.jpg') }}"
                        class="w-32 mt-2 preview-img-container" id="create-preview-img" alt="Xem trước ảnh">
                </div>

                <!-- Giá chuẩn & Giá bán -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="standard_cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá chuẩn</label>
                        <input value="{{ old('standard_cost') }}" type="number" step="0.01" name="standard_cost" id="standard_cost"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            placeholder="Nhập giá chuẩn" required>
                    </div>

                    <div>
                        <label for="list_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá bán</label>
                        <input value="{{ old('list_price') }}" type="number" step="0.01" name="list_price" id="list_price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            placeholder="Nhập giá bán" required>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="flex justify-center w-full pt-4 space-x-4">
                    <button type="submit"
                        class="text-white w-full md:w-1/2 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Thêm sản phẩm
                    </button>

                    <button type="button" data-drawer-dismiss="drawer-create-product-default"
                        class="inline-flex w-full md:w-1/2 justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Hủy
                    </button>
                </div>

            </div>
        </form>
    </div>
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
            product_name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            description: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            standard_cost: {
                required: true,
                number: true,
                min: 0
            },
            list_price: {
                required: true,
                number: true,
                min: 0
            },
            image: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            product_name: {
                required: 'Vui lòng nhập tên sản phẩm.',
                minlength: 'Tên sản phẩm phải từ 3 ký tự trở lên.',
                maxlength: 'Tên sản phẩm phải dưới 100 ký tự.'
            },
            description: {
                required: 'Vui lòng nhập mô tả.',
                minlength: 'Mô tả phải từ 3 ký tự trở lên.',
                maxlength: 'Mô tả phải dưới 100 ký tự.'
            },
            standard_cost: {
                required: 'Vui lòng nhập giá chuẩn.',
                number: 'Giá chuẩn phải là số.',
                min: 'Giá chuẩn không được nhỏ hơn 0.'
            },
            list_price: {
                required: 'Vui lòng nhập giá bán.',
                number: 'Giá bán phải là số.',
                min: 'Giá bán không được nhỏ hơn 0.'
            },
            image: {
                required: 'Vui lòng chọn ảnh.',
                extension: 'Ảnh phải có định dạng: jpg, jpeg, png, gif.'
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
        @foreach ($dsShopProducts as $item)
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
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('viewModal');
        const modalContent = document.getElementById('modalContent');

        // Gán sự kiện mở modal
        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-view-id');
                const descriptionElement = document.querySelector('.view-field-description-' + id);
                const nameElement = document.querySelector('.view-field-name-' + id);

                const description = descriptionElement ? descriptionElement.textContent.trim() : 'Không có mô tả';
                const name = nameElement ? nameElement.textContent.trim() : 'Không rõ';

                document.getElementById('view-description').textContent = description;
                document.getElementById('view-name').textContent = name;

                modal.classList.remove('hidden');
            });
        });

        // Đóng khi click ra ngoài nội dung modal
        modal.addEventListener('click', function (event) {
            if (!modalContent.contains(event.target)) {
                closeViewModal();
            }
        });

        // Đóng bằng phím ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeViewModal();
            }
        });
    });

    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }
</script>



@endsection