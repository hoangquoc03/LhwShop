<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopPaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];
        $row1 =[
            'payment_code'   => 'PM01',
            'payment_name'   => 'Thanh toán tại cửa hàng',
            'description'    => 'Khách hàng thanh toán trực tiếp tại cửa hàng khi nhận hàng.',
            'image'          => 'payments/logo/payment-store.jpg',
            'created_at'     => date('Y-m-d H:i:s'),
        ];
        array_push($list,$row1);

        $row2 =[
            'payment_code'   => 'PM02',
            'payment_name'   => 'Chuyển khoản ngân hàng',
            'description'    => 'Khách hàng chuyển khoản qua ngân hàng trước khi giao hàng.',
            'image'          => 'payments/logo/payment-bank.jpg',
            'created_at'     => date('Y-m-d H:i:s'),
        ];
        array_push($list,$row2);
        
        DB::table('shop_payment_types')->insert($list);
    }
}