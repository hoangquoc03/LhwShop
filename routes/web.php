<?php

use App\Models\AclUser;
use App\Models\AclRole;
use App\Models\ShopPort;
use App\Models\ShopPortCategory;
use App\Models\AclPermission;
use App\Models\AclUserHasRole;
use App\Models\AclRoleHasPermission;
use App\Models\ShopProductDiscount;


use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginHomeController;
use App\Http\Controllers\Frontend\RegisterHomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\FavoriteController;
use App\Http\Controllers\Frontend\CartController;


use App\Http\Controllers\Backend\ShopSettingController;
use App\Http\Controllers\Backend\ShopProductVariantController as ProductProVariantController;
use App\Http\Controllers\Backend\ShopPostController;
use App\Http\Controllers\Backend\AclUserHasRoleController;
use App\Http\Controllers\Backend\ShopCategoryController;
use App\Http\Controllers\Backend\ShopSupplierController;
use App\Http\Controllers\Backend\ShopPaymentTypeController;
use App\Http\Controllers\Backend\ShopProductController;
use App\Http\Controllers\Backend\ShopProductImgController;
use App\Http\Controllers\Backend\HomeLHWController;
use App\Http\Controllers\Backend\ShopProductDiscountController;
use App\Http\Controllers\Backend\ShopVoucherController;
use App\Http\Controllers\Backend\ShopStoreController;
use App\Http\Controllers\Backend\ShopCustomerController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AclRoleController;
use App\Http\Controllers\Backend\ShopProductVoucherController;
use App\Http\Controllers\Backend\ShopOrderController;
use App\Http\Controllers\Backend\AclUserController;
use App\Http\Controllers\Backend\ShopProductReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\AclRoleHasPermissionController;
use App\Http\Controllers\Backend\ShopCustomerVoucherController;
use App\Http\Controllers\Backend\ShopOrderDetailController;
use Illuminate\Support\Facades\Route;
//                    errors
Route::get('/errors/403',[
    ErrorController::class,'page403'
])->name('errors.403');

//                     Frontend
Route::get('/',[
    HomeController::class,'index'
])->name('frontend.home.index');
//                   LoginHomeController
Route::get('/login-lhwshop', [
    LoginHomeController::class, 'index'
])->name('frontend.login.index');
Route::post('/login-home', [
    LoginHomeController::class, 'login'
])->name('frontend.login.post');
//            products
Route::get('/products/category/{id}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/supplier/{id}', [ProductController::class, 'bySupplier'])->name('products.bySupplier');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');

Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/load-more', [ProductController::class, 'loadMore'])->name('products.load_more');
// yêu thích
Route::post('/favorites/add', [FavoriteController::class, 'add'])->name('favorites.add');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/remove', [FavoriteController::class, 'remove'])->name('favorites.remove');
Route::post('/logout-home', [LoginHomeController::class, 'logout'])->name('home.logout');
//                   CartController
Route::middleware('web')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});
Route::get('/get-districts/{city_id}', [CartController::class, 'getDistricts']);
Route::get('/get-wards/{district_id}', [CartController::class, 'getWards']);

Route::middleware('auth:customer')->group(function () {
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/orders/success/{id}', [CartController::class, 'success'])->name('orders.success');
});

Route::get('/checkout', [CartController::class, 'create'])
    ->name('orders.create')
    ->middleware('auth:customer');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
Route::post('/checkout/store', [CartController::class, 'store'])
    ->middleware(['web', 'auth:customer'])
    ->name('orders.store');


Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

//                   LogoutHomeController
Route::get('/register-home', [RegisterHomeController::class, 'index'])->name('frontend.register.index');
Route::post('/register-home', [RegisterHomeController::class, 'register'])->name('frontend.register.register');
Route::get('/home/register-success', [RegisterHomeController::class, 'registerSuccess'])->name('frontend.register.register-success');
Route::get('/active-user/{token}', [RegisterHomeController::class, 'activeUser'])->name('frontend.register.active-user');
Route::post('/check-username', [RegisterHomeController::class, 'checkUsername'])->name('frontend.register.check-username');
Route::post('/check-email', [RegisterHomeController::class, 'checkEmail'])->name('frontend.register.check-email');

//                     Admin
Route::middleware(['auth:customer', 'check.active'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Login chung
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware('auth:staff')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Customer routes
Route::middleware('auth:customer')->group(function () {
    Route::get('/Home/home', [HomeController::class, 'index'])->name('Home.home');
});

//                Route register
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/register',[
    RegisterController::class,'index'
])->name('auth.register.index');

Route::post('/register',[
    RegisterController::class,'register'
])->name('auth.register.register');

Route::get('/register-success',[
    RegisterController::class,'registerSuccess'
])->name('auth.register.register-success');

Route::get('/active-user',[
    RegisterController::class,'activeUser'
])->name('auth.register.active-user');

//                   Route cấu hình
Route::get('/backend/cau-hinh',[
    ShopSettingController::class,'index'
])->name('backend.shop_setting.index');

Route::put('/backend/cau-hinh/{id}',[
    ShopSettingController::class,'update'
])->name('backend.shop_setting.update');

Route::delete('/backend/cau-hinh/{id}',[
    ShopSettingController::class,'destroy'
])->name('backend.shop_setting.destroy');

Route::post('/backend/cau-hinh/store',[
    ShopSettingController::class,'store'
])->name('backend.shop_setting.store');

//                       Route Post
Route::get('/backend/post',[
    ShopPostController::class,'index'
])->name('backend.post.index');

Route::put('/backend/post/{id}',[
    ShopPostController::class,'update'
])->name('backend.post.update');

Route::delete('/backend/post/{id}',[
    ShopPostController::class,'destroy'
])->name('backend.post.destroy');

Route::post('/backend/post/store',[
    ShopPostController::class,'store'
])->name('backend.post.store');

//                     cấp quyền cho vai trò
Route::get('/api/v1/acl_role_has_permissions/getByRoleId/{role_id}', [
    AclRoleHasPermissionController::class, 'getByRoleId'
])->name('api.acl_role_has_permissions.getByRoleId');


Route::get('/api/acl_role_has_permissions',[
    AclRoleHasPermissionController::class,'index'
])->name('backend.acl_role_has_permissions.index');


Route::post('/backend/RolePermission/store',[
    AclRoleHasPermissionController::class,'store'
])->name('backend.acl_role_has_permissions.store');

Route::delete('/backend/RolePermission/{id}', [
    AclRoleHasPermissionController::class,'destroy'
])->name('backend.acl_role_has_permissions.destroy');

//                           Product
Route::get('/backend/Category',[
    ShopCategoryController::class,'index'
])->name('backend.Category.index');

Route::put('/backend/Category/{id}',[
    ShopCategoryController::class,'update'
])->name('backend.Category.update');

Route::delete('/backend/Category/{id}',[
    ShopCategoryController::class,'destroy'
])->name('backend.Category.destroy');

Route::post('/backend/Category/store',[
    ShopCategoryController::class,'store'
])->name('backend.Category.store');
//                           Suppliers
Route::get('/backend/Supplier',[
    ShopSupplierController::class,'index'
])->name('backend.Supplier.index');

Route::put('/backend/Supplier/{id}',[
    ShopSupplierController::class,'update'
])->name('backend.Supplier.update');

Route::delete('/backend/Supplier/{id}',[
    ShopSupplierController::class,'destroy'
])->name('backend.Supplier.destroy');

Route::post('/backend/Supplier/store',[
    ShopSupplierController::class,'store'
])->name('backend.Supplier.store');

//                           Products
Route::get('/backend/Product',[
    ShopProductController::class,'index'
])->name('backend.Product.index');

Route::put('/backend/Product/{id}',[
    ShopProductController::class,'update'
])->name('backend.Product.update');

Route::delete('/backend/Product/{id}',[
    ShopProductController::class,'destroy'
])->name('backend.Product.destroy');

Route::post('/backend/Product/store',[
    ShopProductController::class,'store'
])->name('backend.Product.store');

//                product img
Route::get('/backend/ProductImg',[
    ShopProductImgController::class,'index'
])->name('backend.ProductImg.index');

Route::put('/backend/ProductImg/{id}',[
    ShopProductImgController::class,'update'
])->name('backend.ProductImg.update');

Route::delete('/backend/ProductImg/{id}',[
    ShopProductImgController::class,'destroy'
])->name('backend.ProductImg.destroy');


Route::post('/product-images/batch-delete', [
    ShopProductImgController::class, 'batchDelete']
    )->name('backend.ProductImg.batchDelete');

Route::post('/backend/ProductImg/store',[
    ShopProductImgController::class,'store'
])->name('backend.ProductImg.store');


//                product Discount
Route::get('/backend/ProductDiscount',[
    ShopProductDiscountController::class,'index'
])->name('backend.ProductDiscount.index');

Route::put('/backend/ProductDiscount/{id}',[
    ShopProductDiscountController::class,'update'
])->name('backend.ProductDiscount.update');

Route::delete('/backend/ProductDiscount/{id}',[
    ShopProductDiscountController::class,'destroy'
])->name('backend.ProductDiscount.destroy');

Route::post('/product-discount-images/batch-delete', [
    ShopProductDiscountController::class, 'batchDelete'
])->name('backend.ProductDiscount.batchDelete');

Route::post('/backend/ProductDiscount/store',[
    ShopProductDiscountController::class,'store'
])->name('backend.ProductDiscount.store');

//                product Voucher
Route::controller(ShopVoucherController::class)->prefix('backend/ShopVoucher')->name('backend.ShopVoucher.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                ShopStore Controller
Route::controller(ShopStoreController::class)->prefix('backend/ShopStore')->name('backend.ShopStore.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                ShopCustomerController
Route::controller(ShopCustomerController::class)->prefix('backend/ShopCustomer')->name('backend.ShopCustomer.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});

//                ShopOrderController
Route::controller(ShopOrderController::class)->prefix('backend/ShopOrder')->name('backend.ShopOrder.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                AclUserController
Route::controller(AclUserController::class)->prefix('backend/AclUser')->name('backend.AclUser.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                AclRoleController
Route::controller(AclRoleController::class)->prefix('backend/AclRole')->name('backend.AclRole.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                AclUserHasRoleController
Route::controller(AclUserHasRoleController::class)->prefix('backend/UserRole')->name('backend.UserRole.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                ShopProductReviewController
Route::controller(ShopProductReviewController::class)->prefix('backend/ShopProductReview')->name('backend.ShopProductReview.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                ShopProductVoucherController
Route::controller(ShopProductVoucherController::class)->prefix('backend/ShopProductVoucher')->name('backend.ShopProductVoucher.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                ShopCustomerVoucher
Route::controller(ShopCustomerVoucherController::class)->prefix('backend/ShopCustomerVoucher')->name('backend.ShopCustomerVoucher.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                ShopPaymentTypeController
Route::controller(ShopPaymentTypeController::class)->prefix('backend/ShopPaymentType')->name('backend.ShopPaymentType.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});
//                
Route::controller(ShopOrderDetailController::class)->prefix('backend/ShopOrderDetail')->name('backend.ShopOrderDetail.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});

//                Product Variant
Route::controller(ProductProVariantController::class)->prefix('backend/ProductVariant')->name('backend.ProductVariant.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::post('/batch-delete', 'batchDelete')->name('batchDelete');
});