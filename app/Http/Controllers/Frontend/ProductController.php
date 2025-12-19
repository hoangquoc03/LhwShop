<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopSupplier;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // Hàm filter giá dùng chung
    private function applyPriceFilter($query, $priceRange)
    {
        switch ($priceRange) {
            case '1': // Dưới 2 triệu
                $query->where('list_price', '<', 20000000);
                break;
            case '2': // 2 - 4 triệu
                $query->whereBetween('list_price', [20000000, 40000000]);
                break;
            case '3': // 4 - 7 triệu
                $query->whereBetween('list_price', [40000000, 70000000]);
                break;
            case '4': // 7 - 13 triệu
                $query->whereBetween('list_price', [70000000, 80000000]);
                break;
            case '5': // 13 - 20 triệu
                $query->whereBetween('list_price', [80000000, 100000000]);
                break;
            case '6': // Trên 20 triệu
                $query->where('list_price', '>', 100000000);
                break;
        }
        return $query;
    }

    // ✅ Lọc theo Category
    public function byCategory(Request $request, $id)
    {
        $category = ShopCategory::findOrFail($id);

        $query = ShopProduct::where('category_id', $id)
            ->with(['discount', 'category:id,categories_text'])
            ->withAvg('reviews', 'rating');

        if ($request->has('price_range')) {
            $this->applyPriceFilter($query, $request->price_range);
        }
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popular': // Phổ biến
                    $query->where('is_featured', 1)
                        ->orderBy('created_at', 'desc');
                    break;

                case 'hot': // Khuyến mãi hot
                    $query->whereHas('discount', function ($q) {
                        $q->where('discount_amount', '>', 0);
                    })->orderBy('created_at', 'desc');
                    break;

                case 'price_asc': // Giá thấp → cao
                    $query->orderBy('list_price', 'asc');
                    break;

                case 'price_desc': // Giá cao → thấp
                    $query->orderBy('list_price', 'desc');
                    break;
                case 'newest': // Mới nhất
                    $query->where('is_new', 1)
                        ->orderBy('created_at', 'desc');
                    break;

                case 'best_seller':
                    $query->withSum('orders as total_quantity', 'quantity')
                        ->having('total_quantity', '>', 5)
                        ->orderByDesc('total_quantity');
                    break;

                case 'top_rated':
                    $query->withAvg('reviews as avg_rating', 'rating')
                        ->having('avg_rating', '>', 3)
                        ->orderByDesc('avg_rating');
                    break;

                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Mặc định sắp xếp mới nhất
            $query->orderBy('created_at', 'desc');
        }


        $products = $query->paginate(8);
        if ($request->ajax()) {
            return view('frontend.category.partials.products', compact('products'))->render();
        }

        $newProducts = ShopProduct::where('category_id', $id)
            ->where('is_featured', 1)
            ->with(['discount', 'category:id,categories_text'])
            ->withAvg('reviews', 'rating')
            ->take(8)
            ->get();



        $categories = ShopCategory::all();

        $suppliers = ShopSupplier::whereIn('id', function ($q) use ($id) {
            $q->select('supplier_id')
                ->from('shop_products')
                ->where('category_id', $id);
        })->get();


        return view(
            'frontend.category.index',
            compact('category', 'products', 'categories', 'suppliers', 'newProducts')
        );
    }

    // ✅ Lọc theo Supplier
    public function bySupplier(Request $request, $id)
    {
        $supplier = ShopSupplier::findOrFail($id);

        $query = ShopProduct::where('supplier_id', $id)
            ->with('discount')
            ->withAvg('reviews', 'rating');

        if ($request->has('price_range')) {
            $this->applyPriceFilter($query, $request->price_range);
        }
        $suppliers = ShopSupplier::all(['id', 'supplier_text', 'image']);

        $products = $query->paginate(12);

        return view(
            'frontend.supplier.index',
            compact('supplier', 'products', 'suppliers')
        );
    }

    public function filter(Request $request)
    {
        $query = ShopProduct::with(['discount', 'category:id,categories_text'])
            ->withAvg('reviews', 'rating');
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popular': // Phổ biến
                    $query->where('is_featured', 1)
                        ->orderBy('created_at', 'desc');
                    break;

                case 'hot': // Khuyến mãi hot
                    $query->whereHas('discount', function ($q) {
                        $q->where('discount_amount', '>', 0);
                    })->orderBy('created_at', 'desc');
                    break;

                case 'price_asc': // Giá thấp → cao
                    $query->orderBy('list_price', 'asc');
                    break;

                case 'price_desc': // Giá cao → thấp
                    $query->orderBy('list_price', 'desc');
                    break;
                case 'newest': // Mới nhất
                    $query->where('is_new', 1)
                        ->orderBy('created_at', 'desc');
                    break;

                case 'best_seller':
                    $query->withSum('orders as total_quantity', 'quantity')
                        ->having('total_quantity', '>', 5)
                        ->orderByDesc('total_quantity');
                    break;

                case 'top_rated':
                    $query->withAvg('reviews as avg_rating', 'rating')
                        ->having('avg_rating', '>', 3)
                        ->orderByDesc('avg_rating');
                    break;

                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Mặc định sắp xếp mới nhất
            $query->orderBy('created_at', 'desc');
        }
        $keyword = $request->input('query');

        if (!empty($keyword)) {
            $query->where('product_name', 'LIKE', '%' . $keyword . '%');
        }
        $category = null;
        $supplier = null;

        // Lọc theo category
        if ($request->filled('category_id') && ShopCategory::whereKey($request->category_id)->exists()) {
            $category = ShopCategory::find($request->category_id);
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo supplier
        if ($request->filled('supplier_id') && ShopSupplier::whereKey($request->supplier_id)->exists()) {
            $supplier = ShopSupplier::find($request->supplier_id);
            $query->where('supplier_id', $request->supplier_id);
        }

        // Lọc theo giá
        if ($request->filled('price_range')) {
            $this->applyPriceFilter($query, $request->price_range);
        }


        $products = $query->orderByDesc('created_at')->paginate(12);
        $queryText = $request->input('query');
        $categories = ShopCategory::all(['id', 'categories_text']);

        return view('frontend.product.filter', compact('products', 'category', 'supplier', 'categories', 'queryText'));
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $products = ShopProduct::where('product_name', 'LIKE', "%$keyword%")
            ->take(10)
            ->get(['id', 'product_name', 'image']); // trả về JSON

        return response()->json($products);
    }

    public function loadMore(Request $request)
    {
        $page = $request->page ?? 1;
        $keyword = $request->keyword ?? '';

        $query = ShopProduct::with(['discount', 'category:id,categories_text'])
            ->withAvg('reviews', 'rating');

        if ($keyword != '') {
            $query->where('product_name', 'LIKE', "%$keyword%");
        }

        $products = $query->orderByDesc('created_at')->paginate(12, ['*'], 'page', $page);

        if ($products->isEmpty()) return ''; // hết dữ liệu

        return view('frontend.product.partials.product_list', compact('products'))->render();
    }

    public function show($id)
    {
        $product = ShopProduct::with([
            'images',
            'reviews.customer', // Đảm bảo load user để hiển thị tên người đánh giá
            'discounts',
            'variants', // Load discounts cho từng variant
            'category'
        ])->findOrFail($id);

        // Rating trung bình
        $reviewsCount = $product->reviews->count();
        $avgRating = $reviewsCount ? $product->reviews->avg('rating') : 0;

        // --- Xử lý giá cho sản phẩm chính ---
        $listPrice = (float) $product->list_price; // Giá gốc sản phẩm chính
        $discountedPrice = $listPrice; // Giá sau giảm giá mặc định là giá gốc
        $percentOff = 0;
        $hasDiscount = false;
        $originalProductDiscount = null; // Biến để lưu thông tin discount của sản phẩm chính

        // Lấy discount đang áp dụng cho sản phẩm chính
        $discount = $product->discounts()
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderByDesc('id') // Lấy discount mới nhất hoặc ưu tiên cao nhất
            ->first();

        if ($discount && $listPrice > 0) {
            $discountAmount = (float) ($discount->discount_amount ?? 0);
            $isPercent = (int) ($discount->is_fixed ?? 0);

            if ($isPercent === 0 && $discountAmount > 0) {
                // Giảm theo %
                $percentOff = min(100, round($discountAmount));
                $discountedPrice = max(0, $listPrice * (1 - $discountAmount / 100));
            } elseif ($isPercent === 1 && $discountAmount > 0) {
                // Giảm theo số tiền cố định
                $discountedPrice = max(0, $listPrice - $discountAmount);
                $percentOff = min(100, round(($discountAmount / $listPrice) * 100));
            }

            $hasDiscount = $discountedPrice < $listPrice;
            $originalProductDiscount = $discount; // Lưu thông tin discount của sản phẩm chính
        }

        // --- Xử lý giá cho từng Variant (để truyền vào Blade data-attributes) ---
        // Chúng ta sẽ tính toán giá cho mỗi variant ở đây để truyền vào data-attributes
        // của các option trong select box.
        foreach ($product->variants as $variant) {
            $variant->calculated_list_price = (float) $variant->price; // Giá gốc của variant
            $variant->calculated_discounted_price = $variant->calculated_list_price;
            $variant->calculated_percent_off = 0;
            $variant->has_discount = false;



            if ($discount && $variant->calculated_list_price > 0) {
                $discountAmount = (float) ($discount->discount_amount ?? 0);
                $isPercent = (int) ($discount->is_fixed ?? 0);

                if ($isPercent === 0 && $discountAmount > 0) {
                    // Giảm theo %
                    $variant->calculated_percent_off = min(100, round($discountAmount));
                    $variant->calculated_discounted_price = max(
                        0,
                        $variant->calculated_list_price * (1 - $discountAmount / 100)
                    );
                } elseif ($isPercent === 1 && $discountAmount > 0) {
                    // Giảm theo số tiền cố định
                    $variant->calculated_discounted_price = max(
                        0,
                        $variant->calculated_list_price - $discountAmount
                    );
                    $variant->calculated_percent_off = min(
                        100,
                        round(($discountAmount / $variant->calculated_list_price) * 100)
                    );
                }

                $variant->has_discount = $variant->calculated_discounted_price < $variant->calculated_list_price;
            }
        }


        $categories = ShopCategory::all();

        return view('frontend.product.show', compact(
            'product',
            'reviewsCount', // Sửa từ 'rating' sang 'reviewsCount'
            'avgRating',    // Thêm avgRating
            'categories',
            'discountedPrice', // Giá sau giảm của sản phẩm chính
            'listPrice',       // Giá gốc của sản phẩm chính
            'hasDiscount',     // Sản phẩm chính có giảm giá không
            'percentOff'       // Phần trăm giảm giá của sản phẩm chính
        ));
    }
}
