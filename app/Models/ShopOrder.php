<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopPaymentType;
use App\Models\AclUser;
use App\Models\ShopCustomer;

class ShopOrder extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Payment status
    |--------------------------------------------------------------------------
    */

    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID   = 'paid';

    /*
    |--------------------------------------------------------------------------
    | Order status
    |--------------------------------------------------------------------------
    */

    const STATUS_PENDING   = 'Pending';
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_DELIVERED = 'Delivered';
    const STATUS_SHIPPED   = 'Shipped';
    const STATUS_COMPLETED = 'Completed';

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    protected $table = 'shop_orders';

    protected $primaryKey = 'id';

    /*
    |--------------------------------------------------------------------------
    | Mass assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'employee_id',
        'customer_id',
        'voucher_id',
        'voucher_discount',

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

        // Payment
        'payment_code',
        'payment_status',
        'paid_at',
        'sepay_transaction_id',

        // Legacy / existing payment fields
        'vnp_txn_ref',
        'paid_date',

        'order_status',

        'created_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Guarded
    |--------------------------------------------------------------------------
    */

    protected $guarded = [
        'id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'order_date' => 'datetime',
        'shipped_date' => 'datetime',
        'paid_date' => 'datetime',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'shipping_fee' => 'decimal:2',
        'voucher_discount' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Payment type
    |--------------------------------------------------------------------------
    */

    public function payment_type()
    {
        return $this->belongsTo(
            ShopPaymentType::class,
            'payment_type_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Employee / user
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            AclUser::class,
            'employee_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(
            ShopCustomer::class,
            'customer_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Order details
    |--------------------------------------------------------------------------
    */

    public function details()
    {
        return $this->hasMany(
            ShopOrderDetail::class,
            'order_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Subtotal
    |--------------------------------------------------------------------------
    */

    public function getSubtotalAttribute()
    {
        return $this->details->sum(function ($detail) {

            $priceAfterDiscount =
                $detail->unit_price -
                ($detail->discount_amount ?? 0);

            return $priceAfterDiscount * $detail->quantity;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Total
    |--------------------------------------------------------------------------
    */

    public function getTotalAttribute()
    {
        return max(
            $this->subtotal
                - ($this->voucher_discount ?? 0)
                + ($this->shipping_fee ?? 0),
            0
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Mark order as paid
    |--------------------------------------------------------------------------
    |
    | Dùng cho SePay sau khi webhook xác nhận tiền.
    |
    */

    public function markAsPaid(?string $sepayTransactionId = null): void
    {
        $this->payment_status = self::PAYMENT_PAID;

        // Field mới dành cho SePay
        $this->paid_at = now();

        // Giữ tương thích với hệ thống cũ
        $this->paid_date = now();

        if ($sepayTransactionId !== null) {
            $this->sepay_transaction_id = $sepayTransactionId;
        }

        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Check payment
    |--------------------------------------------------------------------------
    */

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isUnpaid(): bool
    {
        return $this->payment_status !== self::PAYMENT_PAID;
    }
}