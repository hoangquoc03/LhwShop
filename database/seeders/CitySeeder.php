<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Hà Nội',
            'Hồ Chí Minh',
            'Đà Nẵng',
            'Hải Phòng',
            'Cần Thơ',
            'Bình Dương',
            'Đắk Lắk',
            'Khánh Hòa',
            'Thanh Hóa',
            'Nghệ An',
        ];

        foreach ($cities as $name) {
            City::create(['name' => $name]);
        }
    }
}