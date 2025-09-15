<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopProductVariantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shop_product_variants')->insert([
            [
                'sku' => 'LAPTOP-DELL-I5-BLACK',
                'variant_name' => 'Màu Đen / Core i5 / 8GB RAM',
                'price' => 15000000,
                'stock_quantity' => 10,
                'options' => json_encode(['Màu' => 'Đen', 'CPU' => 'i5', 'RAM' => '8GB']),
                'product_id' => 1, // phải có sẵn product_id = 1 trong bảng shop_products
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'LAPTOP-DELL-I7-SILVER',
                'variant_name' => 'Màu Bạc / Core i7 / 16GB RAM',
                'price' => 20000000,
                'stock_quantity' => 5,
                'options' => json_encode(['Màu' => 'Bạc', 'CPU' => 'i7', 'RAM' => '16GB']),
                'product_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}