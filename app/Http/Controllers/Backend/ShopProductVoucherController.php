<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopProductVoucher;
use App\Models\ShopVoucher;
use App\Models\ShopProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class ShopProductVoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopProductVoucher::with(['product', 'voucher']); 

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('product', function ($qProduct) use ($keyword) {
                    $qProduct->where('product_name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('voucher', function ($qVoucher) use ($keyword) {
                    $qVoucher->where('voucher_name', 'like', '%' . $keyword . '%');
                });
            });
        }

        $dsShopProductVoucher = $query->paginate(5);
        $dsShopVoucher = ShopVoucher::all();
        $dsShopProduct = ShopProduct::all();

        return view('backend.shop_product_voucher.index')
            ->with('dsShopProductVoucher', $dsShopProductVoucher)
            ->with('dsShopVoucher', $dsShopVoucher)
            ->with('dsShopProduct', $dsShopProduct);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'      => 'required|exists:shop_products,id',
            'voucher_id'      => 'required|exists:shop_vouchers,id',
        ], [
            'product_id.required'    => 'Sản phẩm là bắt buộc.',
            'product_id.exists'      => 'Sản phẩm không tồn tại.',
            'voucher_id.required'    => 'Voucher là bắt buộc.',
            'voucher_id.exists'      => 'Voucher không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = new ShopProductVoucher();
        $order->product_id      = $request->product_id;
        $order->voucher_id      = $request->voucher_id;
        $order->save();

        toastify()->success('Thêm đơn hàng thành công');
        return redirect()->route('backend.ShopProductVoucher.index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id'      => 'required|exists:shop_products,id',
            'voucher_id'      => 'required|exists:shop_vouchers,id',

        ], [
            'product_id.required'    => 'Sản phẩm là bắt buộc.',
            'product_id.exists'      => 'Sản phẩm không tồn tại.',
            'voucher_id.required'    => 'Voucher là bắt buộc.',
            'voucher_id.exists'      => 'Voucher không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = ShopProductVoucher::findOrFail($id);
        $order->product_id      = $request->product_id;
        $order->voucher_id      = $request->voucher_id;
        $order->save();

        toastify()->success('Cập nhật đơn hàng thành công');
        return redirect()->route('backend.ShopProductVoucher.index');
    }

    public function destroy($id)
    {
        $order = ShopProductVoucher::findOrFail($id);
        $order->delete();

        toastify()->success('Xóa đơn hàng thành công');
        return redirect()->route('backend.ShopProductVoucher.index');
    }
}