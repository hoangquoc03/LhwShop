<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopPostCategory;
use App\Models\AclUser;
class ShopPost extends Model
{
    protected $table = 'shop_posts';
    protected $fillable =[
        'post_slug',
        'post_title',
        'post_content',
        'post_excerpt',
        'post_type',
        'post_status',
        'post_image',
        'user_id',
        'post_category_id',
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

    public function post_category(){
        return $this->belongsTo(
            ShopPostCategory::class,
            'post_category_id' ,'id'
        );
    }
    public function user(){
        return $this->belongsTo(
            AclUser::class,
            'user_id' ,'id'
        );
    }
}