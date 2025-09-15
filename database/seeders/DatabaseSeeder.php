<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\ShopSuppliersSeeder;
use Database\Seeders\ShopCategoriesSeeder;
use Database\Seeders\ShopProductsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        ShopUsersSeeder::class,          // Đảm bảo bảng acl_users
        AclPermissionsSeeder::class,
        AclRolesSeeder::class,
        AclRoleHasPermissionsSeeder::class,
        AclUserHasRolesSeeder::class,
        AclUserHasPermissionsSeeder::class,
    ]);

    // Bài đăng (Blog / Tin tức)
    $this->call([
        ShopPostCategoriesSeeder::class,  // Phải có trước
        ShopPostsSeeder::class,           // Dùng khóa ngoại từ trên
    ]);

    // Dữ liệu sản phẩm
    $this->call([
        ShopSuppliersSeeder::class,
        ShopCategoriesSeeder::class,
        ShopProductsSeeder::class,
        ShopProductImagesSeeder::class,
        ShopProductDiscountSeeder::class,
        ShopCustomersSeeder::class,
        ShopProductReviewsSeeder::class,
    ]);

    // Dữ liệu về kho, cửa hàng
    $this->call([
        ShopStoreSeeder::class,
        ShopImportsSeeder::class,
        
    ]);

    // Voucher & đơn hàng
    $this->call([
        ShopVouchersSeeder::class,
        ShopProductVouchersSeeder::class,
        ShopCustomerVouchersSeeder::class,
        ShopPaymentTypesSeeder::class,
        ShopOrdersSeeders::class,
        ShopOrderDetailsSeeder::class,
    ]);

    $this->call([
    ShopExportsSeeder::class,         
    ]);

// Cấu hình chung hệ thống
    $this->call([
    ShopSettingsSeeder::class,
    ]);

    }
}