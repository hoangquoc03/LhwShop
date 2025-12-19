<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopProduct;
use App\Models\ShopSupplier;

class ShopCategory extends Model
{
    protected $table = 'shop_categories';
    protected $fillable = [
        'categories_code',
        'categories_text',
        'description',
        'image',
        'parent_id',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function products()
    {
        return $this->hasMany(
            ShopProduct::class,
            'category_id',
            'id'
        );
    }
    public function suppliers()
    {
        return $this->hasManyThrough(
            ShopSupplier::class,
            ShopProduct::class,
            'category_id',    // FK ở shop_products
            'id',             // PK ở shop_suppliers
            'id',             // PK ở shop_categories
            'supplier_id'     // FK ở shop_products
        )
            ->select('shop_suppliers.id', 'shop_suppliers.supplier_text', 'shop_suppliers.image')
            ->distinct();
    }
}
