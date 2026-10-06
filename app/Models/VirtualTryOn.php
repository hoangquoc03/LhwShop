<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualTryOn extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'person_image',
        'result_image'
    ];

    public function user()
    {
        return $this->belongsTo(ShopCustomer::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }
}
