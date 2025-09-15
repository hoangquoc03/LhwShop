<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopOrderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $arrOrdersIds=DB::table('shop_orders')->pluck('id');
        $arrProductIds=DB::table('shop_products')->pluck('id');
        $list = [];

        for ($i = 1; $i <= 30; $i++) {  // Giả sử 30 chi tiết đơn hàng
            $row = [
                'order_id' => $faker->randomElement($arrOrdersIds), // Đơn hàng từ seeder ở trên
                'product_id' => $faker->randomElement($arrProductIds),
                'quantity' => $faker->randomFloat(2, 1, 10),
                'unit_price' => $faker->randomFloat(2, 50, 500),
                'discount_percentage' => $faker->randomFloat(2, 0, 20),
                'discount_amount' => $faker->randomFloat(2, 0, 100),
                'order_detail_status' => $faker->randomElement(['Processing', 'Completed', 'Returned']),
                'date_allocated' => $faker->dateTimeBetween('now', '+5 days'),
            ];

            array_push($list, $row);
        }

        DB::table('shop_order_details')->insert($list);
    }
}