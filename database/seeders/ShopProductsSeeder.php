<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];
        $row1 = [
            'product_code'=> '9Q969PA',
            'product_name'=> 'Laptop HP 15 fd0234TU i5 1334U/16GB/512GB/Win11',
            'image'=> 'products/hp-15s.jpg',
            'short_description'=> 'Bộ sản phẩm gồm: Sách hướng dẫn, Thùng máy, Sạc Laptop HP ( 45W )',
            'description'=> '💼 HP Pavilion 15-eg3111TU – i5 Gen 13 / RAM 16GB / SSD 512GB / Màn 15.6” FHD
                            ✨ Laptop sang trọng – hiệu năng mạnh – màn hình sắc nét – pin lâu
                            ⚙️ Hiệu năng mạnh mẽ với Intel Gen 13 mới nhất
                            • CPU Intel Core i5-1335U (10 nhân 12 luồng, xung tối đa 4.60GHz)
                            • GPU Intel Iris Xe – làm đồ họa, chơi game nhẹ mượt mà
                            • RAM 16GB Dual Channel – đa nhiệm thoải mái, không giật lag
                            💾 SSD 512GB PCIe siêu tốc – khởi động & xử lý nhanh
                            • Truy xuất dữ liệu cực nhanh, khởi động máy chỉ vài giây
                            💻 Thiết kế sang trọng – mỏng nhẹ, tinh tế
                            • Vỏ kim loại bạc, logo HP bóng bẩy, viền màn hình mỏng hiện đại
                            • Cân nặng chỉ 1.7kg, dày 17.9mm – dễ dàng di chuyển
                            🔋 Pin lâu – sạc nhanh tiện lợi
                            • Dùng liên tục ~8 giờ
                            • Sạc 45 phút được 50% nhờ công nghệ HP Fast Charge
                            🖥️ Màn hình 15.6” Full HD – chống nhấp nháy bảo vệ mắt',
            'standard_cost'=> '19929000.00',
            'list_price'=> '21229000.00',
            'quantity_per_unit'=> '7000',
            'discontinued'=> '0',
            'is_featured'=> '1',
            'is_new'=> '1',
            'category_id'=> 1,
            'supplier_id'=> 1,
            'created_at'=> date('Y-m-d H:i:s'),
        ];
        array_push($list,$row1);
        // for($i =1;$i <= 10;$i++){
        //     $row =[
        //         'product_code'=> $faker->regexify('[A-Z]{5}[0-4]{3}'),
        //         'product_name'=> $faker->words(3, true),
        //         'image'=> '/product-'.$faker->numberBetween(1,3).'.jpg',
        //         'short_description'=> $faker->sentence(),
        //         'description'=> $faker->paragraph(2,true),
        //         'standard_cost'=> $faker->numberBetween(2000000, 15000000),
        //         'list_price'=>  $faker->numberBetween(2000000, 15000000),
        //         'quantity_per_unit'=> $faker->numberBetween(1,50),

        //         'discontinued'=> $faker->randomElement([0,1]),
        //         'is_featured'=> $faker->randomElement([0,1]),
        //         'is_new'=> $faker->randomElement([0,1]),
        //         'category_id'=> $faker->randomElement([1,2,3]),
        //         'supplier_id'=> $faker->randomElement([1,2]),

        //         'created_at'=> date('Y-m-d H:i:s'),
        //     ];
        //     array_push($list,$row);
        // }
        // insert vao database
        DB::table('shop_products')->insert($list);
    }
}