<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopImport;
use App\Models\ShopExport;
class ShopStore extends Model
{
    protected $table = 'shop_stores';
    protected $fillable =[
        'store_code',
        'store_name',
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
    public function Imports(){
        return $this->hasMany(
            ShopImport::class,
            'store_id' ,'id'
        );
    }
    public function Exports(){
        return $this->hasMany(
            ShopExport::class,
            'store_id' ,'id'
        );
    }
}