<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\ShopProduct;
use  App\Models\ShopCategory;
use  App\Models\ShopSupplier;
use  App\Models\ShopPost;
use  App\Models\ShopOrderDetail;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use  App\Models\ShopSetting;
use  App\Models\ShopOrder;
use App\Models\ShopProductPost;

class HomeController extends Controller
{
    public function index()
    {
        /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

        $categories = ShopCategory::with([
            'suppliers',
            'products' => function ($q) {
                $q->select(
                    'id',
                    'product_name',
                    'category_id',
                    'supplier_id',
                    'is_featured',
                    'is_new',
                    'created_at'
                )
                    ->orderByDesc('created_at')
                    ->take(6);
            }
        ])
            ->get([
                'id',
                'categories_code',
                'categories_text',
                'description',
                'image'
            ]);

        $category = $categories->first();


        /*
    |--------------------------------------------------------------------------
    | SUPPLIERS
    |--------------------------------------------------------------------------
    */

        $suppliers = ShopSupplier::get([
            'id',
            'supplier_code',
            'supplier_text',
            'image'
        ]);

        $ImageCategories = ShopSupplier::get([
            'image',
            'supplier_text'
        ]);


        /*
    |--------------------------------------------------------------------------
    | FEATURED PRODUCTS
    |--------------------------------------------------------------------------
    */

        $products = ShopProduct::where('is_featured', true)
            ->orderByDesc('updated_at')
            ->take(6)
            ->get([
                'id',
                'product_name',
                'image',
                'short_description',
                'is_featured',
                'is_new'
            ]);


        /*
    |--------------------------------------------------------------------------
    | NEW PRODUCTS
    |--------------------------------------------------------------------------
    */

        $newProducts = ShopProduct::where('is_new', true)
            ->with([
                'discount' => function ($q) {
                    $q->where('start_date', '<=', now())
                        ->where('end_date', '>=', now());
                }
            ])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('created_at')
            ->get([
                'id',
                'product_name',
                'image',
                'short_description',
                'is_featured',
                'is_new',
                'standard_cost',
                'list_price'
            ]);


        /*
    |--------------------------------------------------------------------------
    | FEATURED + NEW PRODUCTS
    |--------------------------------------------------------------------------
    */

        $featuredProducts = ShopProduct::where('is_featured', true)
            ->where('is_new', true)
            ->with([
                'discount',
                'category'
            ])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('updated_at')
            ->get([
                'id',
                'product_name',
                'image',
                'short_description',
                'is_featured',
                'is_new',
                'standard_cost',
                'list_price',
                'category_id'
            ]);


        /*
    |--------------------------------------------------------------------------
    | HERO CATEGORIES
    |--------------------------------------------------------------------------
    */

        $heroCategories = ShopCategory::get();


        /*
    |--------------------------------------------------------------------------
    | BEST SELLERS
    |--------------------------------------------------------------------------
    */

        $bestSellers = ShopOrderDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold')
        )
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with([
                'product' => function ($q) {
                    $q->select(
                        'id',
                        'product_name',
                        'image',
                        'list_price',
                        'short_description',
                        'category_id'
                    )
                        ->with([
                            'category:id,categories_text',
                            'discount'
                        ])
                        ->withAvg('reviews', 'rating');
                }
            ])
            ->take(8)
            ->get();


        /*
    |--------------------------------------------------------------------------
    | POSTS
    |--------------------------------------------------------------------------
    */

        $ProductPost = ShopPost::all();


        /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */

        $settings = ShopSetting::all()->keyBy('key');


        /*
    |--------------------------------------------------------------------------
    | CATEGORY PRODUCTS
    |
    | PKD  = Đồ nam
    | TPN  = Đồ nữ
    | DDD  = Trang sức
    | DHTM = Đồng hồ
    |--------------------------------------------------------------------------
    */

        // ĐỒ NAM
        $doNam = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('category', function ($query) {
                $query->where('categories_code', 'PKD');
            })
            ->orderByDesc('created_at')
            ->get();


        // ĐỒ NỮ
        $doNu = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('category', function ($query) {
                $query->where('categories_code', 'TPN');
            })
            ->orderByDesc('created_at')
            ->get();


        // TRANG SỨC
        $trangSuc = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('category', function ($query) {
                $query->where('categories_code', 'DDD');
            })
            ->orderByDesc('created_at')
            ->get();


        // ĐỒNG HỒ
        $dongHo = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('category', function ($query) {
                $query->where('categories_code', 'DHTM');
            })
            ->orderByDesc('created_at')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | SUPPLIER PRODUCTS
    |
    | NCC1 = Quần
    | NCC2 = Áo polo
    | NCC3 = Áo sơ mi
    | NCC4 = Giày
    | NCC5 = Túi
    | NCC6 = Áo khoác
    |--------------------------------------------------------------------------
    */

        // QUẦN
        $quan = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('supplier', function ($query) {
                $query->where('supplier_code', 'NCC1');
            })
            ->orderByDesc('created_at')
            ->get();


        // ÁO POLO
        $aoPolo = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('supplier', function ($query) {
                $query->where('supplier_code', 'NCC2');
            })
            ->orderByDesc('created_at')
            ->get();


        // ÁO SƠ MI
        $aoSoMi = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('supplier', function ($query) {
                $query->where('supplier_code', 'NCC3');
            })
            ->orderByDesc('created_at')
            ->get();


        // GIÀY
        $giay = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('supplier', function ($query) {
                $query->where('supplier_code', 'NCC4');
            })
            ->orderByDesc('created_at')
            ->get();


        // TÚI
        $bag = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('supplier', function ($query) {
                $query->where('supplier_code', 'NCC5');
            })
            ->orderByDesc('created_at')
            ->get();


        // ÁO KHOÁC
        $aoKhoac = ShopProduct::with([
            'category',
            'supplier'
        ])
            ->withAvg('reviews', 'rating')
            ->whereHas('supplier', function ($query) {
                $query->where('supplier_code', 'NCC6');
            })
            ->orderByDesc('created_at')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | POST IMAGE
    |--------------------------------------------------------------------------
    */

        $post = ShopProductPost::select([
            'id',
            'post_image',
            'post_title',
            'post_content'
        ])
            ->latest()
            ->first();


        /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */

        return view(
            'frontend.index',
            compact(
                // CATEGORY
                'doNam',
                'doNu',
                'trangSuc',
                'dongHo',

                // SUPPLIER
                'quan',
                'aoPolo',
                'aoSoMi',
                'giay',
                'bag',
                'aoKhoac',

                // GENERAL
                'categories',
                'category',
                'suppliers',
                'ImageCategories',
                'heroCategories',

                // PRODUCTS
                'products',
                'newProducts',
                'featuredProducts',
                'bestSellers',

                // POSTS
                'post',
                'ProductPost',

                // SETTINGS
                'settings'
            )
        );
    }
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();

        $orders = \App\Models\ShopOrder::where('customer_id', $customer->id)->latest()->get();

        $stats = [
            'total'     => $orders->count(),
            'pending'   => $orders->where('order_status', 'Pending')->count(),
            'shipped'   => $orders->where('order_status', 'Shipped')->count(),
            'delivered' => $orders->where('order_status', 'Delivered')->count(),
            'cancelled' => $orders->where('order_status', 'Cancelled')->count(),
        ];
        $categories = ShopCategory::all();

        $recentOrders = $orders->take(5);

        return view('frontend.customer.tongquan', compact(
            'customer',
            'stats',
            'recentOrders',
            'categories'
        ));
    }
    public function orders()
    {
        $categories = ShopCategory::all();
        $customer = Auth::guard('customer')->user();
        $orders = ShopOrder::where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);
        $stats = [
            'total'     => \App\Models\ShopOrder::where('customer_id', $customer->id)->count(),
            'pending'   => \App\Models\ShopOrder::where('customer_id', $customer->id)->where('order_status', 'Pending')->count(),
            'delivered' => \App\Models\ShopOrder::where('customer_id', $customer->id)->where('order_status', 'Delivered')->count(),
            'cancelled' => \App\Models\ShopOrder::where('customer_id', $customer->id)->where('order_status', 'Cancelled')->count(),
        ];
        // Lấy tất cả để đưa vào partial recent_orders
        $recentOrders = \App\Models\ShopOrder::where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('frontend.customer.orders', compact('customer', 'orders', 'categories', 'stats', 'recentOrders'));
    }
}
