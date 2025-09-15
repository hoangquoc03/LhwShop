<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ShopProduct;
use App\Models\ShopProductDiscount;
use App\Models\ShopProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShopProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dsShopProducts = ShopProduct::all();

        $query = ShopProductDiscount::with('product'); // load quan hệ product

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                // Tìm theo tên sản phẩm
                $q->whereHas('product', function ($sub) use ($keyword) {
                    $sub->where('product_name', 'like', '%' . $keyword . '%');
                })
                // Hoặc tìm theo tên giảm giá
                ->orWhere('discount_name', 'like', '%' . $keyword . '%');
            });
        }

        $dsShopProductDiscounts = $query->paginate(5);

        return view('backend.shop_product_discount.index', [
            'dsShopProducts' => $dsShopProducts,
            'dsShopProductDiscounts' => $dsShopProductDiscounts
        ]);
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
            'discount_name'   => 'required|min:3|max:100',
            'discount_amount' => 'required|numeric|min:0',
            'product_id'      => 'required|exists:shop_products,id',
            'is_fixed'        => 'required|boolean',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
        ], [
            'discount_name.required' => 'Tên khuyến mãi là bắt buộc.',
            'discount_name.min'      => 'Tên khuyến mãi phải từ 3 ký tự trở lên.',
            'discount_name.max'      => 'Tên khuyến mãi không được vượt quá 100 ký tự.',

            'discount_amount.required' => 'Số tiền hoặc phần trăm giảm là bắt buộc.',
            'discount_amount.numeric'  => 'Giá trị giảm phải là số.',
            'discount_amount.min'      => 'Giá trị giảm không được âm.',

            'product_id.required' => 'Sản phẩm áp dụng là bắt buộc.',
            'product_id.exists'   => 'Sản phẩm được chọn không tồn tại.',

            'is_fixed.required' => 'Kiểu giảm giá là bắt buộc.',
            'is_fixed.boolean'  => 'Kiểu giảm giá không hợp lệ.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date'     => 'Ngày bắt đầu không hợp lệ.',

            'end_date.required'           => 'Ngày kết thúc là bắt buộc.',
            'end_date.date'               => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal'     => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lưu khuyến mãi sản phẩm
        $discount = new ShopProductDiscount();
        $discount->discount_name   = $request->discount_name;
        $discount->discount_amount = $request->discount_amount;
        $discount->product_id      = $request->product_id;
        $discount->is_fixed        = $request->is_fixed;
        $discount->start_date      = $request->start_date;
        $discount->end_date        = $request->end_date;

        $discount->save();

        toastify()->success('Thêm khuyến mãi sản phẩm thành công');
        return redirect()->route('backend.ProductDiscount.index');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate dữ liệu
        $request->validate([
            'discount_name'   => 'required|min:3|max:100',
            'discount_amount' => 'required|numeric|min:0',
            'product_id'      => 'required|exists:shop_products,id',
            'is_fixed'        => 'required|boolean',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
        ], [
            'discount_name.required' => 'Tên khuyến mãi là bắt buộc.',
            'discount_name.min'      => 'Tên khuyến mãi phải từ 3 ký tự trở lên.',
            'discount_name.max'      => 'Tên khuyến mãi không được vượt quá 100 ký tự.',

            'discount_amount.required' => 'Số tiền hoặc phần trăm giảm là bắt buộc.',
            'discount_amount.numeric'  => 'Giá trị giảm phải là số.',
            'discount_amount.min'      => 'Giá trị giảm không được âm.',

            'product_id.required' => 'Sản phẩm áp dụng là bắt buộc.',
            'product_id.exists'   => 'Sản phẩm được chọn không tồn tại.',

            'is_fixed.required' => 'Kiểu giảm giá là bắt buộc.',
            'is_fixed.boolean'  => 'Kiểu giảm giá không hợp lệ.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date'     => 'Ngày bắt đầu không hợp lệ.',

            'end_date.required'           => 'Ngày kết thúc là bắt buộc.',
            'end_date.date'               => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal'     => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        // Lấy bản ghi
        $discount = ShopProductDiscount::find($id);

        if (!$discount) {
            toastify()->error('Không tìm thấy khuyến mãi cần cập nhật');
            return redirect()->route('backend.ProductDiscount.index');
        }

        // Cập nhật dữ liệu
        $discount->discount_name   = $request->discount_name;
        $discount->discount_amount = $request->discount_amount;
        $discount->product_id      = $request->product_id;
        $discount->is_fixed        = $request->is_fixed;
        $discount->start_date      = $request->start_date;
        $discount->end_date        = $request->end_date;
        $discount->save();

        toastify()->success('Cập nhật khuyến mãi thành công');
        return redirect()->route('backend.ProductDiscount.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ShopProductDiscount::destroy($id);
        toastify()->success('Đã xóa thành công');
        return redirect(route('backend.ProductDiscount.index'));
    }
    
    public function batchDelete(Request $request){
        
    }
}