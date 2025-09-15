<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopStore;
use App\Models\ShopImportDetail;
class ShopImport extends Model
{
    protected $table = 'shop_imports';
    protected $fillable =[
        'store_id',
        'employee_id',
        'import_data',
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

    public function user(){
        return $this->belongsTo(
            ShopStore::class,
            'store_id' ,'id'
        );
    }
    public function import_detail(){
        return $this->hasMany(
            ShopImportDetail::class,
            'import_id' ,'id'
        );
    }
}