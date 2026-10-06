<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * =====================================================
         * ACL (Phân quyền & Admin)
         * =====================================================
         */
        $this->call([
            ShopUsersSeeder::class,
            AclPermissionsSeeder::class,
            AclRolesSeeder::class,
            AclRoleHasPermissionsSeeder::class,
            AclUserHasRolesSeeder::class,
            AclUserHasPermissionsSeeder::class,
        ]);

        /**
         * =====================================================
         * Danh mục
         * =====================================================
         */
        $this->call([
            ShopSuppliersSeeder::class,
            ShopCategoriesSeeder::class,
            ShopPostCategoriesSeeder::class,
            ShopPaymentTypesSeeder::class,
            ShopVouchersSeeder::class,
            ShopStoreSeeder::class,
            ShopSettingsSeeder::class,
        ]);

        /**
         * =====================================================
         * Khách hàng
         * =====================================================
         */
        $this->call([
            ShopCustomersSeeder::class,
        ]);

        /**
         * =====================================================
         * Sản phẩm
         * =====================================================
         */
        $this->call([
            ShopProductsSeeder::class,
            ShopProductImagesSeeder::class,
            ShopProductDiscountSeeder::class,
            //ShopProductPostsSeeder::class,
            ShopProductReviewsSeeder::class,
        ]);

        /**
         * =====================================================
         * Bài viết (phải chạy sau ShopProductsSeeder)
         * =====================================================
         */
        $this->call([
            ShopPostsSeeder::class,
        ]);

        /**
         * =====================================================
         * Giỏ hàng & Yêu thích
         * =====================================================
         */
        $this->call([
            CartFavoriteSeeder::class,
        ]);

        /**
         * =====================================================
         * Voucher khách hàng
         * =====================================================
         */
        $this->call([
            ShopProductVouchersSeeder::class,
            ShopCustomerVouchersSeeder::class,
        ]);

        /**
         * =====================================================
         * Nhập kho
         * =====================================================
         */
        $this->call([
            ShopImportsSeeder::class,
        ]);

        /**
         * =====================================================
         * Đơn hàng
         * =====================================================
         */
        $this->call([
            ShopOrdersSeeders::class,
            ShopOrderDetailsSeeder::class,
        ]);

        /**
         * =====================================================
         * Xuất kho (chạy sau đơn hàng)
         * =====================================================
         */
        $this->call([
            ShopExportsSeeder::class,
        ]);
    }
}
