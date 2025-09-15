<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderDetail extends Model
{
    protected $table = 'shop_order_details';
    protected $fillable =[
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount_percentage',
        'discount_amount',
        'order_detail_status',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[];
    protected $dateFormat ='Y-m-d H:i:s';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(ShopProduct::class,
         'product_id' ,'id');
    }

    // Mỗi review thuộc về 1 customer
    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id', 'id');
    }
}