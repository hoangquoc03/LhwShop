@extends('backend/master')
@section('title')
    Danh sách Chuyên mục sản phẩm
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
                                    aria-current="page">Category</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tất cả chuyên mục sản phẩm</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                bis_skin_checked="1">
                <div class="flex items-center mb-4 sm:mb-0" bis_skin_checked="1">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="products-search" class="sr-only">Tìm kiếm</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96" bis_skin_checked="1">
                            <input type="text" name="email" id="products-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search for settings">
                        </div>
                    </form>
                    <div class="flex items-center w-full sm:justify-end" bis_skin_checked="1">
                        <div class="flex pl-2 space-x-1" bis_skin_checked="1">
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <button id="createProductButton"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                    type="button" data-drawer-target="drawer-create-product-default"
                    data-drawer-show="drawer-create-product-default" aria-controls="drawer-create-product-default"
                    data-drawer-placement="right">
                    Thêm chuyên mục
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
                                        <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Id
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ảnh
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Mã danh mục
                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Văn bản danh mục
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Mô tả
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ngày tạo
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hoạt Động
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                            @foreach ($dsShopCategories as $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center" bis_skin_checked="1">
                                            <input id="checkbox-633293" aria-describedby="checkbox-1" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-633293" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white"
                                            bis_skin_checked="1">{{ $item->id }}
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <img src="{{ Str::startsWith($item->image, ['http://', 'https://'])
                                            ? $item->image
                                            : asset('storage/uploads/categories/logo/' . $item->image) }}"
                                            alt="Product Image" class="w-16 h-16 object-cover rounded">
                                    </td>
                                    <td
                                        class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                        {{ $item->categories_code }}
                                    </td>

                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->categories_text }}</td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->description }}</td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->created_at->format('d/m/Y H:i:s') }}
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <button type="button" id="updateProductButton"
                                            data-drawer-target="drawer-update-product-{{ $item->id }}"
                                            data-drawer-show="drawer-update-product-{{ $item->id }}"
                                            aria-controls="drawer-update-product-{{ $item->id }}"
                                            data-drawer-placement="right"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                            data-id="{{ $item->id }}" data-image="{{ $item->image }}"
                                            data-categories_code="{{ $item->categories_code }}"
                                            data-categories_text="{{ $item->categories_text }}"
                                            data-description="{{ $item->description }}">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Cập nhật
                                        </button>

                                        <button type="button" id="deleteProductButton"
                                            class="btn-delete inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                            data-id="{{ $item->id }}"
                                            data-delete-url = "{{ route('backend.Category.destroy', ['id' => $item->id]) }}">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
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
                        @foreach ($dsShopCategories as $item)
                            <div id="drawer-update-product-{{ $item->id }}"
                                class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full"
                                tabindex="-1" aria-labelledby="drawer-label-{{ $item->id }}" bis_skin_checked="1"
                                aria-hidden="true">
                                <h5 id="drawer-label-{{ $item->id }}"
                                    class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                    Cập nhật danh mục- {{ $item->id }}</h5>
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
                                <form action="{{ route('backend.Category.update', ['id' => $item->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-4" bis_skin_checked="1">
                                        <div bis_skin_checked="1">
                                            <label for="categories_code"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mã
                                                danh mục</label>
                                            <input value="{{ $item->categories_code }}" type="text"
                                                name="categories_code" id="categories_code"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="categories_code" required="">
                                        </div>

                                        <div bis_skin_checked="1">
                                            <label for="categories_text"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Văn
                                                bản danh mục</label>
                                            <input value="{{ $item->categories_text }}" type="text"
                                                name="categories_text" id="categories_text"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="categories_text" required="">
                                        </div>

                                        <div>
                                            <label for="image-{{ $item->id }}"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình
                                                ảnh</label>
                                            <input type="file" name="image" id="update-image-{{ $item->id }}"
                                                accept="image/*" class="input border border-gray-300 text-sm rounded-lg">

                                            <img src="{{ asset('storage/uploads/categories/logo/' . $item->image) }}"
                                                data-default="{{ asset('storage/uploads/categories/logo/' . $item->image) }}"
                                                class="w-32 mt-2 preview-img-container"
                                                id="update-preview-img-{{ $item->id }}" alt="Xem trước ảnh">
                                        </div>
                                        <div class="mb-3">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hoặc
                                                nhập link ảnh</label>
                                            <input type="text" name="image_url"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="https://example.com/image.jpg"
                                                value="{{ old('image_url', $item->image) }}">
                                        </div>
                                        <div bis_skin_checked="1">
                                            <label for="description"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô
                                                tả</label>
                                            <input value="{{ $item->description }}" type="text" name="description"
                                                id="description"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="Description" required="">
                                        </div>
                                    </div>
                                    <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0"
                                        bis_skin_checked="1">
                                        <button data-url="{{ route('backend.Category.index') }}" type="submit"
                                            class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            Cập nhật
                                        </button>
                                        <button data-url="{{ route('backend.Category.index') }}" type="button"
                                            class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                </div>
            </div>
        </div>
    </div>
    <!-- Add Product Drawer -->
    <div id="drawer-create-product-default"
        class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full"
        tabindex="-1" aria-labelledby="drawer-label" bis_skin_checked="1" aria-hidden="true">
        <h5 id="drawer-label"
            class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Danh mục
            mới</h5>
        <button type="button" data-drawer-dismiss="drawer-create-product-default"
            aria-controls="drawer-create-product-default"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <form id ="frmCreate" action="{{ route('backend.Category.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="space-y-4" bis_skin_checked="1">
                <div class="space-y-4" bis_skin_checked="1">
                    <div bis_skin_checked="1">
                        <label for="categories_code"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mã danh mục</label>
                        <input value="{{ old('categories_code') }}" type="text" name="categories_code"
                            id="categories_code"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="categories_code" required="">
                    </div>



                    <div bis_skin_checked="1">
                        <label for="categories_text"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Văn bản danh mục</label>
                        <input value="{{ old('categories_text') }}" type="text" name="categories_text"
                            id="categories_text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="categories_text" required="">
                    </div>

                    <div>
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình
                            ảnh</label>
                        <input type="file" name="image" id="create-image" accept="image/*"
                            class="input border border-gray-300 text-sm rounded-lg">

                        <img src="{{ asset('static/dist/images/default-image.jpg') }}"
                            data-default="{{ asset('static/dist/images/default-image.jpg') }}"
                            class="w-32 mt-2 preview-img-container" id="create-preview-img" alt="Xem trước ảnh">

                    </div>


                    <div bis_skin_checked="1">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô
                            tả</label>
                        <input value="{{ old('description') }}" type="text" name="description" id="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Description" required="">
                    </div>
                    <div class="bottom-0 left-0 flex justify-center w-full pb-4 space-x-4 md:px-4 md:absolute"
                        bis_skin_checked="1">
                        <button data-url="{{ route('backend.Category.index') }}" type="submit"
                            class="text-white w-full justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Thêm danh mục
                        </button>
                        <button data-url="{{ route('backend.Category.index') }}" type="button"
                            data-drawer-dismiss="drawer-create-product-default"
                            aria-controls="drawer-create-product-default"
                            class="inline-flex w-full justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
            $('#frmCreate').validate({
                rules: {
                    categories_code: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    categories_text: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    description: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    image: {
                        required: true,
                        extension: "jpg|jpeg|png|gif"
                    },

                },
                messages: {
                    categories_code: {
                        required: 'Vui lòng nhập mã danh mục.',
                        minlength: 'Mã danh mục phải từ 3 ký tự trở lên.',
                        maxlength: 'Mã danh mục phải dưới 100 ký tự.'
                    },
                    categories_text: {
                        required: 'Vui lòng nhập văn bản danh mục.',
                        minlength: 'Văn bản danh mục phải từ 3 ký tự trở lên.',
                        maxlength: 'Văn bản danh mục phải dưới 100 ký tự.'
                    },
                    image: {
                        required: 'Vui lòng chọn ảnh .'
                    },
                    description: {
                        required: 'Vui lòng nhập mô tả.'
                    },
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
            @foreach ($dsShopCategories as $item)
                const fileInput{{ $item->id }} = document.getElementById("update-image-{{ $item->id }}");
                const img{{ $item->id }} = document.getElementById("update-preview-img-{{ $item->id }}");

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
@endsection
