<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .page {
            page-break-after: always;
            padding: 20px;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            width: 160px;
            background: #f3f4f6;
            text-align: left;
        }

        .meta {
            margin-bottom: 10px;
        }

        .meta span {
            display: inline-block;
            margin-right: 20px;
        }

        .note {
            margin-top: 20px;
            border: 1px dashed #000;
            padding: 10px;
            min-height: 60px;
        }

        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature div {
            text-align: center;
            width: 30%;
        }
    </style>
</head>

<body>

    @foreach ($orders as $order)
        <div class="page">

            <div class="title">
                🧾 PHIẾU ĐÓNG HÀNG
            </div>

            <div class="meta">
                <span><strong>Mã đơn:</strong> {{ $order->order_code ?? $order->id }}</span>
                <span><strong>Ngày in:</strong> {{ now()->format('d/m/Y H:i') }}</span>
            </div>

            <table>
                <tr>
                    <th>Khách hàng</th>
                    <td>{{ $order->ship_name }}</td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td>{{ $order->ship_phone }}</td>
                </tr>
                <tr>
                    <th>Địa chỉ giao</th>
                    <td>{{ $order->ship_address1 }}</td>
                </tr>
                <tr>
                    <th>Thanh toán</th>
                    <td>{{ $order->payment_type->payment_name ?? 'COD' }}</td>
                </tr>
            </table>

            {{-- (NÂNG CẤP SAU) Bảng sản phẩm trong đơn --}}
            {{-- 
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>SL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td align="center">{{ $item->qty }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        --}}

            <div class="note">
                <strong>Ghi chú kho:</strong>
                <br>
                ☐ Đã kiểm hàng &nbsp;&nbsp;
                ☐ Đã đóng gói &nbsp;&nbsp;
                ☐ Đã dán mã vận đơn
            </div>

            <div class="signature">
                <div>
                    <strong>Nhân viên kho</strong><br><br>
                    (Ký, ghi rõ họ tên)
                </div>

                <div>
                    <strong>Người giao hàng</strong><br><br>
                    (Ký nhận)
                </div>
            </div>

        </div>
    @endforeach

</body>

</html>
