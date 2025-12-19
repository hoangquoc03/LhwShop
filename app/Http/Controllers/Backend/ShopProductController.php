<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopSupplier;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\ShopProductDestroyRequest;
use App\Models\ShopImportDetail;
use App\Http\Requests\StoreProductIndexRequest;

class ShopProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoreProductIndexRequest $request)
    {
        $dsShopProducts = ShopProduct::all();
        $dsShopCategory = ShopCategory::all();
        $dsShopSupplier = ShopSupplier::all();

        return view('backend.shop_product.index')
            ->with('dsShopProducts', $dsShopProducts)
            ->with('dsShopCategory', $dsShopCategory)
            ->with('dsShopSupplier', $dsShopSupplier);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name'        => 'required|min:3|max:100',
            'standard_cost'       => 'required|min:3|max:17',
            'list_price'          => 'required|min:3|max:17',
            'quantity_per_unit'   => 'required|min:1|max:17',
            'discontinued'        => 'required|boolean',
            'is_featured'         => 'required|boolean',
            'is_new'              => 'required|boolean',
            'short_description'   => 'required|string|min:10',
            'image'               => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id'         => 'required|exists:shop_categories,id',
            'supplier_id'         => 'required|exists:shop_suppliers,id',

        ], [
            'product_name.required'      => 'Tên sản phẩm là bắt buộc.',
            'product_name.min'           => 'Tên sản phẩm phải từ 3 ký tự trở lên.',
            'product_name.max'           => 'Tên sản phẩm không được vượt quá 100 ký tự.',

            'standard_cost.required'     => 'Giá tiêu chuẩn là bắt buộc.',
            'standard_cost.min'          => 'Giá tiêu chuẩn phải từ 3 ký tự trở lên.',
            'standard_cost.max'          => 'Giá tiêu chuẩn không được vượt quá 17 ký tự.',

            'list_price.required'        => 'Giá bán là bắt buộc.',
            'list_price.min'             => 'Giá bán phải từ 3 ký tự trở lên.',
            'list_price.max'             => 'Giá bán không được vượt quá 17 ký tự.',

            'quantity_per_unit.required' => 'Số lượng mỗi đơn vị là bắt buộc.',
            'quantity_per_unit.min'      => 'Số lượng phải ít nhất 1 ký tự.',
            'quantity_per_unit.max'      => 'Số lượng không được vượt quá 17 ký tự.',

            'discontinued.required'      => 'Trạng thái ngừng kinh doanh là bắt buộc.',
            'discontinued.boolean'       => 'Giá trị ngừng kinh doanh không hợp lệ.',

            'is_featured.required'       => 'Trường sản phẩm nổi bật là bắt buộc.',
            'is_featured.boolean'        => 'Giá trị sản phẩm nổi bật không hợp lệ.',

            'is_new.required'            => 'Trường sản phẩm mới là bắt buộc.',
            'is_new.boolean'             => 'Giá trị sản phẩm mới không hợp lệ.',

            'short_description.required' => 'Mô tả ngắn là bắt buộc.',
            'short_description.min'      => 'Mô tả ngắn phải ít nhất 10 ký tự.',

            'image.required'             => 'Ảnh sản phẩm là bắt buộc.',
            'image.image'                => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes'                => 'Ảnh phải có định dạng: jpg, jpeg, png hoặc gif.',
            'image.max'                  => 'Kích thước ảnh tối đa là 2MB.',
            'category_id.required'     => 'Danh mục là bắt buộc.',
            'category_id.exists'       => 'Danh mục không tồn tại.',

            'supplier_id.required'     => 'Nhà cung cấp là bắt buộc.',
            'supplier_id.exists'       => 'Nhà cung cấp không tồn tại.',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lưu sản phẩm
        $product = new ShopProduct();
        $product->product_name = $request->product_name;
        $product->standard_cost = $request->standard_cost;
        $product->list_price = $request->list_price;
        $product->quantity_per_unit = $request->quantity_per_unit;
        $product->discontinued = $request->discontinued;
        $product->is_featured = $request->is_featured;
        $product->is_new = $request->is_new;
        $product->short_description = $request->short_description;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $newFileName = date('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/products', $newFileName, 'public');
            $product->image = $newFileName;
        }
        $product->save();
        toastify()->success('Thêm sản phẩm thành công');
        return redirect()->route('backend.Product.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        $product = ShopProduct::findOrFail($id);

        //Validate dữ liệu nếu chưa có ở nơi khác
        // $request->validate([
        //     'product_name'        => 'required|min:3|max:100',
        //     'standard_cost'       => 'required|min:3|max:17',
        //     'list_price'          => 'required|min:3|max:17',
        //     'quantity_per_unit'   => 'required|min:1|max:17',
        //     'discontinued'        => 'required|boolean',
        //     'is_featured'         => 'required|boolean',
        //     'is_new'              => 'required|boolean',
        //     'short_description'   => 'required|string|min:10',
        //     'category_id'         => 'required|exists:shop_categories,id',
        //     'supplier_id'         => 'required|exists:shop_suppliers,id',
        //     'image'               => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        // ]);

        // Cập nhật dữ liệu
        $product->fill([
            'product_name'       => $request->product_name,
            'standard_cost'      => $request->standard_cost,
            'list_price'         => $request->list_price,
            'quantity_per_unit'  => $request->quantity_per_unit,
            'discontinued'       => $request->discontinued,
            'is_featured'        => $request->is_featured,
            'is_new'             => $request->is_new,
            'short_description'  => $request->short_description,
            'category_id'        => $request->category_id,
            'supplier_id'        => $request->supplier_id,
        ]);
        if ($request->filled('image_url')) {
            $product->image = $request->image_url;
        }

        // Xử lý ảnh nếu có upload mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($product->image && Storage::disk('public')->exists('uploads/products/' . $product->image)) {
                Storage::disk('public')->delete('uploads/products/' . $product->image);
            }

            $file = $request->file('image');
            $newFileName = now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/products', $newFileName, 'public');
            $product->image = $newFileName;
        }

        $product->save();

        toastify()->success('Cập nhật sản phẩm thành công');
        return redirect()->route('backend.Product.index');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopProductDestroyRequest $request, $id)
    {
        $product = ShopProduct::find($id);

        if (!$product) {
            return redirect()->route('backend.Product.index')->with('error', 'Sản phẩm không tồn tại');
        }

        // Xóa các bản ghi liên quan (nếu có)
        $product->exportDetails()->delete();

        // Xóa ảnh nếu tồn tại
        $filePath = 'uploads/products/' . $product->image;
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Xóa sản phẩm
        $product->delete();

        return redirect()->route('backend.Product.index')->with('success', 'Xóa sản phẩm thành công');
    }
}
