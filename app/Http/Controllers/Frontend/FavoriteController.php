<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopSupplier;


class FavoriteController extends Controller
{
    public function add(Request $request)
    {
        $product = ShopProduct::findOrFail($request->product_id);

        // Lấy danh sách yêu thích hiện tại từ session
        $favorites = session()->get('favorites', []);

        // Nếu sản phẩm chưa có trong danh sách thì thêm
        if(!in_array($product->id, $favorites)){
            $favorites[] = $product->id;
            session(['favorites' => $favorites]);
        }
        $imageUrl = asset('storage/uploads/products/' . basename($product->image));

        return response()->json([
            'success' => true,
            'count' => count($favorites),
            'product' => [
                'id' => $product->id,
                'name' => $product->product_name,
                'image' => $imageUrl,
                'price' => number_format($product->list_price,0,',','.') . '₫'
            ]
        ]);
    }
    public function index()
    {
        $favoriteIds = session('favorites', []);
        $favoriteProducts = ShopProduct::whereIn('id', $favoriteIds)->get();
        $categories = ShopCategory::all(['id','categories_text']);
        return view('frontend.favorites.index', compact('favoriteProducts', 'categories'));
    }
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $favorites = session('favorites', []);

        if(($key = array_search($productId, $favorites)) !== false){
            unset($favorites[$key]);
            session(['favorites' => $favorites]);
        }

        $favorites = array_values($favorites); // reset lại index
        session(['favorites' => $favorites]);

        // Lấy lại 3 sản phẩm mới nhất
        $favoriteProducts = \App\Models\ShopProduct::whereIn('id', $favorites)->take(3)->get();

        $html = view('frontend.includes.favorite_dropdown', compact('favoriteProducts'))->render();

        return response()->json([
            'success' => true,
            'count' => count($favorites),
            'html'   => $html
        ]);
    }

}