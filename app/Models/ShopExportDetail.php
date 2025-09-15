<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopExport;
use App\Models\ShopImportDetail;
class ShopExportDetail extends Model
{
    protected $table = 'shop_import_details';
    protected $fillable =[
        'export_id',
        'product_id',
        'quantity',
        'unit_price',
        'import_detail_id',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[];
    protected $dateFormat ='Y-m-d H:i:s';
    public $timestamps = false;
    public function export(){
        return $this->belongsTo(
            ShopExport::class,
            'export_id' ,'id'
        );
    }
    public function import_detail(){
        return $this->belongsTo(
            ShopImportDetail::class,
            'import_detail_id' ,'id'
        );
    }
}