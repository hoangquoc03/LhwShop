<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductReview extends Model
{
    protected $table = 'shop_product_reviews';
    protected $fillable =[
        'product_id',
        'customer_id',
        'rating',
        'comment',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[
        'created_at',
        'updated_at',
    ];
    protected $dateFormat ='Y-m-d H:i:s';
    public function product()
    {
        return $this->belongsTo(ShopProduct::class,
         'product_id' ,'id');
    }

    // Mỗi review thuộc về 1 customer
    public function customer()
    {
        return $this->belongsTo(ShopCustomer::class,
         'customer_id','id');
    }
}