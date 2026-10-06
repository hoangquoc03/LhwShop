<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartFavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $customerIds = DB::table('shop_customers')->pluck('id')->toArray();
        $productIds  = DB::table('shop_products')->pluck('id')->toArray();

        if (empty($customerIds) || empty($productIds)) {
            $this->command->warn('Thiếu khách hàng hoặc sản phẩm.');
            return;
        }

        // Giỏ hàng
        DB::table('shop_carts')->insert([
            [
                'customer_id' => $customerIds[0],
                'product_id'  => $productIds[0],
                'quantity'    => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'customer_id' => $customerIds[0],
                'product_id'  => $productIds[1] ?? $productIds[0],
                'quantity'    => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        ]);

        // Yêu thích
        DB::table('shop_favorites')->insert([
            [
                'customer_id' => $customerIds[0],
                'product_id'  => $productIds[0],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        ]);

        $this->command->info('Đã tạo dữ liệu giỏ hàng và yêu thích.');
    }
}
