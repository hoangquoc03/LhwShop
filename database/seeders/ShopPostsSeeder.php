<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];

        $arrUsersIds = DB::table('acl_users')->pluck('id')->toArray();
        $arrPortCategoryIds = DB::table('shop_post_categories')->pluck('id')->toArray();


        for ($i = 1; $i <= 15; $i++) {
            $list[] = [
                'post_slug'        => $faker->slug(),
                'post_title'       => $faker->sentence(6),
                'post_content'     => $faker->paragraphs(5, true),
                'post_excerpt'     => $faker->paragraph(1),
                'post_type'        => $faker->randomElement(['blog', 'news', 'announcement']),
                'post_status'      => $faker->randomElement(['published', 'draft', 'pending']),
                'post_image'       => 'posts/images/post-' . $faker->numberBetween(1, 5) . '.jpg',
                'user_id'          => $faker->randomElement($arrUsersIds),
                'post_category_id' => $faker->randomElement($arrPortCategoryIds),
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        DB::table('shop_posts')->insert($list);

        $this->command->info(' Đã tạo 15 bài viết mẫu thành công.');
    }
}