@extends('backend/master')
@section('title')
Danh sách vai trò
@endsection
@section('main-content')
@php
    $role_id = request()->query('role_id');
@endphp
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Roles</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Danh sách các  vai trò</h1>
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
                    Vai trò mới
                </button>
            </div>
        </div>
    </div>
    <div class="flex flex-col" bis_skin_checked="1">
        <div class="overflow-x-auto" bis_skin_checked="1">
            <div class="inline-block min-w-full align-middle" bis_skin_checked="1">
                <div class="overflow-hidden shadow" bis_skin_checked="1">
<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="p-4 text-sm font-semibold text-left text-gray-600 uppercase dark:text-gray-300">Nhân viên</th>
            <th class="p-4 text-sm font-semibold text-left text-gray-600 uppercase dark:text-gray-300">Vai trò</th>
            <th class="p-4 text-sm font-semibold text-left text-gray-600 uppercase dark:text-gray-300">Hành động</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach ($AclUserHasRoles as $roleName => $permissions)
            <?php $roleItem = $permissions->first(); ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <!-- Vai trò -->
                <td class="p-4 text-base font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $roleName }}
                </td>

                <!-- Danh sách quyền -->
                <td class="p-4 text-sm text-gray-800 dark:text-gray-300" >
                    <ul class="list-none list-inside space-y-1">
                        @foreach ($permissions as $perm)
                            <li>
                                <input type="checkbox" disabled checked>
                                {{ $perm->permission->display_name }}
                            </li>
                        @endforeach
                    </ul>
                </td>

                <!-- Hành động -->
                <td class="p-4 space-x-2 whitespace-nowrap">
                    <!-- Button update -->
                    <button type="button"
                        data-drawer-target="drawer-update-role-{{ $roleItem->role_id }}"
                        data-drawer-show="drawer-update-role-{{ $roleItem->role_id }}"
                        aria-controls="drawer-update-role-{{ $roleItem->role_id }}"
                        data-drawer-placement="right"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                        data-role_name="{{ $roleName }}"
                        data-role_id="{{ $roleItem->role_id }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                        </svg>
                        Cập nhật quyền
                    </button>

                    <!-- Button delete -->
                    <button type="button"
                        class="btn-delete inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                        data-id="{{ $roleItem->role_id }}"
                        data-delete-url="{{ route('backend.acl_role_has_permissions.destroy', ['id' => $roleItem->role_id]) }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Xóa
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@foreach ($AclUserHasRoles as $roleName => $permissions)
    <?php $roleItem = $permissions->first(); ?>
    <div id="drawer-update-role-{{ $roleItem->role_id }}"
        class="open-update-drawer-btn fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full"
        tabindex="-1" aria-labelledby="drawer-label-role-{{ $roleItem->role_id }}" aria-hidden="true">

        <h5 id="drawer-label-role-{{ $roleItem->role_id }}" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">
            Cập nhật Vai trò - {{ $roleName }}
        </h5>

        <button type="button" data-drawer-dismiss="drawer-update-role-{{ $roleItem->role_id }}"
            aria-controls="drawer-update-role-{{ $roleItem->role_id }}"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <form action="{{ route('backend.UserRole.store') }}" method="POST">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">
            
            <select name="role_id" required>
                @foreach ($lstRoles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <button type="submit">Gán vai trò</button>
        </form>
    </div>
@endforeach

                </div>
            </div>
        </div>
    </div>
  

    <!-- Add Product Drawer -->
<div id="drawer-create-product-default" class="fixed top-0 right-0 z-40 w-full h-screen max-w-md p-6 overflow-y-auto transition-transform bg-white dark:bg-gray-800 translate-x-full" tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
    <h5 id="drawer-label" class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Cấp quyền cho vai trò
    </h5>
    <button type="button" data-drawer-dismiss="drawer-create-product-default" aria-controls="drawer-create-product-default"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-900 dark:hover:text-white">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6 6l8 8M6 14L14 6" clip-rule="evenodd" />
        </svg>
    </button>

    <form id="frmCreate" action="{{ route('backend.acl_role_has_permissions.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <!-- Vai trò -->
            <div>
                <label for="role_id" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Chọn vai trò</label>
                <select name="role_id" id="role_id" class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                    <option value="">-- Chọn --</option>
                    @foreach ($lstRoles as $role)
                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Danh sách quyền -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Chọn quyền</label>
                <div id="permission_id" class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach ($aclPermissions as $i => $item)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="permission_id[]" id="permission_id_{{ $i }}" value="{{ $item->id }}"
                                   class="rounded text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $item->display_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Nút -->
            <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-600">
                <button type="submit" class="bg-primary-700 text-white px-4 py-2 rounded hover:bg-primary-800 text-sm">
                    Lưu
                </button>
                <button type="button" data-drawer-dismiss="drawer-create-product-default" aria-controls="drawer-create-product-default"
                    class="border border-gray-300 text-gray-600 dark:text-gray-300 px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
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
    // Xử lý xóa bằng SweetAlert2
    $('.btn-delete').on('click', function (e) {
      e.preventDefault();
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
            success: function () {
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
    // Cập nhật checkbox khi chọn role từ dropdown
    $('#role_id').on('change', function () {
      const roleId = $(this).val();
      const apiUrl = `/api/v1/acl_role_has_permissions/getByRoleId/${roleId}`;

      $.ajax({
        method: 'GET',
        url: apiUrl,
      }).done(function (response) {
        const arrPermission = response.data || [];
        $("#permission_id input[type='checkbox']").each(function () {
          const value = Number($(this).val());
          $(this).prop('checked', arrPermission.includes(value));
        });
      });
    });

    // Auto-select role từ query string
    
    @if(!empty($role_id))
      $('#role_id').val({{ $role_id }});
    @endif
    $('#role_id').trigger('change');

    // Cập nhật checkbox khi mở drawer cập nhật role
    document.querySelectorAll('[data-drawer-show^="drawer-update-role-"]').forEach(button => {
    button.addEventListener('click', function () {
        const roleId = this.dataset.role_id;
        const drawerId = `drawer-update-role-${roleId}`;

        setTimeout(() => {
        const drawer = document.getElementById(drawerId);
        if (!drawer) return console.error("Không tìm thấy drawer", drawerId);

        const form = document.querySelector(`form[data-role-id="${roleId}"]`);
        console.log("📦 DOM Form:", form);
        if (!form) return console.error("Không tìm thấy form trong drawer", drawerId);

        const checkboxes = form.querySelectorAll(`input[type="checkbox"][name="permission_id[]"]`);
        checkboxes.forEach(cb => cb.checked = false);

            fetch(`/api/v1/acl_role_has_permissions/getByRoleId/${roleId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.statusCode === 200 && Array.isArray(data.data)) {
                        const checkboxes = form.querySelectorAll(`input[type="checkbox"][name="permission_id[]"]`);
                        checkboxes.forEach(cb => cb.checked = false); // reset

                        data.data.forEach(pid => {
                            const checkbox = Array.from(checkboxes).find(cb => Number(cb.value) === pid);
                            if (checkbox) {
                                console.log("✅ Tick quyền:", pid);
                                checkbox.checked = true;
                            } else {
                                console.warn("⚠️ Không tìm thấy checkbox cho quyền:", pid);
                            }
                        });
                    } else {
                        console.error('Không load được quyền:', data);
                    }
                })
                .catch(err => console.error('Lỗi API:', err));
        }, 300);
    });
    });

  });
</script>

@endsection
