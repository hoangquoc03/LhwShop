<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopVoucher;
class ShopCustomerVoucher extends Model
{
    protected $table = 'shop_customer_vouchers';
    protected $fillable =[
        'customer_id',
        'voucher_id',
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
    public function voucher(){
        return $this->belongsTo(
            ShopVoucher::class,
            'voucher_id' ,'id'
        );
    }
    public function customer(){
        return $this->belongsTo(
            ShopCustomer::class,
            'customer_id' ,'id'
        );
    }
}