<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];
        $row1 =[
            'store_code'=>'KH1',
            'store_name'=>'Kho hàng chính',
            'description'=>'Đây là kho hàng chính',
            'image'=>'stores/logo/logo-store-chinh.jpg',
            'created_at'=>date('Y-m-d H:i:s'),
        ];
        array_push($list,$row1);

        $row2 =[
            'store_code'=>'KH2',
            'store_name'=>'Kho hàng phụ',
            'description'=>'Đây là kho hàng phụ',
            'image'=>'stores/logo/logo-store-phu.jpg',
            'created_at'=>date('Y-m-d H:i:s'),
        ];
        array_push($list,$row2);
        
        DB::table('shop_stores')->insert($list);
    }
}