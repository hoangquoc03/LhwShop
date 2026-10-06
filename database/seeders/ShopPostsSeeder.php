<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopPostsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];

        $arrUsersIds = DB::table('acl_users')->pluck('id')->toArray();
        $arrPostCategoryIds = DB::table('shop_post_categories')->pluck('id')->toArray();
        $arrProductIds = DB::table('shop_products')->pluck('id')->toArray(); // Thêm dòng này

        for ($i = 1; $i <= 15; $i++) {
            $list[] = [
                'post_slug'        => $faker->slug(),
                'post_title'       => $faker->sentence(6),
                'post_content'     => $faker->paragraphs(5, true),
                'post_excerpt'     => $faker->paragraph(),
                'post_type'        => $faker->randomElement(['blog', 'news', 'announcement']),
                'post_status'      => $faker->randomElement(['published', 'draft', 'pending']),
                'post_image'       => 'posts/images/post-' . $faker->numberBetween(1, 5) . '.jpg',
                'user_id'          => $faker->randomElement($arrUsersIds),
                'post_category_id' => $faker->randomElement($arrPostCategoryIds),
                'product_id'       => $faker->randomElement($arrProductIds), // Thêm dòng này
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        DB::table('shop_posts')->insert($list);

        $this->command->info('Đã tạo 15 bài viết mẫu thành công.');
    }
}
