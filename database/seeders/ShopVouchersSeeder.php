<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ShopVouchersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];
        $row = [
            'voucher_code'      => 'SUMMER2025',
            'voucher_name'      => 'Khuyến mãi mùa hè',
            'description'       => 'Giảm 50.000 VNĐ cho đơn hàng từ 500.000 VNĐ',
            'uses'              => 0,
            'max_uses'          => 100,
            'max_uses_user'     => 2,
            'type'              => 0,            // 1: giảm cố định, 0: giảm theo %
            'discount_amount'   => 50000,        // 50.000 VNĐ
            'is_fixed'          => 1,            // 1: đúng giảm cố định
            'start_date'        => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date'          => Carbon::now()->addDays(30)->format('Y-m-d H:i:s'),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
            'deleted_at'        => null,
        ];
        array_push($list,$row);
        for($i =1;$i <= 11;$i++){
            $type = $faker->randomElement([0, 1]);
            $row = [
                'voucher_code'    => strtoupper($faker->bothify('VOUCHER-####-??')),
                'voucher_name'    => $faker->sentence(3),
                'description'     => $faker->sentence(10),
                'uses'            => 0,
                'max_uses'        => $faker->numberBetween(10, 100),
                'max_uses_user'   => $faker->numberBetween(1, 5),
                'type'            => $type,
                'discount_amount' => $type == 1
                                ? $faker->numberBetween(5000, 100000)
                                : $faker->numberBetween(5, 50), 
                'is_fixed'        => $type == 1 ? 1 : 0, 
                'start_date'      => Carbon::now()->subDays(rand(0, 5)),
                'end_date'        => Carbon::now()->addDays(rand(5, 30)),
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
                'deleted_at'      => null,
            ];

            array_push($list, $row);
        }
        DB::table('shop_vouchers')->insert($list);
    }
    
}