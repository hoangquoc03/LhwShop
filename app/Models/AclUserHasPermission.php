<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use  App\Models\AclUser;
use  App\Models\AclPermission;
class AclUserHasPermission extends Model
{
     protected $table = 'acl_user_has_permissions';
    protected $fillable =[
        'user_id',
        'permission_id',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[];
    protected $dateFormat ='Y-m-d H:i:s';

    public function permission(){
        return $this->belongsTo(
            AclPermission::class,
            'permission_id','id'
        );
    }
    public function user(){
        return $this->belongsTo(
            AclUser::class,
            'user_id','id'
        );
    }
}