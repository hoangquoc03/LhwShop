<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\ShopProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class ShopProductVariantController extends Controller
{
    public function index(Request $request)
    {
        $dsShopProducts = ShopProduct::all();

        $query = ProductVariant::with('product');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('variant_name', 'like', '%' . $keyword . '%')
                  ->orWhere('sku', 'like', '%' . $keyword . '%')
                  ->orWhereHas('product', function ($sub) use ($keyword) {
                      $sub->where('product_name', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $dsShopProductVariants = $query->paginate(10);

        return view('backend.shop_product_variant.index', compact('dsShopProducts', 'dsShopProductVariants'));
    }

    /**
     * Hiển thị form tạo biến thể
     */
    public function create()
    {
        $dsShopProducts = ShopProduct::all();
        return view('backend.shop_product_variant.create', compact('dsShopProducts'));
    }

    /**
     * Lưu biến thể mới
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku'            => 'required|string|max:100|unique:shop_product_variants,sku',
            'variant_name'   => 'nullable|string|max:255',
            'price'          => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'options'        => 'nullable|array',
            'product_id'     => 'required|exists:shop_products,id',
            'is_active'      => 'nullable|boolean',
        ],[
            'sku.required'      => 'Mã SKU là bắt buộc.',
            'sku.unique'        => 'Mã SKU đã tồn tại, vui lòng nhập mã khác.',
            'sku.max'           => 'Mã SKU không được vượt quá 100 ký tự.',

            'variant_name.max'  => 'Tên biến thể không được vượt quá 255 ký tự.',

            'price.numeric'     => 'Giá phải là số.',
            'price.min'         => 'Giá không được âm.',

            'stock_quantity.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock_quantity.integer'  => 'Số lượng tồn kho phải là số nguyên.',
            'stock_quantity.min'      => 'Số lượng tồn kho không được âm.',

            'product_id.required' => 'Sản phẩm áp dụng là bắt buộc.',
            'product_id.exists'   => 'Sản phẩm được chọn không tồn tại.',


            'is_active.boolean'  => 'Trạng thái không hợp lệ.',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProductVariant::create($request->all());

        toastify()->success('Thêm biến thể sản phẩm thành công');
        return redirect()->route('backend.ProductVariant.index');
    }

    /**
     * Hiển thị form chỉnh sửa biến thể
     */
    public function edit($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $dsShopProducts = ShopProduct::all();
        return view('backend.shop_product_variant.edit', compact('variant', 'dsShopProducts'));
    }

    /**
     * Cập nhật biến thể
     */
    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'sku'            => 'required|string|max:100|unique:shop_product_variants,sku,' . $id,
            'variant_name'   => 'nullable|string|max:255',
            'price'          => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'options'        => 'nullable|array',
            'product_id'     => 'required|exists:shop_products,id',
            'is_active'      => 'nullable|boolean',
        ],[
            'sku.required'      => 'Mã SKU là bắt buộc.',
            'sku.unique'        => 'Mã SKU đã tồn tại, vui lòng nhập mã khác.',
            'sku.max'           => 'Mã SKU không được vượt quá 100 ký tự.',

            'variant_name.max'  => 'Tên biến thể không được vượt quá 255 ký tự.',

            'price.numeric'     => 'Giá phải là số.',
            'price.min'         => 'Giá không được âm.',

            'stock_quantity.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock_quantity.integer'  => 'Số lượng tồn kho phải là số nguyên.',
            'stock_quantity.min'      => 'Số lượng tồn kho không được âm.',

            'product_id.required' => 'Sản phẩm áp dụng là bắt buộc.',
            'product_id.exists'   => 'Sản phẩm được chọn không tồn tại.',

            
            'is_active.boolean'  => 'Trạng thái không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $variant->update($request->all());

        toastify()->success('Cập nhật biến thể sản phẩm thành công');
        return redirect()->route('backend.ProductVariant.index');
    }

    /**
     * Xóa biến thể
     */
    public function destroy($id)
    {
        ProductVariant::destroy($id);
        toastify()->success('Đã xóa biến thể sản phẩm');
        return redirect()->route('backend.ProductVariant.index');
    }
}