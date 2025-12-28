<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:shop_orders,id',
            'payment_type' => 'required|in:vnpay'
        ]);

        $order = ShopOrder::findOrFail($request->order_id);

        // Lưu trạng thái chờ thanh toán
        $order->status = 'pending';
        $order->save();

        if ($request->payment_type === 'vnpay') {

            $vnp_TmnCode    = config('services.vnpay.tmn_code');
            $vnp_HashSecret = config('services.vnpay.hash_secret');
            $vnp_Url        = config('services.vnpay.url');
            $vnp_Returnurl  = config('services.vnpay.return_url');

            $inputData = [
                "vnp_Version"   => "2.1.0",
                "vnp_Command"   => "pay",
                "vnp_TmnCode"   => $vnp_TmnCode,
                "vnp_Amount"    => $order->total * 100,
                "vnp_CurrCode"  => "VND",
                "vnp_TxnRef"    => $order->id,
                "vnp_OrderInfo" => "Thanh toán đơn hàng #{$order->id}",
                "vnp_OrderType" => "other",
                "vnp_Locale"    => "vn",
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_IpAddr"    => request()->ip(),
                "vnp_CreateDate" => date('YmdHis'),
            ];

            ksort($inputData);

            $query = http_build_query($inputData);
            $secureHash = hash_hmac('sha512', urldecode($query), $vnp_HashSecret);

            return redirect($vnp_Url . '?' . $query . '&vnp_SecureHash=' . $secureHash);
        }

        return back()->with('error', 'Phương thức thanh toán chưa hỗ trợ');
    }


    public function return(Request $request)
    {
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $inputData = $request->all();

        $secureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = http_build_query($inputData);
        $checkHash = hash_hmac('sha512', urldecode($hashData), $vnp_HashSecret);

        if ($checkHash !== $secureHash) {
            abort(403, 'Sai chữ ký VNPay');
        }

        if ($request->vnp_ResponseCode === '00') {
            session()->put('vnpay_paid', true);
            $order = ShopOrder::where('vnp_txn_ref', $request->vnp_TxnRef)->first();

            if ($order) {
                $order->update([
                    'payment_status' => ShopOrder::PAYMENT_PAID,
                    'paid_date' => now(),
                    'order_status' => ShopOrder::STATUS_PENDING,
                ]);
            }

            return redirect()
                ->route('orders.create')
                ->with('toast_success', 'Thanh toán VNPay thành công 🎉');
        }


        return redirect()
            ->route('orders.create')
            ->with('toast_error', 'Thanh toán thất bại');
    }


    public function qr(Request $request)
    {
        $subtotal = (int) $request->subtotal;
        $voucherDiscount = (int) ($request->voucher_discount ?? 0);
        $deliveryType = $request->delivery_type;

        // 🚚 Chỉ cộng ship khi giao hàng tận nơi
        $shippingFee = ($deliveryType === 'home') ? 30000 : 0;

        $grandTotal = max(
            $subtotal - $voucherDiscount + $shippingFee,
            0
        );

        $vnp_TmnCode    = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url        = config('services.vnpay.url');
        $vnp_Returnurl  = route('vnpay.return');

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $grandTotal * 100,
            "vnp_CurrCode" => "VND",
            "vnp_TxnRef" => time(),
            "vnp_OrderInfo" => "Thanh toán đơn hàng",
            "vnp_OrderType" => "other",
            "vnp_Locale" => "vn",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_IpAddr" => $request->ip(),
            "vnp_CreateDate" => now()->format('YmdHis'),
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $hash = hash_hmac('sha512', urldecode($query), $vnp_HashSecret);

        return response()->json([
            'qr' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($vnp_Url . '?' . $query . '&vnp_SecureHash=' . $hash),
            'amount' => number_format($grandTotal, 0, ',', '.') . '₫',
            'shipping_fee' => number_format($shippingFee, 0, ',', '.') . '₫'
        ]);
    }
}
