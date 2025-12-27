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


    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $inputData = $request->all();

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', urldecode($hashData), $vnp_HashSecret);

        if ($secureHash !== $vnp_SecureHash) {
            abort(403, 'Sai chữ ký VNPay');
        }

        $order = ShopOrder::findOrFail($request->vnp_TxnRef);

        if ($request->vnp_ResponseCode === '00') {
            $order->status = 'paid';
            $order->save();

            return redirect()
                ->route('order.success', $order->id)
                ->with('success', 'Thanh toán VNPay thành công');
        }

        $order->status = 'failed';
        $order->save();

        return redirect()
            ->route('order.failed', $order->id)
            ->with('error', 'Thanh toán thất bại');
    }

    public function qrCode($orderId)
    {
        $order = ShopOrder::findOrFail($orderId);

        $text = "BANK: Vietcombank\nACC: 123456789\nNAME: CÔNG TY ABC\nAMOUNT: {$order->total}\nNOTE: {$order->id}";

        $qr = QrCode::size(300)->generate($text);

        return view('payment.qr', compact('qr', 'order'));
    }
}
