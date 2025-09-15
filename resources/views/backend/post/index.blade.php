@extends('backend/master')
@section('title')
Danh sách bài viết
@endsection
@section('main-content')
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
                        {{-- <li>
                            <div class="flex items-center" bis_skin_checked="1">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">E-commerce</a>
                            </div>
                        </li> --}}
                        <li>
                            <div class="flex items-center" bis_skin_checked="1">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Settings</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tất cả bài đăng</h1>
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
                    Bài viết mới
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
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Id
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hình ảnh
                                </th>
                                {{-- <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Slug
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Tiêu đề
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Nội dung
                                </th> --}}
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Loại bài viết
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Trạng thái
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Tác giả
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Chuyên mục
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Ngày cập nhật
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($lstPost as $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    {{-- Checkbox --}}
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-{{ $item->id }}" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-{{ $item->id }}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>

                                    {{-- ID --}}
                                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $item->id }}</div>
                                    </td>

                                    {{-- Image --}}
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <img src="/storage/uploads/posts/images/{{ $item->post_image }}" alt="Post Image" class="w-16 h-16 object-cover rounded">
                                    </td>

                                    {{-- Slug --}}
                                    <span class="hidden view-field-slug-{{ $item->id }}">{{ $item->post_slug }}</span>

                                    {{-- Title --}}
                                    <span class="hidden view-field-title-{{ $item->id }}">{{ $item->post_title }}</span>

                                    {{-- Content --}}
                                    <span class="hidden view-field-content-{{ $item->id }}">{{ $item->post_content }}</span>

                                    {{-- Type --}}
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->post_type }}
                                    </td>

                                    {{-- Trạng thái màu sắc --}}
                                    <td class="p-4 text-base font-semibold whitespace-nowrap">
                                        @if ($item->post_status === 'published')
                                            <span class="text-green-600 dark:text-green-400">Đã đăng</span>
                                        @elseif ($item->post_status === 'pending')
                                            <span class="text-yellow-600 dark:text-yellow-500">Chờ duyệt</span>
                                        @elseif ($item->post_status === 'draft')
                                            <span class="text-gray-500 dark:text-gray-500">Bản nháp</span>
                                        @endif
                                    </td>

                                    {{-- Lấy thông tin user, category, thời gian --}}
                                    @php
                                        $userName = optional($item->user)->last_name . ' ' . optional($item->user)->first_name;
                                        $category = optional($item->post_category)->post_category_name;
                                        $createdAt = $item->created_at->format('d/m/Y H:i:s');
                                    @endphp

                                    {{-- Người đăng --}}
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $userName }}</td>

                                    {{-- Danh mục --}}
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $category }}</td>

                                    {{-- Ngày tạo --}}
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $createdAt }}</td>

                                    {{-- Action --}}
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button"
                                                data-view-id="{{ $item->id }}"
                                                class="btn-view inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-600">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zM10 15a5 5 0 110-10 5 5 0 010 10z"/>
                                                    <path d="M10 7a3 3 0 100 6 3 3 0 000-6z"/>
                                                </svg>
                                                Xem
                                            </button>
                                            {{-- Update --}}
                                            <button type="button" id="updateProductButton" 
                                                data-drawer-target="drawer-update-product-{{ $item->id }}"
                                                data-drawer-show="drawer-update-product-{{ $item->id }}"
                                                aria-controls="drawer-update-product-{{ $item->id }}"
                                                data-drawer-placement="right" 
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                                data-post_image="{{ $item->post_image }}"
                                                data-post_slug="{{ $item->post_slug }}"
                                                data-post_title="{{ $item->post_title }}"
                                                data-post_type="{{ $item->post_type }}"
                                                data-post_status="{{ $item->post_status }}">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Cập nhật
                                            </button>

                                            {{-- Delete --}}
                                            <button type="button" id="deleteProductButton" 
                                                class="btn-delete inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                                data-id="{{ $item->id }}"
                                                data-delete-url="{{ route('backend.post.destroy', ['id' => $item->id]) }}">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                Xóa
                                            </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @foreach ($lstPost as $item)
                        <div id="drawer-update-product-{{ $item->id }}" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label-{{ $item->id }}" bis_skin_checked="1" aria-hidden="true">
                                <h5 id="drawer-label-{{ $item->id }}" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
                                Cập nhật bài đăng - {{ $item->id }}</h5>
                            <button type="button" data-drawer-dismiss="drawer-update-product-{{ $item->id }}" aria-controls="drawer-update-product-{{ $item->id }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close menu</span>
                            </button>
                            <form action="{{ route('backend.post.update',['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4" bis_skin_checked="1">
                                    <div bis_skin_checked="1">
                                        <label for="post_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tiêu đề</label>
                                        <input value="{{ $item->post_title }}" type="text" name="post_title" id="post_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Group" required="">
                                    </div>

                                    <div bis_skin_checked="1">
                                        <label for="post_slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
                                        <input value="{{ $item->post_slug }}" type="text" name="post_slug" id="post_slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Key" required="">
                                    </div>

                                    <div bis_skin_checked="1">
                                        <label for="post_content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nội dung</label>
                                        <textarea name="post_content" id="editor-{{ $item->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{ $item->post_content }}</textarea>
                                    </div>
                                

                                    <div>
                                        <label for="post_image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình ảnh</label>
                                        <input type="file" name="post_image" id="post_image" accept="image/*"
                                            class="input border border-gray-300 text-sm rounded-lg">
                                        @if ($item->post_image)
                                            <img src="/storage/uploads/posts/images/{{ $item->post_image }}" class="w-32 mt-2" alt="Ảnh hiện tại">
                                        @endif
                                    </div>
                                    {{-- <div>
                                        <label for="post_image-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình ảnh</label>
                                        <input type="file" name="image" id="update-image-{{ $item->id }}" accept="image/*"
                                            class="input border border-gray-300 text-sm rounded-lg w-full p-2.5">
                                        <img src="{{ asset('storage/uploads/posts/images/' . $item->post_image) }}"
                                            data-default="{{ asset('storage/uploads/posts/images/' . $item->post_image) }}"
                                            class="w-32 mt-2 preview-img-container"
                                            id="update-preview-img-{{ $item->id }}"
                                            alt="Xem trước ảnh">
                                    </div> --}}

                                    <div>
                                        <label for="post_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Loại bài viết</label>
                                        <select value="{{ $item->post_type}}" name="post_type" id="post_type" class="input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="news" @selected(old('post_type', $item->post_type) === 'news')>Tin tức</option>
                                            <option value="blog" @selected(old('post_type', $item->post_type) === 'blog')>Blog</option>
                                            <!-- thêm nếu có -->
                                        </select>
                                    </div>

                                    <div>
                                        <label for="post_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng thái</label>
                                        <select value="{{ $item->post_status}}" name="post_status" id="post_status" class="input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="draft" @selected($item->post_status === 'draft')>Nháp</option>
                                            <option value="publish" @selected($item->post_status === 'publish')>Đã đăng</option>
                                        </select>
                                    </div>                
                                </div> 
                                <div>
                                    <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tác giả</label>
                                    <select value="{{ $item->user_id}}" name="user_id" class="input-style bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        @foreach ( $lstUser as  $User)
                                            <option value="{{ $User->id }}">{{ $User->last_name }} {{ $User->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="post_category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chọn danh mục</label>
                                    <select value="{{ $item->post_category_id}}" name="post_category_id" class="input-style bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->post_category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0" bis_skin_checked="1">
                                    <button data-url="{{ route('backend.post.index') }}" type="submit" class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Cập nhật
                                    </button>
                                    <button data-url="{{ route('backend.post.index') }}" type="button" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Xóa
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
                            <div class="max-w-lg p-6 mx-auto mt-24 bg-white rounded shadow-lg dark:bg-gray-800">
                                <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-100">Chi tiết bài viết</h2>
                                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-200">
                                    <div><strong>ID:</strong> <span id="view-id"></span></div>
                                    <div><strong>Tiêu đề:</strong> <span id="view-title"></span></div>
                                    <div><strong>Slug:</strong> <span id="view-slug"></span></div>
                                    <div><strong>Nội dung:</strong> <span id="view-content"></span></div>
                                </div>
                                <div class="mt-6 text-right">
                                    <button onclick="document.getElementById('viewModal').classList.add('hidden')"
                                        class="px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
                                        Đóng
                                    </button>
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
<div id="drawer-create-product-default" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
    <h5 id="drawer-label" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
        Bài viết mới
    </h5>
    <button type="button" data-drawer-dismiss="drawer-create-product-default" aria-controls="drawer-create-product-default" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>

    <form id="frmCreate" action="{{ route('backend.post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="post_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tiêu đề</label>
                <input value="{{ old('post_title') }}" type="text" name="post_title" id="post_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tiêu đề bài viết" required>
            </div>

            {{-- <div>
                <label for="post_content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nội Dung</label>
                <input value="{{ old('post_content') }}" type="text" name="post_content" id="post_content" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tiêu đề bài viết" required>
            </div> --}}
            <div bis_skin_checked="1">
                <label for="post_content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nội dung</label>
                <textarea value="{{ old('post_content') }}" name="post_content" id="editor-{{ $item->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{ $item->post_content }}</textarea>
            </div>

            <div>
                <label for="post_slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Địa chỉ bài viết</label>
                <input value="{{ old('post_slug') }}" type="text" name="post_slug" id="post_slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="post-tieu-de" required>
            </div>

            <div>
                <label for="post_image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hình ảnh</label>
                <input type="file" name="post_image" id="post_image" accept="image/*"
                    class="input border border-gray-300 text-sm rounded-lg">
            </div>

            <div>
                <label for="post_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Loại bài viết</label>
                <select name="post_type" id="post_type" class="input-style bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    <option value="blog" {{ old('post_type') == 'blog' ? 'selected' : '' }}>Blog</option>
                    <option value="news" {{ old('post_type') == 'news' ? 'selected' : '' }}>Tin tức</option>
                </select>
            </div>
            <div>
                <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tác giả</label>
                <select name="user_id" class="input-style bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    @foreach ( $lstUser as  $User)
                        <option value="{{ $User->id }}">{{ $User->last_name }} {{ $User->first_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="post_category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chọn danh mục</label>
                <select name="post_category_id" class="input-style bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->post_category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="post_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng thái</label>
                <select name="post_status" id="post_status" class="input-style bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    <option value="draft" {{ old('post_status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="published" {{ old('post_status') == 'published' ? 'selected' : '' }}>Xuất bản</option>
                </select>
            </div>

            <div class="bottom-0 left-0 flex justify-center w-full pb-4 space-x-4 md:px-4 md:absolute" bis_skin_checked="1">
                    <button data-url="{{ route('backend.post.index') }}" type="submit" class="text-white w-full justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Thêm bài viết
                    </button>
                    <button data-url="{{ route('backend.post.index') }}" type="button" data-drawer-dismiss="drawer-create-product-default" aria-controls="drawer-create-product-default" class="inline-flex w-full justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Hủy
                    </button>
            </div>
        </div>
    </form>
</div>

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

@endsection

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
            post_title: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            post_slug: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            post_image: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            },
            post_type: {
                required: true
            },
            post_status: {
                required: true
            }
        },
        messages: {
            post_title: {
                required: 'Vui lòng nhập tiêu đề.',
                minlength: 'Tiêu đề phải từ 3 ký tự trở lên.',
                maxlength: 'Tiêu đề phải dưới 100 ký tự.'
            },
            post_slug: {
                required: 'Vui lòng nhập slug.',
                minlength: 'Slug phải từ 3 ký tự trở lên.',
                maxlength: 'Slug phải dưới 100 ký tự.'
            },
            post_image: {
                required: 'Vui lòng chọn ảnh bài viết.'
            },
            post_type: {
                required: 'Vui lòng chọn loại bài viết.'
            },
            post_status: {
                required: 'Vui lòng chọn trạng thái bài viết.'
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
   document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-view-id');
            document.getElementById('view-id').textContent = id;
            document.getElementById('view-title').textContent = document.querySelector('.view-field-title-' + id)?.textContent || '---';
            document.getElementById('view-slug').textContent = document.querySelector('.view-field-slug-' + id)?.textContent || '---';
            document.getElementById('view-content').textContent = document.querySelector('.view-field-content-' + id)?.textContent || '---';

            document.getElementById('viewModal').classList.remove('hidden');
        });
    });
</script>
@endsection
