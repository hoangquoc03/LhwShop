<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  App\Models\ShopProduct;
class ShopProductDiscount extends Model
{
    protected $table = 'shop_product_discounts';
    protected $fillable =[
        'product_id',
        'discount_name',
        'discount_amount',
        'is_fixed',
        'start_date',
        'end_date',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[
        'start_date',
        'end_date',
    ];
    protected $dateFormat ='Y-m-d H:i:s';
    public $timestamps = false;
    public function product(){
        return $this->belongsTo(
            ShopProduct::class,
            'product_id' ,'id'
        );
    }
}