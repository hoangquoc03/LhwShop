<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductPost extends Model
{
    protected $table = 'shop_product_posts';

    protected $fillable = [
        'product_id',
        'title',
        'content',
        'image',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[];
    protected $dateFormat ='Y-m-d H:i:s';
    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }
}