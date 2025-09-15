<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AclRoleHasPermission;
use App\Models\AclUserHasRole;
class AclRole extends Model
{
    protected $table = 'acl_roles';
    protected $fillable =[
        'name',
        'display_name',
        'guard_name',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[
        'created_at',
        'updated_at'
    ];
    protected $dateFormat ='Y-m-d H:i:s';

    public function users(){
        return $this->hasMany(
            AclUserHasRole::class,
            'role_id' ,'id'
        );
    }
    public function permissions(){
        return $this->hasMany(
            AclRoleHasPermission::class,
            'permission_id' ,'id'
        );
    }
}