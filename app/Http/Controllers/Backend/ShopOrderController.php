<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AclUser;
use App\Models\ShopCustomer;
use App\Models\ShopOrder;
use App\Models\ShopPaymentType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class ShopOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopOrder::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ship_address1', 'like', '%' . $keyword . '%')
                ->orWhere('ship_name', 'like', '%' . $keyword . '%');
            });
        }

        $dsShopOrders = $query->paginate(5);
        $dsAclUsers = AclUser::all();
        $dsShopCustomer = ShopCustomer::all();
        $dsShopPaymentType = ShopPaymentType::all();

        return view('backend.shop_order.index')
            ->with('dsShopOrders', $dsShopOrders)
            ->with('dsAclUsers', $dsAclUsers)
            ->with('dsShopCustomer', $dsShopCustomer)
            ->with('dsShopPaymentType', $dsShopPaymentType);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_date'       => 'required|date',
            'shipped_date'     => 'nullable|date|after_or_equal:order_date',
            'ship_name'        => 'required|string|min:3|max:255',
            'ship_address1'    => 'required|string|min:3|max:255',
            'ship_state'       => 'nullable|string|max:100',
            'ship_postal_code' => 'nullable|string|max:20',
            'shipping_fee'     => 'required|numeric|min:0',
            'paid_date'        => 'nullable|date|after_or_equal:order_date',
            'order_status'     => 'required', // Ví dụ: 0=pending,1=shipped,2=completed
            'employee_id'      => 'required|exists:acl_users,id',
            'customer_id'      => 'required|exists:shop_customers,id',
            'payment_type_id'  => 'required|exists:shop_payment_types,id',
        ], [
            'order_date.required'   => 'Ngày đặt hàng là bắt buộc.',
            'order_date.date'       => 'Ngày đặt hàng không hợp lệ.',

            'shipped_date.date'     => 'Ngày giao hàng không hợp lệ.',
            'shipped_date.after_or_equal' => 'Ngày giao phải sau hoặc bằng ngày đặt.',

            'ship_name.required'    => 'Tên người nhận là bắt buộc.',
            'ship_address1.required'=> 'Địa chỉ giao hàng là bắt buộc.',

            'shipping_fee.required' => 'Phí vận chuyển là bắt buộc.',
            'shipping_fee.numeric'  => 'Phí vận chuyển phải là số.',

            'order_status.required' => 'Trạng thái đơn hàng là bắt buộc.',

            'employee_id.exists'    => 'Nhân viên không tồn tại.',
            'customer_id.exists'    => 'Khách hàng không tồn tại.',
            'payment_type_id.exists'=> 'Phương thức thanh toán không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = new ShopOrder();
        $order->order_date       = $request->order_date;
        $order->shipped_date     = $request->shipped_date;
        $order->ship_name        = $request->ship_name;
        $order->ship_address1    = $request->ship_address1;
        $order->ship_state       = $request->ship_state;
        $order->ship_postal_code = $request->ship_postal_code;
        $order->shipping_fee     = $request->shipping_fee;
        $order->paid_date        = $request->paid_date;
        $order->order_status     = $request->order_status;
        $order->employee_id      = $request->employee_id;
        $order->customer_id      = $request->customer_id;
        $order->payment_type_id  = $request->payment_type_id;
        $order->save();

        toastify()->success('Thêm đơn hàng thành công');
        return redirect()->route('backend.ShopOrder.index');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'order_date'       => 'required|date',
            'shipped_date'     => 'nullable|date|after_or_equal:order_date',
            'ship_name'        => 'required|string|min:3|max:255',
            'ship_address1'    => 'required|string|min:3|max:255',
            'ship_state'       => 'nullable|string|max:100',
            'ship_postal_code' => 'nullable|string|max:20',
            'shipping_fee'     => 'required|numeric|min:0',
            'paid_date'        => 'nullable|date|after_or_equal:order_date',
            'order_status'     => 'required',
            'employee_id'      => 'required|exists:acl_users,id',
            'customer_id'      => 'required|exists:shop_customers,id',
            'payment_type_id'  => 'required|exists:shop_payment_types,id',
        ], [
            'order_date.required'   => 'Ngày đặt hàng là bắt buộc.',
            'order_date.date'       => 'Ngày đặt hàng không hợp lệ.',

            'shipped_date.date'     => 'Ngày giao hàng không hợp lệ.',
            'shipped_date.after_or_equal' => 'Ngày giao phải sau hoặc bằng ngày đặt.',

            'ship_name.required'    => 'Tên người nhận là bắt buộc.',
            'ship_address1.required'=> 'Địa chỉ giao hàng là bắt buộc.',

            'shipping_fee.required' => 'Phí vận chuyển là bắt buộc.',
            'shipping_fee.numeric'  => 'Phí vận chuyển phải là số.',

            'order_status.required' => 'Trạng thái đơn hàng là bắt buộc.',

            'employee_id.exists'    => 'Nhân viên không tồn tại.',
            'customer_id.exists'    => 'Khách hàng không tồn tại.',
            'payment_type_id.exists'=> 'Phương thức thanh toán không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = ShopOrder::findOrFail($id);
        $order->order_date       = $request->order_date;
        $order->shipped_date     = $request->shipped_date;
        $order->ship_name        = $request->ship_name;
        $order->ship_address1    = $request->ship_address1;
        $order->ship_state       = $request->ship_state;
        $order->ship_postal_code = $request->ship_postal_code;
        $order->shipping_fee     = $request->shipping_fee;
        $order->paid_date        = $request->paid_date;
        $order->order_status     = $request->order_status;
        $order->employee_id      = $request->employee_id;
        $order->customer_id      = $request->customer_id;
        $order->payment_type_id  = $request->payment_type_id;
        $order->save();

        toastify()->success('Cập nhật đơn hàng thành công');
        return redirect()->route('backend.ShopOrder.index');
    }

    public function destroy($id)
    {
        $order = ShopOrder::findOrFail($id);
        $order->delete();

        toastify()->success('Xóa đơn hàng thành công');
        return redirect()->route('backend.ShopOrder.index');
    }

}