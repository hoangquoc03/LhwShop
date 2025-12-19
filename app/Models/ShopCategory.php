<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopProduct;

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
    public function parent()
    {
        return $this->belongsTo(ShopCategory::class, 'parent_id');
    }

    // Danh mục con
    public function children()
    {
        return $this->hasMany(ShopCategory::class, 'parent_id');
    }
}
