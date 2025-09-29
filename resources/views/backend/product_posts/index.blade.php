@extends('backend/master')
@section('title')
Các bài đăng sản phẩm
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Product Post</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tất cả bai dang ve san pham</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700" bis_skin_checked="1">
                <div class="flex items-center mb-4 sm:mb-0" bis_skin_checked="1">
                <form method="GET" action="{{ route('backend.ProductPost.index') }}" class="sm:pr-3">
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
                            <a href="#" id= "btnBatchDelete" data-batch-delete-url="{{ route('backend.ProductImg.batchDelete') }}"
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
                    Thêm bài đăng
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
                                
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Thông tin sản phẩm
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    hình ảnh bài đăng                                                                                                     
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Chủ đề                                                                                          
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Nội dung                                                                                                       
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hoạt Động
                                </th>
                            </tr>
                        </thead>
                        <tbody id="product-table-body" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($dsShopProducPosts as $index => $item)
                                <tr data-search="{{ Str::lower($item->product->product_name) }}" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4">
                                        <div class="flex flex-col space-y-1">
                                            <div>
                                                <span class="text-xs font-medium text-gray-500 uppercase">Tên sản phẩm</span>
                                                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                                    {{ $item->product?->product_name }}
                                                </p>
                                                <img src="/storage/uploads/products/{{ $item->product?->image }}" alt="Sản phẩm" class="w-12 h-12 rounded object-cover border">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white view-field-name-{{ $item->id }}">
                                        <img src="/storage/uploads/posts/{{ $item->image }}" alt="bai dang" class="w-12 h-12 rounded object-cover border">
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white view-field-name-{{ $item->id }}">
                                        {{ $item->title }}
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white view-field-name-{{ $item->id }}">
                                        {{ $item->content }}
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        
                                        <button type="button"
                                            id="updateProductButton"
                                            data-drawer-target="drawer-update-product-{{ $item->id }}"
                                            data-drawer-show="drawer-update-product-{{ $item->id }}"
                                            aria-controls="drawer-update-product-{{ $item->id }}"
                                            data-drawer-placement="right"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                            data-product_name="{{ $item->product->product_name }}"
                                            data-image="{{ $item->image }}"
                                            >
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/></svg>
                                            Cập nhật
                                        </button>

                                        <!-- Nút xóa -->
                                        <button type="button" id="deleteProductButton" 
                                        class="btn-delete inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                        data-id="{{ $item->id }}"
                                        data-delete-url = "{{ route('backend.ProductPost.destroy', ['id' => $item->id]) }}"
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
                        @foreach ($dsShopProducPosts as $item)
                        <div id="drawer-update-product-{{ $item->id }}" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label-{{ $item->id }}" bis_skin_checked="1" aria-hidden="true">
                            <h5 id="drawer-label-{{ $item->id }}" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                Cập nhật bài đăng - {{ $item->id }}</h5>
                            <button type="button" data-drawer-dismiss="drawer-update-product-{{ $item->id }}" aria-controls="drawer-update-product-{{ $item->id }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close menu</span>
                            </button>
                            <form action="{{ route('backend.ProductPost.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">

                                    <div>
                                        <select name="product_id" 
                                        class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            required>
                                            @foreach ($dsShopProducts as $product)
                                                <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>
                                                    {{ $product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="image-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình ảnh</label>
                                        <input type="file" name="image" id="update-image-{{ $item->id }}" accept="image/*"
                                            class="input border border-gray-300 text-sm rounded-lg w-full p-2.5">
                                        <img src="{{ asset('storage/uploads/posts/' . $item->image) }}"
                                            data-default="{{ asset('storage/uploads/posts/' . $item->image) }}"
                                            class="w-32 mt-2 preview-img-container"
                                            id="update-preview-img-{{ $item->id }}"
                                            alt="Xem trước ảnh">
                                    </div>
                                    <div>
                                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên tiêu đề</label>
                                        <input value="{{ $item->title }}" type="text" name="title" id="title"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            placeholder="Nhập tên tiêu đề" required>
                                    </div>

                                    <div>
                                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nội dung</label>
                                        <input value="{{ $item->content }}" type="text" name="content" id="content"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                            placeholder="Nhập Nội dung" required>
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
                        $currentPage = $dsShopProducPosts->currentPage();
                        $prevUrl = $dsShopProducPosts->previousPageUrl()
                            ? request()->fullUrlWithQuery(['page' => $currentPage - 1])
                            : null;

                        $nextUrl = $dsShopProducPosts->nextPageUrl()
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
                                    {{ $dsShopProducPosts->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
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
                                    {{ !$dsShopProducPosts->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
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
                                    {{ $dsShopProducPosts->firstItem() ?? 0 }} - {{ $dsShopProducPosts->lastItem() ?? 0 }}
                                </span> 
                                trên tổng 
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $dsShopProducPosts->total() }}
                                </span> mục
                            </span>
                        </div>

                    </div>

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
        <form id="frmCreate" action="{{ route('backend.ProductPost.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- Chọn sản phẩm -->
                <div>
                    <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Sản phẩm
                    </label>
                    <select id="product_id" name="product_id"
                        class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        required>
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach ($dsShopProducts as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
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
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên tiêu đề</label>
                    <input value="{{ old('title') }}" type="text" name="title" id="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        placeholder="Nhập tên tiêu đề" required>
                </div>
                <div>
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nội dung</label>
                    <input value="{{ old('content') }}" type="text" name="content" id="content"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        placeholder="Nhập Nội dung" required>
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
                required: true,
            },
            image: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            }
            title: {
                required: true,
            },
            content: {
                required: true,
            }

        },
        messages: {
            product_id: {
                required: 'Vui lòng nhập tên sản phẩm.',
            },
            image: {
                required: 'Vui lòng chọn ảnh.',
                extension: 'Ảnh phải có định dạng: jpg, jpeg, png, gif.'
            }
            title: {
                required: 'Vui lòng nhập tiêu đề.',
            },
            content: {
                required: 'Vui lòng nhập nội dung.',
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
        @foreach ($dsShopProducPosts as $item)
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
        url: "{{ route('backend.ProductPost.store') }}", // ép dùng route POST
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
                        window.location.href = "{{ route('backend.ProductImg.index') }}";
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