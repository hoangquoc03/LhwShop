<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrder;
use App\Models\ShopProduct;
use App\Models\ShopOrderDetail;
use Illuminate\Support\Facades\Validator;
class ShopOrderDetailController extends Controller
{
    public function index(Request $request)
    {
        $dsShopProducts = ShopProduct::all();
        $dsShopOrders = ShopOrder::all();
        $query = ShopOrderDetail::with(['product', 'order']); 

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('product', function ($q2) use ($keyword) {
                    $q2->where('product_name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('order', function ($q3) use ($keyword) {
                    $q3->where('ship_name', 'like', '%' . $keyword . '%');
                });
            });
        }

        $dsShopOrderDetail= $query->paginate(2);

        return view('backend.shop_order_detail.index')
            ->with('dsShopProducts', $dsShopProducts)
            ->with('dsShopOrders', $dsShopOrders)
            ->with('dsShopOrderDetail', $dsShopOrderDetail);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity'             => 'required|numeric|min:1|max:10',
            'unit_price'           => 'nullable|numeric|min:0',
            'discount_percentage'  => 'nullable|numeric|min:0|max:100',
            'discount_amount'      => 'nullable|numeric|min:0',
            'order_detail_status'  => 'nullable|string|max:1000',
            'product_id'           => 'required|exists:shop_products,id',
            'order_id'             => 'required|exists:shop_orders,id',
        ], [
            'quantity.required'    => 'Vui lòng nhập số lượng.',
            'quantity.numeric'     => 'Số lượng phải là số.',
            'quantity.min'         => 'Số lượng tối thiểu là 1.',
            'quantity.max'         => 'Số lượng tối đa là 10.',

            'unit_price.numeric'   => 'Đơn giá phải là số.',
            'unit_price.min'       => 'Đơn giá không được âm.',

            'discount_percentage.numeric' => 'Phần trăm giảm giá phải là số.',
            'discount_percentage.max'     => 'Phần trăm giảm giá tối đa là 100%.',

            'discount_amount.numeric' => 'Số tiền giảm giá phải là số.',
            'discount_amount.min'     => 'Số tiền giảm giá không được âm.',

            'order_detail_status.string' => 'Trạng thái không hợp lệ.',
            'order_detail_status.max'    => 'Trạng thái không được vượt quá 1000 ký tự.',

            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists'   => 'Sản phẩm không tồn tại.',

            'order_id.required' => 'Vui lòng chọn đơn hàng.',
            'order_id.exists'   => 'Đơn hàng không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $orderDetail = new ShopOrderDetail();
        $orderDetail->quantity            = $request->quantity;
        $orderDetail->unit_price          = $request->unit_price;
        $orderDetail->discount_percentage = $request->discount_percentage;
        $orderDetail->discount_amount     = $request->discount_amount;
        $orderDetail->order_detail_status = $request->order_detail_status;
        $orderDetail->product_id          = $request->product_id;
        $orderDetail->order_id            = $request->order_id;
        $orderDetail->save();

        toastify()->success('Thêm chi tiết đơn hàng thành công');
        return redirect()->route('backend.ShopOrderDetail.index');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity'             => 'required|numeric|min:1|max:10',
            'unit_price'           => 'nullable|numeric|min:0',
            'discount_percentage'  => 'nullable|numeric|min:0|max:100',
            'discount_amount'      => 'nullable|numeric|min:0',
            'order_detail_status'  => 'nullable|string|max:1000',
            'product_id'           => 'required|exists:shop_products,id',
            'order_id'             => 'required|exists:shop_orders,id',
        ], [
            'quantity.required'    => 'Vui lòng nhập số lượng.',
            'quantity.numeric'     => 'Số lượng phải là số.',
            'quantity.min'         => 'Số lượng tối thiểu là 1.',
            'quantity.max'         => 'Số lượng tối đa là 10.',

            'unit_price.numeric'   => 'Đơn giá phải là số.',
            'unit_price.min'       => 'Đơn giá không được âm.',

            'discount_percentage.numeric' => 'Phần trăm giảm giá phải là số.',
            'discount_percentage.max'     => 'Phần trăm giảm giá tối đa là 100%.',

            'discount_amount.numeric' => 'Số tiền giảm giá phải là số.',
            'discount_amount.min'     => 'Số tiền giảm giá không được âm.',

            'order_detail_status.string' => 'Trạng thái không hợp lệ.',
            'order_detail_status.max'    => 'Trạng thái không được vượt quá 1000 ký tự.',

            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists'   => 'Sản phẩm không tồn tại.',

            'order_id.required' => 'Vui lòng chọn đơn hàng.',
            'order_id.exists'   => 'Đơn hàng không tồn tại.',
        ]);

        $orderDetail = ShopOrderDetail::find($id);
        if (!$orderDetail) {
            toastify()->error('Không tìm thấy chi tiết đơn hàng cần cập nhật');
            return redirect()->route('backend.ShopOrderDetail.index');
        }

        $orderDetail->quantity            = $request->quantity;
        $orderDetail->unit_price          = $request->unit_price;
        $orderDetail->discount_percentage = $request->discount_percentage;
        $orderDetail->discount_amount     = $request->discount_amount;
        $orderDetail->order_detail_status = $request->order_detail_status;
        $orderDetail->product_id          = $request->product_id;
        $orderDetail->order_id            = $request->order_id;
        $orderDetail->save();

        toastify()->success('Cập nhật chi tiết đơn hàng thành công');
        return redirect()->route('backend.ShopOrderDetail.index');
    }


    public function destroy(string $id)
    {
        $orderDetail = ShopOrderDetail::find($id);

        if (!$orderDetail) {
            toastify()->error('Không tìm thấy chi tiết đơn hàng để xóa');
            return redirect()->route('backend.ShopOrderDetail.index');
        }

        $orderDetail->delete();

        toastify()->success('Đã xóa chi tiết đơn hàng thành công');
        return redirect()->route('backend.ShopOrderDetail.index');
    }

    public function batchDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            toastify()->error('Vui lòng chọn ít nhất một đánh giá để xóa');
            return redirect()->route('backend.ShopOrderDetail.index');
        }

        ShopOrderDetail::whereIn('id', $ids)->delete();

        toastify()->success('Đã xóa các đánh giá được chọn');
        return redirect()->route('backend.ShopOrderDetail.index');
    }

}