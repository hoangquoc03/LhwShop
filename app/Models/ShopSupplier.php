<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopProduct;
class ShopSupplier extends Model
{
    protected $table = 'shop_suppliers';
    protected $fillable =[
        'categories_code',
        'categories_text',
        'description',
        'image',
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
    
    public function products(){
        return $this->hasMany(
            ShopProduct::class,
            'supplier_id' ,'id'
        );
    }
}