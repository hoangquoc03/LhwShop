<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ShopPostCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [];

        $row1 = [
            'id'                   => 1,
            'post_category_code'   => 'UNCAT',
            'post_category_name'   => 'Chưa phân loại',
            'description'          => 'Chuyên mục mặc định khi chưa phân loại bài viết.',
            'image'                => 'categories/post/category-blog-1.jpg',
            'created_at'           => now(),
            'updated_at'           => now(),
        ];
        array_push($list, $row1);

        $row2 = [
            'id'                   => 2,
            'post_category_code'   => 'BLOG',
            'post_category_name'   => 'Bài viết blog',
            'description'          => 'Chuyên mục các bài viết chia sẻ blog.',
            'image'                => 'categories/post/category-blog-2.jpg',
            'created_at'           => now(),
            'updated_at'           => now(),
        ];
        array_push($list, $row2);

        $row3 = [
            'id'                   => 3,
            'post_category_code'   => 'NEWS',
            'post_category_name'   => 'Tin tức công nghệ',
            'description'          => 'Tổng hợp tin tức công nghệ mới nhất.',
            'image'                => 'categories/post/category-blog-3.jpg',
            'created_at'           => now(),
            'updated_at'           => now(),
        ];
        array_push($list, $row3);

        // Insert vào database
        DB::table('shop_post_categories')->insert($list);
    }
}