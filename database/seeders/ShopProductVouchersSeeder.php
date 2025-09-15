<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopProductVouchersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];

        // lay du lieu products
        $arrProductIds=DB::table('shop_products')->pluck('id');
        $arrVouchersIds=DB::table('shop_vouchers')->pluck('id');
        //dd($arrProductIds);


        for($i =1;$i <= 10;$i++){
            $row =[
                'product_id' =>$faker->randomElement($arrProductIds),
                'voucher_id' =>$faker->randomElement($arrVouchersIds),
                'created_at' =>$faker->dateTimeBetween('-1 week', '+1 week'),
            ];
            array_push($list,$row);
        }
        DB::table('shop_product_vouchers')->insert($list);
    }
}