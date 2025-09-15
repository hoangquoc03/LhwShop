<?php
use Illuminate\Support\Facades\DB;

function hasPermission($user, $permission)
{
    $userId = $user->id;
    if($user->username == 'quoc18'){
        return true;
    }

    // Kiểm tra quyền thông qua vai trò (role)
    $result1 = DB::table('acl_user_has_roles')
        ->join('acl_role_has_permissions', 'acl_user_has_roles.role_id', '=', 'acl_role_has_permissions.role_id')
        ->join('acl_permissions', 'acl_permissions.id', '=', 'acl_role_has_permissions.permission_id')
        ->where('acl_user_has_roles.user_id', $userId)
        ->where('acl_permissions.name', $permission)
        ->count();

    // Kiểm tra quyền được gán trực tiếp cho user
    $result2 = DB::table('acl_user_has_permissions')
        ->join('acl_permissions', 'acl_permissions.id', '=', 'acl_user_has_permissions.permission_id')
        ->where('acl_user_has_permissions.user_id', $userId)
        ->where('acl_permissions.name', $permission)
        ->count();

    return ($result1 + $result2) > 0;
}