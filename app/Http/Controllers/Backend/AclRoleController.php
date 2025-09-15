<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AclRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AclRoleController extends Controller
{
    public function index(Request $request)
    {
        $query = AclRole::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('display_name', 'like', '%' . $keyword . '%');
            });
        }

        $dsAclRoles = $query->paginate(5);

        return view('backend.acl_role.index', [
            'dsAclRoles' => $dsAclRoles
        ]);
    }
    public function store(Request $request)
    {
        // Validate dữ liệu nhập vào cho khách hàng
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|min:3|max:100|unique:acl_roles,name',
            'display_name' => 'required|string|min:1|max:100',
            'guard_name'   => 'required|string|min:1|max:100',
        ], [
            'name.required'         => 'Tên đăng nhập là bắt buộc.',
            'name.unique'           => 'Tên đăng nhập đã tồn tại.',
            'display_name.required' => 'Tên hiển thị là bắt buộc.',
            'guard_name.required'   => 'Guard name là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo khách hàng mới
        $customer = new AclRole();
        $customer->name   = $request->name;
        $customer->display_name  = $request->display_name;
        $customer->guard_name = $request->guard_name;
        $customer->save();

        toastify()->success('Thêm vai trò thành công');
        return redirect()->route('backend.AclRole.index');
    }
    public function update(Request $request, $id)
    {
        $customer = AclRole::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|min:3|max:100|unique:acl_roles,name,'. $id,
            'display_name' => 'required|string|min:1|max:100',
            'guard_name'   => 'required|string|min:1|max:100',
        ], [
            'name.required'         => 'Tên đăng nhập là bắt buộc.',
            'name.unique'           => 'Tên đăng nhập đã tồn tại.',
            'display_name.required' => 'Tên hiển thị là bắt buộc.',
            'guard_name.required'   => 'Guard name là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cập nhật dữ liệu
        $customer->name   = $request->name;
        $customer->display_name  = $request->display_name;
        $customer->guard_name = $request->guard_name;
        $customer->save();

        toastify()->success('Cập nhật vai trò thành công');
        return redirect()->route('backend.AclRole.index');
    }
    public function destroy(Request $request, $id)
    {
        $customer = AclRole::find($id);
        $customer->delete();
        return redirect()->route('backend.AclRole.index');
    }
    public function batchDelete(Request $request)
    {
        $listSelectedIds = $request->listSelectedIds ?? [];

        foreach ($listSelectedIds as $id) {
            $customer = AclRole::find($id);
             $customer->delete();

        }
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa khách hàng thành công',
            'list_deleted_ids' => $listSelectedIds
        ]);
    }
}