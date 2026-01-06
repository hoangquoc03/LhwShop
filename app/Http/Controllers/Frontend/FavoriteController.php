<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopSupplier;
use App\Models\ShopFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class FavoriteController extends Controller
{
    public function add(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ], 401);
        }

        $product = ShopProduct::findOrFail($request->product_id);

        // ✅ LƯU DB (KHÔNG TRÙNG)
        ShopFavorite::firstOrCreate([
            'customer_id' => $customer->id,
            'product_id'  => $product->id,
        ]);

        // ✅ SYNC SESSION
        $favorites = ShopFavorite::where('customer_id', $customer->id)
            ->pluck('product_id')
            ->toArray();

        session(['favorites' => $favorites]);

        // Ảnh
        $image = $product->image;
        if (!Str::startsWith($image, ['http://', 'https://'])) {
            $image = asset('storage/uploads/products/' . $image);
        }

        return response()->json([
            'success' => true,
            'count'   => count($favorites),
            'product' => [
                'id'    => $product->id,
                'name'  => $product->product_name,
                'image' => $image,
                'price' => number_format($product->list_price, 0, ',', '.') . '₫'
            ]
        ]);
    }
    public function index()
    {
        if (Auth::guard('customer')->check()) {
            $favoriteProducts = ShopProduct::whereIn('id', function ($query) {
                $query->select('product_id')
                    ->from('shop_favorites')
                    ->where('customer_id', Auth::guard('customer')->id());
            })->get();
        } else {
            $favoriteIds = array_keys(session('favorites', []));
            $favoriteProducts = ShopProduct::whereIn('id', $favoriteIds)->get();
        }

        $categories = ShopCategory::all(['id', 'categories_text']);

        return view('frontend.favorites.index', compact('favoriteProducts', 'categories'));
    }
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');

        // ✅ NẾU ĐÃ ĐĂNG NHẬP → XÓA DB
        if (Auth::guard('customer')->check()) {

            \App\Models\ShopFavorite::where('customer_id', Auth::guard('customer')->id())
                ->where('product_id', $productId)
                ->delete();

            $count = \App\Models\ShopFavorite::where('customer_id', Auth::guard('customer')->id())
                ->count();

            $favoriteProducts = \App\Models\ShopProduct::whereIn(
                'id',
                \App\Models\ShopFavorite::where('customer_id', Auth::guard('customer')->id())
                    ->pluck('product_id')
            )->take(3)->get();
        }
        // ✅ CHƯA ĐĂNG NHẬP → XÓA SESSION
        else {
            $favorites = session('favorites', []);

            if (($key = array_search($productId, $favorites)) !== false) {
                unset($favorites[$key]);
            }

            $favorites = array_values($favorites);
            session(['favorites' => $favorites]);

            $count = count($favorites);

            $favoriteProducts = \App\Models\ShopProduct::whereIn('id', $favorites)
                ->take(3)
                ->get();
        }

        $html = view('frontend.includes.favorite_dropdown', compact('favoriteProducts'))->render();

        return response()->json([
            'success' => true,
            'count'   => $count,
            'html'    => $html
        ]);
    }
}
