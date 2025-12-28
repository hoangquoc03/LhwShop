<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startLastWeek = $startOfWeek->copy()->subWeek();
        $endLastWeek = $endOfWeek->copy()->subWeek();

        // Lấy đơn hàng tuần này, bỏ đơn hủy
        $orders = ShopOrder::with('details')
            ->whereBetween('order_date', [$startOfWeek, $endOfWeek])
            ->where('order_status', '!=', ShopOrder::STATUS_CANCELLED)
            ->get();

        $chartData = [];
        $totalOrders = 0;

        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $dayLabel = $day->format('D');

            $ordersOfDay = $orders->filter(function ($order) use ($day) {
                $orderDate = Carbon::parse($order->order_date);
                return $orderDate->format('Y-m-d') === $day->format('Y-m-d');
            });

            $total = $ordersOfDay->sum(fn($order) => $order->total);
            $totalOrders += $ordersOfDay->count();

            $chartData[] = [
                'date' => $dayLabel,
                'total' => (float) $total,
            ];
        }

        $totalWeek = array_sum(array_column($chartData, 'total'));
        $totalCustomers = $orders->pluck('customer_id')->unique()->count();

        // Top sản phẩm tuần này
        $topProducts = DB::table('shop_order_details')
            ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_details.order_id')
            ->join('shop_products', 'shop_products.id', '=', 'shop_order_details.product_id')
            ->select(
                'shop_products.id as product_id',
                'shop_products.product_name as product_name',
                'shop_products.image',
                DB::raw('SUM(shop_order_details.quantity) as total_quantity')
            )
            ->whereBetween('shop_orders.order_date', [$startOfWeek, $endOfWeek])
            ->where('shop_orders.order_status', '!=', ShopOrder::STATUS_CANCELLED)
            ->groupBy('shop_products.id', 'shop_products.product_name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Top sản phẩm tuần trước
        $lastWeekProducts = DB::table('shop_order_details')
            ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_details.order_id')
            ->select(
                'shop_order_details.product_id',
                DB::raw('SUM(shop_order_details.quantity) as total_quantity')
            )
            ->whereBetween('shop_orders.order_date', [$startLastWeek, $endLastWeek])
            ->where('shop_orders.order_status', '!=', ShopOrder::STATUS_CANCELLED)
            ->groupBy('shop_order_details.product_id')
            ->pluck('total_quantity', 'product_id'); // key = product_id

        // Tính trend tăng/giảm
        $topProducts = $topProducts->map(function ($product) use ($lastWeekProducts) {
            $lastQty = $lastWeekProducts[$product->product_id] ?? 0;
            if ($lastQty == 0 && $product->total_quantity > 0) {
                $product->trend = 100; // mới xuất hiện
            } elseif ($lastQty == 0) {
                $product->trend = 0; // không thay đổi
            } else {
                $product->trend = round((($product->total_quantity - $lastQty) / $lastQty) * 100);
            }
            return $product;
        });

        return view('backend.admin.dashboard', compact(
            'chartData',
            'totalWeek',
            'totalOrders',
            'totalCustomers',
            'topProducts'
        ));
    }
}
