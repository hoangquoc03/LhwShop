<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopOrder;
use App\Models\ShopCart;
use App\Models\ShopOrderDetail;
use App\Models\ShopPaymentType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use App\Models\ShopVoucher;


class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = ShopProduct::findOrFail($request->product_id);

        // ===== SESSION CART =====
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->product_name,
                'price' => $product->list_price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        // ===== DB CART =====
        if (Auth::check()) {
            $cartDb = ShopCart::firstOrNew([
                'customer_id' => Auth::id(),
                'product_id' => $product->id,
            ]);

            $cartDb->quantity = ($cartDb->quantity ?? 0) + 1;
            $cartDb->save();
        }

        return response()->json([
            'success' => true,
            'cart_count' => collect($cart)->sum('quantity'),
        ]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        return view('frontend.cart.index', compact('cart', 'total'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        if (Auth::check()) {
            ShopCart::where('customer_id', Auth::id())
                ->where('product_id', $id)
                ->delete();
        }

        return back();
    }
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $quantity = max(1, (int) $request->quantity); // không cho < 1
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        // Tính lại tổng tiền
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'success'  => true,
            'quantity' => $cart[$id]['quantity'],
            'subtotal' => number_format($cart[$id]['price'] * $cart[$id]['quantity'], 0, ',', '.') . '₫',
            'total'    => number_format($total, 0, ',', '.') . '₫',
        ]);
    }
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        try {
            DB::beginTransaction();


            // ID khách hàng đang login

            $customerId = Auth::guard('customer')->id();
            // hoặc $request->customer_id
            $employeeId = null; // nếu nhân viên tạo đơn thì gán
            $paymentTypeId = $request->payment_type_id;

            // tổng tiền
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            // tạo order
            $order = ShopOrder::create([
                'employee_id'     => $employeeId,
                'customer_id'     => $customerId,
                'order_date'      => Carbon::now(),
                'ship_name'       => $request->ship_name ?? 'Khách hàng',
                'ship_address1'   => $request->ship_address1 ?? 'Địa chỉ mặc định',
                'ship_city'       => $request->ship_city ?? '',
                'ship_country'    => $request->ship_country ?? 'Việt Nam',
                'shipping_fee'    => 0,
                'payment_type_id' => $paymentTypeId,
                'order_status'    => 'pending',
            ]);

            // lưu chi tiết
            foreach ($cart as $productId => $item) {
                ShopOrderDetail::create([
                    'order_id'            => $order->id,
                    'product_id'          => $productId,
                    'quantity'            => $item['quantity'],
                    'unit_price'          => $item['price'],
                    'discount_percentage' => 0,
                    'discount_amount'     => 0,
                    'order_detail_status' => 'pending',
                ]);
            }

            DB::commit();

            // xoá giỏ hàng
            session()->forget('cart');

            return redirect()->route('orders.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    // Hiển thị form nhập thông tin đặt hàng
    public function create()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $customer = Auth::guard('customer')->user();
        $categories = ShopCategory::all();
        $paymentTypes = ShopPaymentType::all();
        $cities = City::all();

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $price = $item['price'];

            // Nếu có giảm giá theo sản phẩm
            if (!empty($item['discount_percent']) && $item['discount_percent'] > 0) {
                $price -= $price * ($item['discount_percent'] / 100);
            } elseif (!empty($item['discount_amount']) && $item['discount_amount'] > 0) {
                $price -= $item['discount_amount'];
            }

            $total += $price * $item['quantity'];
        }

        // Voucher của khách hàng (nhiều)
        $vouchers = ShopVoucher::whereHas('customers', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id);
        })->get();


        // Nếu có voucher đang áp dụng trong session
        $appliedVoucher = session()->get('voucher');
        if ($appliedVoucher) {
            if (!empty($appliedVoucher['discount_percent'])) {
                $total -= $total * ($appliedVoucher['discount_percent'] / 100);
            } elseif (!empty($appliedVoucher['discount_amount'])) {
                $total -= $appliedVoucher['discount_amount'];
            }
        }

        $totalAfterDiscount = max($total, 0);


        return view('frontend.orders.create', compact(
            'cart',
            'customer',
            'categories',
            'cities',
            'paymentTypes',
            'totalAfterDiscount',
            'vouchers',
            'appliedVoucher'
        ));
    }


    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $customer = Auth::guard('customer')->user();

        $request->validate([
            'ship_name'  => 'nullable|string|max:255',
            'ship_phone' => 'nullable|regex:/^[0-9]{9,11}$/',
            'address'    => 'nullable|string|max:255',
            'city'       => 'nullable|exists:cities,id',
            'district'   => 'nullable|exists:districts,id',
            'ward'       => 'nullable|exists:wards,id',
            'delivery_type' => 'required|in:store,home',
        ]);

        DB::beginTransaction();
        try {
            $city     = \App\Models\City::find($request->city);
            $district = \App\Models\District::find($request->district);
            $ward     = \App\Models\Ward::find($request->ward);

            // Địa chỉ đầy đủ hoặc nhận tại cửa hàng
            $fullAddress = $request->delivery_type === 'home'
                ? trim($request->address . ', '
                    . ($ward?->name ?? '') . ', '
                    . ($district?->name ?? '') . ', '
                    . ($city?->name ?? ''))
                : 'Nhận tại cửa hàng';

            $order = \App\Models\ShopOrder::create([
                'customer_id'   => $customer->id,
                'ship_name'     => $request->ship_name ?: $customer->name,
                'ship_phone'    => $request->ship_phone ?: $customer->phone,
                'ship_address1' => $fullAddress,
                'ship_city'     => $city->name ?? '',
                'ship_country'  => 'Việt Nam',
                'order_date'    => now(),
                'order_status'  => \App\Models\ShopOrder::STATUS_PENDING,
                'payment_type_id' => $request->payment_type_id ?? null,
            ]);

            foreach ($cart as $productId => $item) {
                \App\Models\ShopOrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');
            session()->flash('order_success', $order->id);

            // 👉 Chuyển sang trang thành công và truyền $order->id
            return redirect()->route('orders.success', ['id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        // Load đầy đủ order + chi tiết sản phẩm
        $order = ShopOrder::with('details.product', 'payment_type', 'customer')
            ->findOrFail($id);

        $categories = \App\Models\ShopCategory::all();
        $customer = Auth::guard('customer')->user();
        $recentOrders = ShopOrder::with('details')
            ->where('customer_id', Auth::guard('customer')->id())
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('frontend.orders.success', compact('order', 'categories', 'recentOrders', 'customer'));
    }


    public function getDistricts($city_id)
    {
        $districts = District::where('city_id', $city_id)->get();
        return response()->json($districts);
    }

    public function getWards($district_id)
    {
        $wards = Ward::where('district_id', $district_id)->get();
        return response()->json($wards);
    }
    public function payment($id)
    {
        // Lấy thông tin đơn hàng theo id
        $order = \App\Models\ShopOrder::with('details.product')
            ->where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->firstOrFail();
        $categories = ShopCategory::all();
        $paymentTypes = ShopPaymentType::all();
        // Hiển thị view thanh toán
        return view('frontend.orders.payment', compact('order', 'categories', 'paymentTypes'));
    }
    public function cancel($id)
    {
        $order = ShopOrder::findOrFail($id);

        if ($order->order_status === 'Pending') {
            $order->order_status = 'Cancelled';
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được hủy.');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
    }
}
