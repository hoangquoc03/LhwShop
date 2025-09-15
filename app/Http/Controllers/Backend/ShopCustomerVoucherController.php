<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopVoucher;
use App\Models\ShopCustomer;
use App\Models\ShopCustomerVoucher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ShopCustomerVoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopCustomerVoucher::with(['customer', 'voucher']); 

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('customer', function ($qProduct) use ($keyword) {
                    $qProduct->where('username', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('voucher', function ($qVoucher) use ($keyword) {
                    $qVoucher->where('voucher_name', 'like', '%' . $keyword . '%');
                });
            });
        }

        $dsShopCustomerVoucher = $query->paginate(5);
        $dsShopVoucher = ShopVoucher::all();
        $dsShopCustomer = ShopCustomer::all();

        return view('backend.shop_customer_voucher.index')
            ->with('dsShopCustomerVoucher', $dsShopCustomerVoucher)
            ->with('dsShopVoucher', $dsShopVoucher)
            ->with('dsShopCustomer', $dsShopCustomer);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'      => 'required|exists:shop_products,id',
            'voucher_id'      => 'required|exists:shop_vouchers,id',
        ], [
            'customer_id.required'    => 'Sản phẩm là bắt buộc.',
            'customer_id.exists'      => 'Sản phẩm không tồn tại.',
            'voucher_id.required'    => 'Voucher là bắt buộc.',
            'voucher_id.exists'      => 'Voucher không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = new ShopCustomerVoucher();
        $order->customer_id      = $request->customer_id;
        $order->voucher_id      = $request->voucher_id;
        $order->save();

        toastify()->success('Thêm đơn hàng thành công');
        return redirect()->route('backend.ShopCustomerVoucher.index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'      => 'required|exists:shop_products,id',
            'voucher_id'      => 'required|exists:shop_vouchers,id',

        ], [
            'customer_id.required'    => 'Sản phẩm là bắt buộc.',
            'customer_id.exists'      => 'Sản phẩm không tồn tại.',
            'voucher_id.required'    => 'Voucher là bắt buộc.',
            'voucher_id.exists'      => 'Voucher không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = ShopCustomerVoucher::findOrFail($id);
        $order->customer_id      = $request->customer_id;
        $order->voucher_id      = $request->voucher_id;
        $order->save();

        toastify()->success('Cập nhật đơn hàng thành công');
        return redirect()->route('backend.ShopCustomerVoucher.index');
    }

    public function destroy($id)
    {
        $order = ShopCustomerVoucher::findOrFail($id);
        $order->delete();

        toastify()->success('Xóa đơn hàng thành công');
        return redirect()->route('backend.ShopCustomerVoucher.index');
    }
}