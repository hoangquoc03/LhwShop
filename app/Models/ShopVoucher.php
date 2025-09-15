<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopProductVoucher;
use App\Models\ShopCustomerVoucher;
class ShopVoucher extends Model
{
    protected $table = 'shop_vouchers';
    protected $fillable =[
        'voucher_code',
        'voucher_name',
        'description',
        'uses',
        'max_uses',
        'max_uses_user',
        'type',
        //'discount_amount',
        'is_fixed',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dateFormat ='Y-m-d H:i:s';

    public function products(){
        return $this->hasMany(
            ShopProductVoucher::class,
            'voucher_id' ,'id'
        );
    }
    public function customers()
    {
        return $this->belongsToMany(
            ShopCustomer::class,
            'shop_customer_vouchers',
            'voucher_id',
            'customer_id'
        )->withTimestamps();
    }
}