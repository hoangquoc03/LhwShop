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
use Illuminate\Support\Str;

class CartController extends Controller
{


    public function add(Request $request)
    {
        $product = ShopProduct::findOrFail($request->product_id);

        // ===== CHUẨN HÓA IMAGE (LUÔN LÀ URL) =====
        $image = $product->image;
        if (!Str::startsWith($image, ['http://', 'https://'])) {
            $image = asset('storage/uploads/products/' . $image);
        }

        // ===== SESSION CART =====
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += 1;

            // đảm bảo image luôn đúng
            $cart[$product->id]['image'] = $image;
        } else {
            $cart[$product->id] = [
                'name'     => $product->product_name,
                'price'    => $product->list_price,
                'quantity' => 1,
                'image'    => $image,
            ];
        }

        session()->put('cart', $cart);

        // ===== DB CART (GUARD CUSTOMER) =====
        if (Auth::guard('customer')->check()) {
            $cartDb = ShopCart::firstOrNew([
                'customer_id' => Auth::guard('customer')->id(),
                'product_id'  => $product->id,
            ]);

            $cartDb->quantity = ($cartDb->quantity ?? 0) + 1;
            $cartDb->save();
        }

        return response()->json([
            'success'    => true,
            'cart_count' => collect($cart)->sum('quantity'),
        ]);
    }



    public function index()
    {
        $sessionCart = session()->get('cart', []);

        if (Auth::guard('customer')->check()) {
            $dbCart = ShopCart::where('customer_id', Auth::guard('customer')->id())->get();

            foreach ($dbCart as $item) {
                $product = $item->product;
                if (!$product) continue;

                $originalPrice = (float) $product->list_price; // Giá gốc
                $discountedPrice = $originalPrice;

                if ($product->discount_percent > 0) {
                    $discountedPrice = $originalPrice * (1 - $product->discount_percent / 100);
                }

                $sessionCart[$item->product_id] = [
                    'name'             => $product->product_name ?? 'Product',
                    'price'            => $discountedPrice, // Giá đã giảm
                    'original_price'   => $originalPrice,   // Giá gốc để hiển thị gạch
                    'quantity'         => $item->quantity,
                    'image'            => $product->image
                        ? (Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : asset('storage/uploads/products/' . $product->image))
                        : asset('storage/uploads/default.png'),
                    'discount_percent' => $product->discount_percent ?? 0,
                ];
            }

            session()->put('cart', $sessionCart);
        }

        // Đảm bảo mọi item có key cần thiết
        foreach ($sessionCart as $id => $item) {
            if (!isset($item['image'])) $sessionCart[$id]['image'] = asset('storage/uploads/default.png');
            if (!isset($item['name'])) $sessionCart[$id]['name'] = 'Product';
            if (!isset($item['price'])) $sessionCart[$id]['price'] = 0;
            if (!isset($item['original_price'])) $sessionCart[$id]['original_price'] = $item['price'];
            if (!isset($item['quantity'])) $sessionCart[$id]['quantity'] = 1;
            if (!isset($item['discount_percent'])) $sessionCart[$id]['discount_percent'] = 0;
        }

        $cart = $sessionCart;

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $totalBeforeDiscount = collect($cart)->sum(fn($i) => $i['original_price'] * $i['quantity']);

        return view('frontend.cart.index', compact('cart', 'total', 'totalBeforeDiscount'));
    }





    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        if (Auth::guard('customer')->check()) {
            ShopCart::where('customer_id', Auth::guard('customer')->id())
                ->where('product_id', $id)
                ->delete();
        }
        toastify()->success('Xóa thành công');
        // Redirect về trang giỏ hàng
        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }




    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int)$request->quantity); // đảm bảo >=1
        }

        session()->put('cart', $cart);

        // Cập nhật DB nếu login
        if (Auth::guard('customer')->check()) {
            $cartDb = ShopCart::firstOrNew([
                'customer_id' => Auth::guard('customer')->id(),
                'product_id' => $id,
            ]);
            $cartDb->quantity = $cart[$id]['quantity'];
            $cartDb->save();
        }

        return response()->json([
            'success' => true,
            'cart_count' => collect($cart)->sum('quantity'),
            'item_total' => $cart[$id]['price'] * $cart[$id]['quantity']
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

        // 1️⃣ Tổng tiền gốc (chưa giảm)
        $totalBeforeDiscount = collect($cart)->sum(function ($item) {
            $discountPercent = $item['discount_percent'] ?? 0;

            return $discountPercent > 0
                ? ($item['price'] / (1 - $discountPercent / 100)) * $item['quantity']
                : $item['price'] * $item['quantity'];
        });

        // 2️⃣ Tổng sau giảm giá sản phẩm
        $totalAfterProductDiscount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // 3️⃣ Voucher
        $appliedVoucher = session()->get('voucher');
        $voucherDiscount = 0;

        if ($appliedVoucher) {
            if (!empty($appliedVoucher['discount_percent'])) {
                $voucherDiscount = $totalAfterProductDiscount * ($appliedVoucher['discount_percent'] / 100);
            } elseif (!empty($appliedVoucher['discount_amount'])) {
                $voucherDiscount = $appliedVoucher['discount_amount'];
            }
        }

        // 4️⃣ Ship (nếu có)
        $shippingFee = 0;

        // 5️⃣ Tổng cuối cùng
        $grandTotal = max(
            $totalAfterProductDiscount - $voucherDiscount + $shippingFee,
            0
        );

        // Voucher của khách
        $vouchers = ShopVoucher::whereHas('customers', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id);
        })->get();

        return view('frontend.orders.create', compact(
            'cart',
            'customer',
            'categories',
            'cities',
            'paymentTypes',
            'totalBeforeDiscount',
            'totalAfterProductDiscount',
            'voucherDiscount',
            'shippingFee',
            'grandTotal',
            'vouchers',
            'appliedVoucher'
        ));
    }



    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $cart = \App\Models\ShopCart::where('customer_id', $customer->id)
            ->with('product')
            ->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }




        $request->validate([
            'ship_name'  => 'nullable|string|max:255',
            'ship_phone' => 'nullable|regex:/^[0-9]{9,11}$/',
            'address'    => 'nullable|string|max:255',
            'city'       => 'nullable|exists:cities,id',
            'ward'       => 'nullable|exists:wards,id',
            'delivery_type' => 'required|in:store,home',
            'payment_type_id' => 'required|exists:shop_payment_types,id',

        ]);

        DB::beginTransaction();
        try {
            $city     = \App\Models\City::find($request->city);
            $ward     = \App\Models\Ward::find($request->ward);
            // Địa chỉ đầy đủ hoặc nhận tại cửa hàng
            $shippingFee = $request->delivery_type === 'home' ? 30000 : 0;
            $fullAddress = $request->delivery_type === 'home'
                ? trim($request->address . ', '
                    . ($ward?->name ?? '') . ', '
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
                'shipping_fee' => $shippingFee,
            ]);

            foreach ($cart as $item) {

                $product = $item->product;

                // % giảm của sản phẩm
                $discountPercent = $product->discount_percent ?? 0;

                // Giá gốc
                $unitPrice = $product->list_price;

                // Số tiền giảm trên 1 sản phẩm
                $discountAmount = $discountPercent > 0
                    ? $unitPrice * $discountPercent / 100
                    : 0;

                ShopOrderDetail::create([
                    'order_id'            => $order->id,
                    'product_id'          => $product->id,
                    'quantity'            => $item->quantity,

                    // GIÁ CHUẨN
                    'unit_price'          => $unitPrice,

                    // DISCOUNT
                    'discount_percentage' => $discountPercent,
                    'discount_amount'     => $discountAmount,
                ]);
            }



            DB::commit();

            // Xóa giỏ hàng trong DB
            \App\Models\ShopCart::where('customer_id', $customer->id)->delete();

            // Xóa giỏ hàng session
            session()->forget('cart');

            session()->flash('order_success', $order->id);

            return redirect()->route('orders.success', ['id' => $order->id]);
        } catch (\Exception $e) {
            dd($e->getMessage());
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

    public function getWards($city_id)
    {
        $wards = Ward::where('city_id', $city_id)->get();
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
