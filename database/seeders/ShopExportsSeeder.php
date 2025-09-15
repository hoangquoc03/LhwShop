<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopExportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Lấy dữ liệu
        $arrStoresIds = DB::table('shop_stores')->pluck('id')->toArray();
        $arrUsersIds = DB::table('acl_users')->pluck('id')->toArray();
        $arrProductsIds = DB::table('shop_products')->pluck('id')->toArray();
        $arrImportDetailIds = DB::table('shop_import_details')->pluck('id')->toArray();
        $arrOrderIds = DB::table('shop_orders')->pluck('id')->toArray();

        if (empty($arrStoresIds) || empty($arrUsersIds) || empty($arrProductsIds) || empty($arrImportDetailIds)) {
            throw new \Exception('Thiếu dữ liệu: shop_stores, acl_users, shop_products hoặc shop_import_details.');
        }
        if (empty($arrOrderIds)) {
            throw new \Exception('Thiếu dữ liệu: shop_orders chưa có đơn hàng. Hãy seed đơn hàng trước.');
        }
        for ($i = 1; $i <= 10; $i++) {
            $rowExport = [
                'store_id'     => $faker->randomElement($arrStoresIds),
                'employee_id'  => $faker->randomElement($arrUsersIds),
                'export_data'  => $faker->dateTimeBetween('-3 week', 'now'),
                'description'  => $faker->sentence(10),
                'order_id'     => $faker->randomElement($arrOrderIds),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            $idExport = DB::table('shop_exports')->insertGetId($rowExport);

            $tongSoDongCon = $faker->numberBetween(1, 10);
            $listExportDetails = [];

            for ($j = 1; $j <= $tongSoDongCon; $j++) {
                $rowExportDetail = [
                    'export_id'         => $idExport,
                    'product_id'        => $faker->randomElement($arrProductsIds),
                    'quantity'          => $faker->numberBetween(1, 100),
                    'unit_price'        => $faker->numberBetween(10000, 90000000),
                    'import_detail_id'  => $faker->randomElement($arrImportDetailIds),
                ];

                $listExportDetails[] = $rowExportDetail;
            }

            DB::table('shop_export_details')->insert($listExportDetails);
        }
    }
}