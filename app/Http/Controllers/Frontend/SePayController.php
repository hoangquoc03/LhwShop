<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrder;

class SePayController extends Controller
{
    public function webhook(Request $request)
    {
        Log::info('========== SEPAY WEBHOOK ==========');

        Log::info('SEPAY HEADERS', [
            'authorization' => $request->header('Authorization'),
            'content_type'  => $request->header('Content-Type'),
        ]);

        Log::info('SEPAY BODY', $request->all());

        $transactionId = $request->input('id');

        $paymentCode = strtoupper(
            trim((string) $request->input('code'))
        );

        $transferType = strtolower(
            trim((string) $request->input('transferType'))
        );

        $transferAmount = (int) $request->input(
            'transferAmount',
            0
        );

        Log::info('SEPAY PARSED DATA', [
            'transactionId'  => $transactionId,
            'paymentCode'    => $paymentCode,
            'transferType'   => $transferType,
            'transferAmount' => $transferAmount,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kiểm tra dữ liệu bắt buộc
        |--------------------------------------------------------------------------
        |
        | Không dùng:
        | if (!$transactionId)
        |
        | Vì SePay test có id = 0.
        |
        */

        if (
            $transactionId === null ||
            $transactionId === '' ||
            $paymentCode === ''
        ) {
            Log::warning(
                'SePay missing transaction ID or payment code',
                [
                    'transaction_id' => $transactionId,
                    'payment_code'   => $paymentCode,
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Missing transaction ID or payment code',
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | Chỉ nhận tiền vào
        |--------------------------------------------------------------------------
        */

        if ($transferType !== 'in') {
            return response()->json([
                'success' => true,
                'message' => 'Transaction is not money in',
            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | Webhook TEST của SePay
        |--------------------------------------------------------------------------
        */

        if ($paymentCode === 'SEPAYTEST') {
            Log::info('SePay TEST webhook received successfully');

            return response()->json([
                'success' => true,
                'message' => 'SePay test webhook received',
            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | Tìm đơn hàng
        |--------------------------------------------------------------------------
        */

        $order = ShopOrder::where(
            'payment_code',
            $paymentCode
        )->first();

        if (!$order) {
            Log::warning('SePay order not found', [
                'payment_code' => $paymentCode,
            ]);

            /*
            | Không retry vô hạn với giao dịch không thuộc
            | đơn hàng của hệ thống.
            */

            return response()->json([
                'success' => true,
                'message' => 'Payment code does not belong to an order',
            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | Kiểm tra phương thức thanh toán
        |--------------------------------------------------------------------------
        */

        $paymentTypeCode = strtoupper(
            (string) $order->payment_type?->payment_code
        );

        if ($paymentTypeCode !== 'PM02') {

            Log::warning('SePay order is not bank transfer', [
                'order_id'         => $order->id,
                'payment_code'     => $paymentCode,
                'payment_type_code' => $paymentTypeCode,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order is not bank transfer',
            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | Đã thanh toán rồi
        |--------------------------------------------------------------------------
        */

        if ($order->isPaid()) {

            Log::info('SePay order already paid', [
                'order_id' => $order->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order already paid',
            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | Tính tổng tiền đơn hàng
        |--------------------------------------------------------------------------
        */

        $order->load('details');

        $orderTotal = (int) round($order->total);

        Log::info('SEPAY PAYMENT CHECK', [
            'order_id'        => $order->id,
            'payment_code'    => $paymentCode,
            'transfer_amount' => $transferAmount,
            'order_total'     => $orderTotal,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kiểm tra số tiền
        |--------------------------------------------------------------------------
        */

        if ($transferAmount !== $orderTotal) {

            Log::warning('SePay amount mismatch', [
                'order_id'        => $order->id,
                'payment_code'    => $paymentCode,
                'transfer_amount' => $transferAmount,
                'order_total'     => $orderTotal,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment amount does not match order total',
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | Đánh dấu đã thanh toán
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $order,
            $transactionId
        ) {

            $order->refresh();

            if ($order->isPaid()) {
                return;
            }

            $order->markAsPaid(
                (string) $transactionId
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Log thành công
        |--------------------------------------------------------------------------
        */

        Log::info('SePay payment SUCCESS', [
            'order_id'        => $order->id,
            'payment_code'    => $paymentCode,
            'amount'          => $transferAmount,
            'transaction_id'  => $transactionId,
        ]);

        return response()->json([
            'success' => true,
        ], 200);
    }


    public function paymentStatus($id)
    {
        $order = ShopOrder::where('id', $id)
            ->where(
                'customer_id',
                auth()->guard('customer')->id()
            )
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'paid' => $order->payment_status
                === ShopOrder::PAYMENT_PAID,
            'payment_status' => $order->payment_status,
            'payment_code' => $order->payment_code,
            'paid_at' => $order->paid_at,
        ]);
    }
}