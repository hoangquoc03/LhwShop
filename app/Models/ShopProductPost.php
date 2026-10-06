<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductPost extends Model
{
    protected $table = 'shop_posts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'post_slug',
        'post_title',
        'post_content',
        'post_except',
        'post_type',
        'post_status',
        'post_image',
        'user_id',
        'post_category_id',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }
}
