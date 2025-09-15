<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopVoucher;
use Illuminate\Support\Facades\Validator;
class ShopVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ShopVoucher::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('voucher_code', 'like', '%' . $keyword . '%')
                ->orWhere('voucher_name', 'like', '%' . $keyword . '%');
            });
        }

        $dsShopVouchers = $query->paginate(5);

        return view('backend.shop_voucher.index', [
            'dsShopVouchers' => $dsShopVouchers
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
        // Validate dữ liệu nhập vào
        $validator = Validator::make($request->all(), [
            'voucher_code'     => 'required|string|min:3|max:100|unique:shop_vouchers,voucher_code',
            'voucher_name'     => 'required|string|min:3|max:100',
            'description'      => 'required|string|min:3|max:255',
            'uses'             => 'required|integer|min:0',
            'max_uses'         => 'required|integer|min:1',
            'max_uses_user'    => 'required|integer|min:1',
            'discount_amount'  => 'required|numeric|min:0',
            'is_fixed'         => 'required|boolean',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
        ], [
            'voucher_code.required' => 'Mã khuyến mãi là bắt buộc.',
            'voucher_code.min'      => 'Mã khuyến mãi phải từ 3 ký tự trở lên.',
            'voucher_code.max'      => 'Mã khuyến mãi không được vượt quá 100 ký tự.',
            'voucher_code.unique'   => 'Mã khuyến mãi này đã tồn tại.',

            'voucher_name.required' => 'Tên khuyến mãi là bắt buộc.',
            'voucher_name.min'      => 'Tên khuyến mãi phải từ 3 ký tự trở lên.',
            'voucher_name.max'      => 'Tên khuyến mãi không được vượt quá 100 ký tự.',

            'description.required'  => 'Mô tả là bắt buộc.',
            'description.min'       => 'Mô tả phải từ 3 ký tự trở lên.',
            'description.max'       => 'Mô tả không được vượt quá 255 ký tự.',

            'uses.required'         => 'Số lần sử dụng là bắt buộc.',
            'uses.integer'          => 'Số lần sử dụng phải là số nguyên.',

            'max_uses.required'     => 'Tổng số lần sử dụng là bắt buộc.',
            'max_uses.integer'      => 'Tổng số lần sử dụng phải là số nguyên.',
            'max_uses.min'          => 'Tổng số lần sử dụng phải lớn hơn 0.',

            'max_uses_user.required'=> 'Số lần sử dụng tối đa mỗi người là bắt buộc.',
            'max_uses_user.integer' => 'Số lần sử dụng tối đa mỗi người phải là số nguyên.',
            'max_uses_user.min'     => 'Số lần sử dụng tối đa mỗi người phải lớn hơn 0.',


            'discount_amount.required' => 'Giá trị giảm là bắt buộc.',
            'discount_amount.numeric'  => 'Giá trị giảm phải là số.',
            'discount_amount.min'      => 'Giá trị giảm không được âm.',

            'is_fixed.required'     => 'Kiểu giảm giá là bắt buộc.',
            'is_fixed.boolean'      => 'Kiểu giảm giá không hợp lệ.',

            'start_date.required'   => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date'       => 'Ngày bắt đầu không hợp lệ.',

            'end_date.required'     => 'Ngày kết thúc là bắt buộc.',
            'end_date.date'         => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal'=> 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo voucher mới
        $voucher = new ShopVoucher();
        $voucher->voucher_code    = $request->voucher_code;
        $voucher->voucher_name    = $request->voucher_name;
        $voucher->description     = $request->description;
        $voucher->uses            = $request->uses;
        $voucher->max_uses        = $request->max_uses;
        $voucher->max_uses_user   = $request->max_uses_user;
        $voucher->type            = $request->type;
        $voucher->discount_amount = $request->discount_amount;
        $voucher->is_fixed        = $request->is_fixed;
        $voucher->start_date      = $request->start_date;
        $voucher->end_date        = $request->end_date;

        $voucher->save();

        toastify()->success('Thêm voucher thành công');
        return redirect()->route('backend.ShopVoucher.index');
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
            'voucher_code'     => 'required|min:3|max:100',
            'voucher_name'     => 'required|min:3|max:100',
            'description'      => 'nullable|max:255',
            'uses'             => 'required|integer|min:0',
            'max_uses'         => 'required|integer|min:0',
            'max_uses_user'    => 'required|integer|min:0',
            'discount_amount'  => 'required|numeric|min:0',
            'is_fixed'         => 'required|boolean',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
        ], [
            'voucher_code.required' => 'Mã khuyến mãi là bắt buộc.',
            'voucher_code.min'      => 'Mã khuyến mãi phải từ 3 ký tự trở lên.',
            'voucher_code.max'      => 'Mã khuyến mãi không được vượt quá 100 ký tự.',

            'voucher_name.required' => 'Tên khuyến mãi là bắt buộc.',
            'voucher_name.min'      => 'Tên khuyến mãi phải từ 3 ký tự trở lên.',
            'voucher_name.max'      => 'Tên khuyến mãi không được vượt quá 100 ký tự.',

            'discount_amount.required' => 'Số tiền hoặc phần trăm giảm là bắt buộc.',
            'discount_amount.numeric'  => 'Giá trị giảm phải là số.',
            'discount_amount.min'      => 'Giá trị giảm không được âm.',

            'is_fixed.required' => 'Kiểu giảm giá là bắt buộc.',
            'is_fixed.boolean'  => 'Kiểu giảm giá không hợp lệ.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date'     => 'Ngày bắt đầu không hợp lệ.',

            'end_date.required'       => 'Ngày kết thúc là bắt buộc.',
            'end_date.date'           => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        // Lấy bản ghi
        $voucher = ShopVoucher::find($id);
        if (!$voucher) {
            toastify()->error('Không tìm thấy voucher cần cập nhật');
            return redirect()->route('backend.ShopVoucher.index');
        }

        // Cập nhật dữ liệu
        $voucher->voucher_code     = $request->voucher_code;
        $voucher->voucher_name     = $request->voucher_name;
        $voucher->description      = $request->description;
        $voucher->uses             = $request->uses;
        $voucher->max_uses         = $request->max_uses;
        $voucher->max_uses_user    = $request->max_uses_user;
        $voucher->type             = $request->type;
        $voucher->discount_amount  = $request->discount_amount;
        $voucher->is_fixed         = $request->is_fixed;
        $voucher->start_date       = $request->start_date;
        $voucher->end_date         = $request->end_date;
        $voucher->save();

        toastify()->success('Cập nhật voucher thành công');
        return redirect()->route('backend.ShopVoucher.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = ShopVoucher::find($id);

        if (!$voucher) {
            toastify()->error('Không tìm thấy voucher để xóa');
            return redirect()->route('backend.ShopVoucher.index');
        }

        $voucher->delete();

        toastify()->success('Đã xóa voucher thành công');
        return redirect()->route('backend.ShopVoucher.index');
    }

    public function batchDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            toastify()->error('Vui lòng chọn ít nhất một voucher để xóa');
            return redirect()->route('backend.ShopVoucher.index');
        }

        ShopVoucher::whereIn('id', $ids)->delete();

        toastify()->success('Đã xóa các voucher được chọn');
        return redirect()->route('backend.ShopVoucher.index');
    }
}