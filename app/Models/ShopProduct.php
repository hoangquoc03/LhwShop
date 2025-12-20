<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopProductImage;
use App\Models\ShopProductDiscount;
use App\Models\ShopCategory;
use App\Models\ShopSupplier;
use App\Models\ShopProductReview;
use App\Models\ProductVariant;

class ShopProduct extends Model
{
    protected $table = 'shop_products';
    protected $fillable = [
        'product_code',
        'product_name',
        'image',
        'short_description',
        'description',
        'standard_cost',
        'list_price',
        'quantity_per_unit',
        'discontinued',
        'is_featured',
        'is_new',
        'category_id',
        'supplier_id',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function images()
    {
        return $this->hasMany(
            ShopProductImage::class,
            'product_id',
            'id'
        );
    }
    public function variants()
    {
        return $this->hasMany(
            ProductVariant::class,
            'product_id',
            'id'
        );
    }
    public function posts()
    {
        return $this->hasMany(
            ShopProductPost::class,
            'product_id',
            'id'
        );
    }
    public function discounts()
    {
        return $this->hasMany(
            ShopProductDiscount::class,
            'product_id',
            'id'
        );
    }
    public function reviews()
    {
        return $this->hasMany(
            ShopProductReview::class,
            'product_id',
            'id'
        );
    }
    public function orders()
    {
        return $this->hasMany(
            ShopOrderDetail::class,
            'product_id',
            'id'
        );
    }
    public function vouchers()
    {
        return $this->hasMany(
            ShopProductVoucher::class,
            'product_id',
            'id'
        );
    }
    public function carts()
    {
        return $this->hasMany(ShopCart::class, 'product_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(
            ShopCategory::class,
            'category_id',
            'id'
        );
    }
    public function supplier()
    {
        return $this->belongsTo(
            ShopSupplier::class,
            'supplier_id',
            'id'
        );
    }
    public function exportDetails()
    {
        return $this->hasMany(ShopExportDetail::class, 'product_id');
    }

    public function importDetails()
    {
        return $this->hasMany(\App\Models\ShopImportDetail::class, 'product_id');
    }

    public function discount()
    {
        return $this->hasOne(
            ShopProductDiscount::class,
            'product_id',
            'id'
        )
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderByDesc('start_date');
    }


    public function getDiscountPercentAttribute()
    {
        if (!$this->discount || !$this->list_price) {
            return 0;
        }

        // Giảm theo %
        if (!$this->discount->is_fixed) {
            return (int) round($this->discount->discount_amount);
        }

        // Giảm theo số tiền
        return (int) round(
            ($this->discount->discount_amount / $this->list_price) * 100
        );
    }
}
