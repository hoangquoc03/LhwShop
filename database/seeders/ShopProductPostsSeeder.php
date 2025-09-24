<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopProductPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];

        // Lấy danh sách product_id từ bảng shop_products
        $arrProductIds = DB::table('shop_products')->pluck('id');

        foreach ($arrProductIds as $productId) {
            $row = [
                'product_id' => $productId,
                'title' => 'Bài viết cho sản phẩm ' . $productId,
                'content' => $faker->paragraph(5, true),
                'image' => 'uploads/posts/post-' . $faker->numberBetween(1, 3) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $list[] = $row;
        }

        DB::table('shop_product_posts')->insert($list);
    }
}