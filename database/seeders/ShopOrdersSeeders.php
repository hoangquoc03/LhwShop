<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopOrdersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $arrPaymentIds=DB::table('shop_payment_types')->pluck('id');
        $arrCustomers=DB::table('shop_customers')->pluck('id');
        $arrUsersIds=DB::table('acl_users')->pluck('id');
        $list = [];

        for ($i = 1; $i <= 10; $i++) {
            $row = [
                'employee_id' => $faker->randomElement($arrUsersIds),
                'customer_id' => $faker->randomElement($arrCustomers),
                'order_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'shipped_date' => $faker->dateTimeBetween('now', '+1 week'),
                'ship_name' => $faker->name,
                'ship_address1' => $faker->address,
                'ship_address2' => $faker->address,
                'ship_city' => $faker->city,
                'ship_state' => $faker->state,
                'ship_postal_code' => $faker->postcode,
                'ship_country' => $faker->country,
                'shipping_fee' => $faker->randomFloat(2, 5, 100),
                'payment_type_id' => $faker->randomElement($arrPaymentIds),
                'paid_date' => $faker->dateTimeBetween('now', '+2 days'),
                'order_status' => $faker->randomElement(['Pending', 'Shipped', 'Delivered', 'Cancelled']),
                'created_at' => now(),
            ];

            array_push($list, $row);
        }

        DB::table('shop_orders')->insert($list);
    }
}