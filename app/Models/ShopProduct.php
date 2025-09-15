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
    protected $fillable =[
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
    protected $dates =[
        'created_at',
        'updated_at'
    ];
    protected $dateFormat ='Y-m-d H:i:s';
    
    public function images(){
        return $this->hasMany(
            ShopProductImage::class,
            'product_id' ,'id'
        );
    }
    public function variants(){
        return $this->hasMany(
            ProductVariant::class,
            'product_id' ,'id'
        );
    }
    public function discounts(){
        return $this->hasMany(
            ShopProductDiscount::class,
            'product_id' ,'id'
        );
    }
    public function reviews(){
        return $this->hasMany(
            ShopProductReview::class,
            'product_id' ,'id'
        );
    }
    public function orders(){
        return $this->hasMany(
            ShopOrderDetail::class,
            'product_id' ,'id'
        );
    }
    public function vouchers(){
        return $this->hasMany(
            ShopProductVoucher::class,
            'product_id' ,'id'
        );
    }
    public function category(){
        return $this->belongsTo(
            ShopCategory::class,
            'category_id' ,'id'
        );
    }
    public function supplier(){
        return $this->belongsTo(
            ShopSupplier::class,
            'supplier_id' ,'id'
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
        return $this->hasOne(ShopProductDiscount::class, 'product_id')
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->latestOfMany(); // lấy discount mới nhất
    }

}