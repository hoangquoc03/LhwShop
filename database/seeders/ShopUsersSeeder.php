<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ShopUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $list = [];
        $row = [
            'username'=> 'admin',
            'password'=> bcrypt('123456'),
            'last_name'=> 'Quản trị',
            'first_name'=> 'Hệ thống',
            'gender'=> '0',
            'email'=> 'admin@lhwshop.com',
            'birthday'=> date('Y-m-d H:i:s'),
            'avatar'=> 'users/avatar/avatar-default-nam.jpg',
            'code'=> 'NV001',
            'job_title'=>'Quản trị',
            'department'=> 'Phòng IT',
            'manager_id'=> NULL,
            'phone'=> '098766789',
            'address1'=> 'Hà Đông,Hà Nội',
            'address2'=> '',
            'city'=> 'Hà Nội',
            'state'=> '',
            'postal_code'=> '900000',
            'country'=> 'Việt Nam',
            'remember_token'=> '',
            'active_code'=> '',
            'status'=> '1', // #1: đang hoạt đông  #0: khong hoạt đông
            'created_at'=> date('Y-m-d H:i:s'),
        ];
        array_push($list,$row);

        for($i =1;$i <= 11;$i++){
            $row =[
            'username'=> $faker->word(),
            'password'=> bcrypt('123456'),
            'last_name'=> $faker->word(),
            'first_name'=> $faker->word(),
            'gender'=> $faker->randomElement([0,1]),
            'email'=> $faker->email(),
            'birthday'=> $faker->dateTimeBetween('-30 year', '+30 year'),
            'avatar'=> 'users/avatar/'.$faker->randomElement(['avatar-default-nam.jpg','avatar-default-nu.jpg']),
            'code'=> $faker->word(),
            'job_title'=>$faker->word(),
            'department'=> $faker->word(),
            'manager_id'=> NULL,
            'phone'=> $faker->phoneNumber(),
            'address1'=> $faker->address(),
            'address2'=> $faker->address(),
            'city'=> $faker->city(),
            'state'=> $faker->state(),
            'postal_code'=>$faker->postcode(),
            'country'=> $faker->country(),
            'remember_token'=> '',
            'active_code'=> $faker->uuid(),
            'status'=> 2,       // #1: đang hoạt đông  #0: khong hoạt đông #2 : chưa kích hoạt (qua img)
            'created_at'=> date('Y-m-d H:i:s'),
            ];
            array_push($list,$row);
        }
        DB::table('acl_users')->insert($list);
    }
}