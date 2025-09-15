<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AclRoleHasPermission;
use App\Models\AclRole;
use App\Models\AclPermission;
use App\Models\AclUserHasPermission;
class AclRoleHasPermissionController extends Controller
{
    public function index(){
        // $aclRoleHasPermissions = AclRoleHasPermission::all();
        $aclRoleHasPermissions = AclRoleHasPermission::with('role')
        ->with('permission')
        ->get();

        $groupedAclRoleHasPermissions = $aclRoleHasPermissions->groupBy('role.display_name');
        $lstRoles = AclRole::all();
        $aclPermissions = AclPermission::all();
        return view('backend.acl_role_has_permissions.index', compact(
        'groupedAclRoleHasPermissions',
        'lstRoles',
        'aclPermissions'
        ));
    }
    public function getByRoleId($role_id)
    {
        try {
            if (!is_numeric($role_id)) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'Role ID không hợp lệ'
                ], 400);
            }

            $aclRoleHasPermissions = AclRoleHasPermission::where('role_id', $role_id)
                ->pluck('permission_id')
                ->toArray();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Đã lấy dữ liệu thành công',
                'data' => $aclRoleHasPermissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request){
        if (!isset($request->permission_id) || empty($request->permission_id)) {
            $lstAclRoleHasPermissions = AclRoleHasPermission::where('role_id', $request->role_id)->get();
            foreach ($lstAclRoleHasPermissions as $auhr) {
                $auhr->delete();
            }
            return redirect(route('backend.acl_role_has_permissions.index'));
        }
        else {
            $lstAclRoleHasPermissions = AclRoleHasPermission::where('role_id',
            $request->role_id)->get();
            foreach($lstAclRoleHasPermissions as $auhr){
                if(!in_array($auhr->permission_id,$request->permission_id)){
                    $auhr->delete();
                }
            }
            $arrPermissionIdInDb = $lstAclRoleHasPermissions->pluck
            ('permission_id')->toArray();
            foreach($request->permission_id as $permission_id){
                if(!in_array($permission_id,$arrPermissionIdInDb)){
                    $newModel = new AclRoleHasPermission();
                    $newModel->role_id = $request->role_id;
                    $newModel->permission_id =$permission_id;
                    $newModel->save();
                    toastify()->success('Cập nhật thành công');
                }
            }
            return redirect(route('backend.acl_role_has_permissions.index'));
        }
        
    }
    public function destroy($id)
    {
        AclRoleHasPermission::where('role_id', $id)->delete(); // Xóa theo vai trò
        toastify()->success('Đã xóa quyền của vai trò thành công');
        return redirect()->route('backend.acl_role_has_permissions.index');
    }
    
}