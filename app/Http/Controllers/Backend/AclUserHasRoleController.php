<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AclRoleHasPermission;
use App\Models\AclUser;
use App\Models\AclRole;

use App\Models\AclUserHasRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AclUserHasRoleController extends Controller
{
    public function index()
    {
        $lstAclUsers = AclUser::all();
        $lstRoles = AclRole::all();

        // Lấy danh sách role + quyền, group theo role_name
        $AclUserHasRoles = AclRoleHasPermission::with(['role', 'permission'])
            ->get()
            ->groupBy(function ($item) {
                return $item->role->name; // group theo tên role
            });

        return view('backend.acl_user_has_roles.index')
            ->with('lstAclUsers', $lstAclUsers)
            ->with('AclUserHasRoles', $AclUserHasRoles)
            ->with('lstRoles', $lstRoles);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required',
            'role_id'  => 'required',
        ], [
            'user_id.required'    => 'Nhân viên không được để trống.',
            'role_id.required'    => 'Vai trò không được để trống.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = new AclUserHasRole();
        $order->user_id      = $request->user_id;
        $order->role_id  = $request->role_id;
        $order->save();

        toastify()->success('Thêm vai trò nhân viên thành công');
        return redirect()->route('backend.UserRole.index');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required',
            'role_id'  => 'required',
        ], [
            'user_id.required'    => 'Nhân viên không được để trống.',
            'role_id.required'    => 'Vai trò không được để trống.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = AclUserHasRole::findOrFail($id);

        $order->user_id      = $request->user_id;
        $order->role_id  = $request->role_id;
        $order->save();

        toastify()->success('Cập nhật đơn hàng thành công');
        return redirect()->route('backend.UserRole.index');
    }

    public function destroy($id)
    {
        $order = AclUserHasRole::findOrFail($id);
        $order->delete();
        toastify()->success('Xóa đơn hàng thành công');
        return redirect()->route('backend.UserRole.index');
    }
}