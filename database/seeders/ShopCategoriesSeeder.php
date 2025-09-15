<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [];
        $row1 = [
            'id'=>1,
            'categories_code' =>'CPL',
            'categories_text' =>'Chuyên mục chưa phân loại',
            'description' =>'Chuyên mục mặc định của hệ thống',
            'image' => 'categories/logo/logo-category-default.jpg',
            'created_at' => date('Y-m-d H:i:s'),

        ];
        array_push($list,$row1);

        $row2 = [
            'id'=>2,
            'categories_code' =>'MTB',
            'categories_text' =>'Máy tính bảng',
            'description' =>'Các dòng máy tính bảng',
            'image' => 'categories/logo/logo-category-tablet.jpg',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        array_push($list,$row2);

        $row3 = [
            'id'=>3,
            'categories_code' =>'Dt',
            'categories_text' =>'Điện thoại thông minh',
            'description' =>'Các dòng Điện thoại thông minh',
            'image' => 'categories/logo/logo-category-mobile.jpg',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        array_push($list,$row3);
        // insert vao database
        DB::table('shop_categories')->insert($list);
    }
}