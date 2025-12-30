<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'shop_product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'color',
        'size',
        'image',
        'price',
        'stock_quantity',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }
    public function carts()
    {
        return $this->hasMany(ShopCart::class, 'variant_id', 'id');
    }
    public function orderDetails()
    {
        return $this->hasMany(ShopOrderDetail::class, 'variant_id');
    }
}
