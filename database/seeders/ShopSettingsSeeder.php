<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ShopSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $now = Carbon::now();

        $settings = [
            [
                'group'       => 'general',
                'key'         => 'shop_name',
                'value'       => 'LHW Shop',
                'description' => 'Tên cửa hàng',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'group'       => 'general',
                'key'         => 'shop_email',
                'value'       => 'contact@lhwshop.com',
                'description' => 'Email liên hệ cửa hàng',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'group'       => 'general',
                'key'         => 'shop_phone',
                'value'       => '0987654321',
                'description' => 'Số điện thoại cửa hàng',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'group'       => 'general',
                'key'         => 'shop_address',
                'value'       => 'Số 123, Thanh Xuân, Hà Nội',
                'description' => 'Địa chỉ cửa hàng',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'group'       => 'config',
                'key'         => 'currency',
                'value'       => 'VND',
                'description' => 'Đơn vị tiền tệ',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'group'       => 'config',
                'key'         => 'tax_percentage',
                'value'       => '10',
                'description' => 'Phần trăm thuế mặc định',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        DB::table('shop_settings')->insert($settings);
    }
}