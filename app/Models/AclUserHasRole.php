<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AclUser;
use App\Models\AclRole;
class AclUserHasRole extends Model
{
    protected $table = 'acl_user_has_roles';
    protected $fillable =[
        'user_id',
        'role_id',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[];
    protected $dateFormat ='Y-m-d H:i:s';

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(
            AclUser::class,
            'user_id','id'
        );
    }
    public function role(){
        return $this->belongsTo(
            AclRole::class,
            'role_id','id'
        );
    }
}