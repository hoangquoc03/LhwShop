<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderAdminMail;
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
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class CartController extends Controller
{


    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:shop_products,id',
            'variant_id' => 'nullable|exists:shop_product_variants,id',
            'quantity'   => 'nullable|integer|min:1'
        ]);

        $qty = $request->quantity ?? 1;

        $product = ShopProduct::findOrFail($request->product_id);

        // ===== VARIANT =====
        $variant = null;
        if ($request->filled('variant_id')) {
            $variant = ProductVariant::where('id', $request->variant_id)
                ->where('product_id', $product->id)
                ->firstOrFail();

            if ($variant->stock_quantity < $qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không đủ tồn kho'
                ]);
            }
        }

        // ===== IMAGE =====
        $imageSource = $variant?->image ?: $product->image;
        $image = Str::startsWith($imageSource, ['http://', 'https://'])
            ? $imageSource
            : asset('storage/uploads/products/' . $imageSource);

        // ===== PRICE =====
        $price = $variant?->price ?? $product->list_price;

        // ===== CART KEY =====
        $cartKey = $variant
            ? $product->id . '_' . $variant->id
            : (string) $product->id;

        // ===== SESSION CART =====
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $qty;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name'       => $product->product_name,
                'variant'    => $variant
                    ? trim(($variant->color ?? '') . ' ' . ($variant->size ?? ''))
                    : null,
                'price'      => $price,
                'quantity'   => $qty,
                'image'      => $image,
            ];
        }

        session()->put('cart', $cart);

        // ===== DB CART =====
        if (Auth::guard('customer')->check()) {

            $cartQuery = ShopCart::where('customer_id', Auth::guard('customer')->id())
                ->where('product_id', $product->id);

            if ($variant) {
                $cartQuery->where('variant_id', $variant->id);
            } else {
                $cartQuery->whereNull('variant_id');
            }

            $cartDb = $cartQuery->first();

            if ($cartDb) {
                $cartDb->quantity += $qty;
            } else {
                $cartDb = new ShopCart([
                    'customer_id' => Auth::guard('customer')->id(),
                    'product_id'  => $product->id,
                    'variant_id'  => $variant?->id,
                    'quantity'    => $qty,
                ]);
            }
            $cartDb->save();
        }


        return response()->json([
            'success'    => true,
            'cart_count' => collect($cart)->sum('quantity'),
        ]);
    }





    public function index()
    {
        $cart = [];

        // ===== NẾU ĐÃ LOGIN → LẤY DB =====
        if (Auth::guard('customer')->check()) {

            $dbCart = ShopCart::with(['product', 'variant'])
                ->where('customer_id', Auth::guard('customer')->id())
                ->get();

            foreach ($dbCart as $item) {

                if (!$item->product) continue;

                $product = $item->product;
                $variant = $item->variant;

                // ===== CART KEY =====
                $key = $variant
                    ? $product->id . '_' . $variant->id
                    : (string) $product->id;

                // ===== PRICE =====
                $originalPrice = $variant?->price ?? $product->list_price;
                $price = $originalPrice;

                if ($product->discount_percent > 0) {
                    $price = $originalPrice * (1 - $product->discount_percent / 100);
                }

                $cart[$key] = [
                    'product_id'       => $product->id,
                    'variant_id'       => $variant?->id,

                    'name'             => $product->product_name,
                    'price'            => $price,
                    'original_price'   => $originalPrice,
                    'quantity'         => $item->quantity,

                    // ===== VARIANT =====
                    'color'            => $variant?->color,
                    'size'             => $variant?->size,

                    // ===== IMAGE =====
                    'image' => $variant?->image
                        ? (Str::startsWith($variant->image, ['http://', 'https://'])
                            ? $variant->image
                            : asset('storage/uploads/products/' . $variant->image))
                        : (Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : asset('storage/uploads/products/' . $product->image)),

                    'discount_percent' => $product->discount_percent ?? 0,
                ];
            }

            session()->put('cart', $cart);
        }

        // ===== GUEST =====
        $cart = session('cart', []);

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return view('frontend.cart.index', compact('cart', 'total'));
    }

    public function updateVariant(Request $request)
    {
        $request->validate([
            'cart_key'   => 'required',
            'variant_id' => 'required|exists:shop_product_variants,id',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$request->cart_key])) {
            return response()->json(['success' => false]);
        }

        $variant = \App\Models\ProductVariant::with('product')
            ->find($request->variant_id);

        // 👉 Update SESSION
        $cart[$request->cart_key]['variant_id'] = $variant->id;
        $cart[$request->cart_key]['color'] = $variant->color;
        $cart[$request->cart_key]['size']  = $variant->size;
        $cart[$request->cart_key]['price'] = $variant->price;

        if ($variant->image) {
            $cart[$request->cart_key]['image'] = $variant->image;
        }

        session()->put('cart', $cart);

        // 👉 Update DB nếu login
        if (auth('customer')->check()) {
            \App\Models\ShopCart::where('customer_id', auth('customer')->id())
                ->where('product_id', $variant->product_id)
                ->update([
                    'variant_id' => $variant->id
                ]);
        }
        return response()->json(['success' => true]);
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
        $currentOrder = ShopOrder::firstOrCreate(
            [
                'customer_id' => $customer->id,
                'order_status' => ShopOrder::STATUS_PENDING
            ],
            [
                'order_date' => now(),
                'payment_status' => 'unpaid',
                'ship_country' => 'Việt Nam',
            ]
        );

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
        $currentOrder = null;

        if (session('vnpay_paid')) {
            $currentOrder = (object)[
                'payment_status' => 'paid'
            ];
        }
        $selectedPaymentCode = null;

        if (session('selected_payment_type_id')) {
            $paymentType = \App\Models\ShopPaymentType::find(
                session('selected_payment_type_id')
            );

            $selectedPaymentCode = $paymentType?->payment_code;
        }



        // Voucher của khách
        $vouchers = ShopVoucher::whereHas('customers', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id);
        })->get();



        return view('frontend.orders.create', compact(
            'selectedPaymentCode',
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
            'appliedVoucher',
            'currentOrder'
        ));
    }



    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $cart = \App\Models\ShopCart::where('customer_id', $customer->id)
            ->with(['product', 'variant'])
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
            'voucher_discount' => 'nullable|numeric|min:0',
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
                'voucher_discount' => $request->voucher_discount ?? 0,
            ]);
            foreach ($cart as $item) {

                $product = $item->product;
                // % giảm của sản phẩm
                $discountPercent = $product->discount_percent ?? 0;
                $variant = $item->variant;
                // Giá gốc
                $unitPrice = $variant?->price ?? $product->list_price;


                // Số tiền giảm trên 1 sản phẩm
                $discountAmount = $discountPercent > 0
                    ? $unitPrice * $discountPercent / 100
                    : 0;

                ShopOrderDetail::create([
                    'order_id'            => $order->id,
                    'product_id'          => $product->id,
                    'quantity'            => $item->quantity,
                    'variant_id' => $variant?->id,
                    // GIÁ CHUẨN
                    'unit_price'          => $unitPrice,
                    // DISCOUNT
                    'discount_percentage' => $discountPercent,
                    'discount_amount'     => $discountAmount,
                ]);
            }



            DB::commit();
            Mail::to(config('mail.admin_email'))->send(new NewOrderAdminMail($order));


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
