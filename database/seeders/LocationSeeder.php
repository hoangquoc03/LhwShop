<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Hà Nội' => [
                'Ba Đình' => ['Phúc Xá', 'Trúc Bạch', 'Vĩnh Phúc'],
                'Cầu Giấy' => ['Dịch Vọng', 'Nghĩa Tân', 'Quan Hoa'],
            ],
            'Hồ Chí Minh' => [
                'Quận 1' => ['Bến Nghé', 'Bến Thành', 'Cầu Ông Lãnh'],
                'Quận 3' => ['Phường 1', 'Phường 2', 'Phường 3'],
            ],
            'Đà Nẵng' => [
                'Hải Châu' => ['Thạch Thang', 'Hòa Thuận Đông', 'Nam Dương'],
                'Sơn Trà' => ['An Hải Bắc', 'An Hải Tây', 'Phước Mỹ'],
            ],
            'Hải Phòng' => [
                'Hồng Bàng' => ['Quán Toan', 'Sở Dầu', 'Hạ Lý'],
                'Ngô Quyền' => ['Máy Tơ', 'Máy Chai', 'Lạc Viên'],
            ],
            'Cần Thơ' => [
                'Ninh Kiều' => ['An Bình', 'An Cư', 'An Hội'],
                'Bình Thủy' => ['An Thới', 'Bình Thủy', 'Bùi Hữu Nghĩa'],
            ],
            'Bình Dương' => [
                'Thủ Dầu Một' => ['Hiệp Thành', 'Phú Cường', 'Phú Lợi'],
                'Dĩ An' => ['An Bình', 'Bình An', 'Bình Thắng'],
            ],
            'Đắk Lắk' => [
                'Buôn Ma Thuột' => ['Tân Lập', 'Tân An', 'Thành Nhất'],
                'Ea Kar' => ['Ea Knốp', 'Ea Đar', 'Ea Păl'],
            ],
            'Khánh Hòa' => [
                'Nha Trang' => ['Phước Tân', 'Phước Hải', 'Vĩnh Hòa'],
                'Cam Ranh' => ['Cam Nghĩa', 'Cam Phú', 'Cam Thuận'],
            ],
            'Thanh Hóa' => [
                'TP Thanh Hóa' => ['Ba Đình', 'Điện Biên', 'Đông Cương'],
                'Sầm Sơn' => ['Trường Sơn', 'Trường Thi', 'Quảng Cư'],
            ],
            'Nghệ An' => [
                'TP Vinh' => ['Hưng Bình', 'Hưng Dũng', 'Quang Trung'],
                'Cửa Lò' => ['Nghi Hòa', 'Nghi Hải', 'Nghi Thu'],
            ],
        ];

        foreach ($locations as $cityName => $districts) {
            $city = City::where('name', $cityName)->first();
            if (!$city) {
                $city = City::create(['name' => $cityName]);
            }

            foreach ($districts as $districtName => $wards) {
                $district = District::create([
                    'name' => $districtName,
                    'city_id' => $city->id,
                ]);

                foreach ($wards as $wardName) {
                    Ward::create([
                        'name' => $wardName,
                        'district_id' => $district->id,
                    ]);
                }
            }
        }
    }
    
}