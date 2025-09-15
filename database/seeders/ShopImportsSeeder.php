<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopImportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        

        // lay du lieu 
        $arrStoresIds=DB::table('shop_stores')->pluck('id');
        $arrUsersIds=DB::table('acl_users')->pluck('id');
        $arrProductsIds=DB::table('shop_products')->pluck('id');


        for($i =1;$i <= 10;$i++){
            $rowImport =[
                'store_id'=> $faker->randomElement($arrStoresIds),
                'employee_id'=> $faker->randomElement($arrUsersIds),
                'import_data'=>$faker->dateTimeBetween('-3 week', 'now'),
                'created_at'=>$faker->dateTimeBetween('-3 week', 'now'),
            ];
            //array_push($listImports,$rowImport);
            $idImport= DB::table('shop_imports')->insertGetId($rowImport);
            $tongSoDongCon =$faker->numberBetween(1, 10);
            $listImportsDetails = [];
            for($j =1;$j<= $tongSoDongCon;$j++){
                $rowImportsDetail =[
                    'import_id'=> $idImport,
                    'product_id'=> $faker->randomElement($arrProductsIds),
                    'quantity' => $faker->numberBetween(1, 100),
                    'unit_price'=>$faker->numberBetween(10000, 90000000),
                ];
                array_push($listImportsDetails,$rowImportsDetail);
            }
            DB::table('shop_import_details')->insert($listImportsDetails);
        }
    }
}