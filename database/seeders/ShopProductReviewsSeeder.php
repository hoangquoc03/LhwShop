<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopProductReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];

        // lay du lieu products
        $arrProductIds = DB::table('shop_products')->pluck('id')->toArray();
        $arrCustomersIds = DB::table('shop_customers')->pluck('id')->toArray();

        if (empty($arrProductIds) || empty($arrCustomersIds)) {
            throw new \Exception('Bảng shop_products hoặc shop_customers đang trống. Hãy chạy các seeder tạo sản phẩm và khách hàng trước.');
        }

        for($i =1;$i <= 10;$i++){
            $row =[
                'product_id' =>$faker->randomElement($arrProductIds),
                'customer_id' =>$faker->randomElement($arrCustomersIds),
                'rating'       => $faker->numberBetween(1, 5),
                'comment'      => $faker->sentence(10),        // Câu nhận xét ngắn
                'created_at'   => $faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d H:i:s'),
            ];
            array_push($list,$row);
        }
        DB::table('shop_product_reviews')->insert($list);
    }
}