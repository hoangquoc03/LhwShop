<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopPaymentType;
use App\Models\AclUser;
use App\Models\ShopCustomer;

class ShopOrder extends Model
{
    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID   = 'paid';
    const STATUS_PENDING   = 'Pending';
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_DELIVERED = 'Delivered';
    const STATUS_SHIPPED   = 'Shipped';
    const STATUS_COMPLETED = 'Completed';
    protected $table = 'shop_orders';
    protected $fillable = [
        'employee_id',
        'customer_id',
        'order_date',
        'shipped_date',
        'ship_name',
        'ship_phone',
        'ship_address1',
        'ship_address2',
        'ship_city',
        'ship_state',
        'ship_postal_code',
        'ship_country',
        'shipping_fee',
        'payment_type_id',
        'payment_status',
        'paid_date',
        'postal_code',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates = [
        'order_date',
        'shipped_date',
        'paid_date',
        'created_at',
        'updated_at'
    ];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function payment_type()
    {
        return $this->belongsTo(
            ShopPaymentType::class,
            'payment_type_id',
            'id'
        );
    }
    public function user()
    {
        return $this->belongsTo(
            AclUser::class,
            'employee_id',
            'id'
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            ShopCustomer::class,
            'customer_id',
            'id'
        );
    }
    public function details()
    {
        return $this->hasMany(ShopOrderDetail::class, 'order_id', 'id');
    }
    // App\Models\ShopOrder.php
    public function getSubtotalAttribute()
    {
        return $this->details->sum(function ($d) {
            $priceAfterDiscount =
                $d->unit_price - ($d->discount_amount ?? 0);

            return $priceAfterDiscount * $d->quantity;
        });
    }


    public function getTotalAttribute()
    {
        return $this->subtotal + $this->shipping_fee;
    }
}
