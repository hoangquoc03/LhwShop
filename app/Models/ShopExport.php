<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopStore;
use App\Models\ShopExportDetail;
class ShopExport extends Model
{
    protected $table = 'shop_exports';
    protected $fillable =[
        'store_id',
        'employee_id',
        'import_data',
        'description',
        'order_id',
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

    public function store(){
        return $this->belongsTo(
            ShopStore::class,
            'store_id' ,'id'
        );
    }

    public function export_details(){
        return $this->hasMany(
            ShopExportDetail::class,
            'export_id' ,'id'
        );
    }
}