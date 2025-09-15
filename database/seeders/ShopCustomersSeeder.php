<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ShopCustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];
        $row = [
            'username'=> 'quoc',
            'password'=> bcrypt('123456'),
            'last_name'=> 'người dùng',
            'first_name'=> 'khách hàng',
            'gender'=> '0',
            'email'=> 'Customers@lhwshop.com',
            'birthday'=> Carbon::now()->format('Y-m-d H:i:s'),
            'avatar'=> 'customers/avatar/avatar-customer-1.jpg',
            'code'=> 'KH001',
            'company'=> 'Phòng IT',
            'phone'=> '0987667869',
            'billing_address'=> 'Thanh Xuân,Hà Nội',
            'shipping_address'=> '',
            'city'=> 'Hà Nội',
            'state'=> '',
            'postal_code'=> '900000',
            'country'=> 'Việt Nam',
            'remember_token'=> '',
            'activate_code' => '',   
            'status'=> '1', // #1: đang hoạt đông  #0: khong hoạt đông
            'created_at'=> Carbon::now(),
        ];
        array_push($list,$row);

        for($i =1;$i <= 11;$i++){
            $row =[
            'username'          => $faker->unique()->userName(),
            'password'          => bcrypt('123456'),
            'last_name'         => $faker->lastName(),
            'first_name'        => $faker->firstName(),
            'gender'            => $faker->randomElement([0, 1]),
            'email'             => $faker->unique()->safeEmail(),
            'birthday'          => $faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d H:i:s'),
            'avatar'            => 'customers/avatar/'.$faker->randomElement(['avatar-customer-1.jpg','avatar-customer-2.jpg']),
            'code'              => strtoupper($faker->bothify('KH###')),
            'company'           => $faker->company(),
            'phone'             => $faker->phoneNumber(),
            'billing_address'   => $faker->address(),
            'shipping_address'  => $faker->address(),
            'city'              => $faker->city(),
            'state'             => $faker->state(),
            'postal_code'       => $faker->postcode(),
            'country'           => $faker->country(),
            'remember_token'    => '',
            'activate_code' => $faker->uuid(),
            'status'            => 2, // 2: chưa kích hoạt
            'created_at'        => Carbon::now(),
            ];
        array_push($list,$row);
        }
        DB::table('shop_customers')->insert($list);
    }
}