<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\ShopOrder;
use App\Models\ShopProductReview;
use App\Models\ShopCustomerVoucher;

class ShopCustomer extends Authenticatable
{
    protected $table = 'shop_customers';
    protected $fillable = [
        'username',
        'last_name',
        'first_name',
        'gender',
        'email',
        'birthday',
        'avatar',
        'code',
        'company',
        'phone',
        'billing_address',
        'shipping_address',
        'city',
        'state',
        'postal_code',
        'country',
        'remember_token',
        'activate_code',
        'status',
        'created_at',
        'updated_at',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $dates = [
        'birthday',
        'created_at',
        'updated_at'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    // Quan hệ
    public function orders()
    {
        return $this->hasMany(ShopOrder::class, 'customer_id','id');
    }

    public function reviews()
    {
        return $this->hasMany(ShopProductReview::class, 'customer_id','id');
    }
    public function carts()
    {
        return $this->hasMany(ShopCart::class, 'customer_id','id');
    }

    public function vouchers()
    {
        return $this->belongsToMany(
            ShopVoucher::class,
            'shop_customer_vouchers',   // bảng pivot
            'customer_id',             // khóa ngoại customer trong bảng pivot
            'voucher_id'               // khóa ngoại voucher trong bảng pivot
        )->withTimestamps();
    }


    // Getter password cho Auth
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Băm mật khẩu tự động
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
    public function getNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
    
}