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
    public function index() {
        
        $categories = ShopCategory::with([
            'products' => function($q) {
                $q->select('id','product_name','category_id','supplier_id','is_featured','is_new')
                ->orderByDesc('created_at')
                ->take(6);
            },
            'products.supplier:id,supplier_text,image' // ⚡ load supplier theo product
        ])
        ->get(['id','categories_text','description','image']);
        $category = $categories->first(); 

        $suppliers = ShopSupplier::all(['id', 'supplier_text','image']);
        
        $products = ShopProduct::where('is_featured', true)
        ->orderBy('updated_at', 'desc')
        ->take(6)
        ->get(['id', 'product_name', 'image','short_description', 'is_featured', 'is_new']); 

        $newProducts = ShopProduct::where('is_new', true)
        ->withAvg('reviews', 'rating')
        ->with('discount')
        ->take(8)
        ->get(['id', 'product_name', 'image','short_description', 'is_featured', 'is_new', 'standard_cost', 'list_price']);

        $featuredProducts = ShopProduct::where('is_featured', true)
        ->where('is_new', true) 
        ->withAvg('reviews', 'rating')
        ->with('discount', 'category')
        ->get(['id', 'product_name', 'image','short_description', 'is_featured', 'is_new', 'standard_cost', 'list_price']);

        $specialCategories = ShopCategory::whereIn('categories_code', ['PHONE','LTVP','MTB'])
        ->take(3)
        ->get(['id','categories_text','image','categories_code']);

        
        $bestSellers = ShopOrderDetail::select('product_id', DB::raw('SUM(quantity) as total_sold'))
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->with(['product' => function($q) {
            $q->select('id','product_name','image','list_price','short_description','category_id')
            ->with('category:id,categories_text')
            ->with('discount') // ⚡ thêm discount
            ->withAvg('reviews', 'rating'); // ⚡ thêm rating trung bình
        }])
        ->take(8) // số lượng sp hiển thị
        ->get();

        $ProductPost = ShopProductPost::all();

        $settings = ShopSetting::all()->keyBy('key');
        $bannerPosts = ShopPost::whereNotNull('post_image')
        ->orderByDesc('created_at')
        ->take(5)
        ->get(['id', 'post_title', 'post_image', 'post_slug']);

        $watch = ShopProduct::with(['category', 'supplier'])
        ->whereHas('category', function($query) {
            $query->where('categories_code', 'DHTM');
        })
        ->get();

        $screen = ShopProduct::with(['category', 'supplier'])
        ->whereHas('category', function($query) {
            $query->where('categories_code', 'CPL');
        })
        ->get();

        $screenIpad = ShopProduct::with(['category', 'supplier'])
        ->whereHas('category', function($query) {
            $query->where('categories_code', 'MTB');
        })
        ->get();
        $LAPTOP = ShopProduct::with(['category', 'supplier'])
        ->whereHas('category', function($query) {
            $query->where('categories_code', 'LTVP');
        })
        ->get();

        return view('frontend.index',
         compact('categories', 'suppliers','products', 
         'specialCategories', 'newProducts', 'bestSellers',
          'settings', 'bannerPosts',
           'featuredProducts', 'category', 'watch', 'screen',
            'screenIpad', 'LAPTOP','ProductPost'));
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

        return view('frontend.customer.tongquan', compact('customer', 'stats', 'recentOrders',
         'categories'));
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