<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif">

    <h2>🧾 ĐƠN HÀNG MỚI</h2>

    <p><strong>Mã đơn:</strong> {{ $order->order_code ?? $order->id }}</p>
    <p><strong>Khách hàng:</strong> {{ $order->ship_name }}</p>
    <p><strong>SĐT:</strong> {{ $order->ship_phone }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->ship_address1 }}</p>
    <p><strong>Thanh toán:</strong> {{ $order->payment_type->payment_name ?? 'COD' }}</p>
    <p><strong>Trạng thái:</strong> ⏳ Chờ xử lý</p>

    <hr>

    <h4>📦 Sản phẩm:</h4>
    <ul>
        @foreach ($order->details as $item)
            <li>
                {{ $item->product->product_name ?? '' }}
                × {{ $item->quantity }}
            </li>
        @endforeach
    </ul>

    <hr>

    <p>
        👉 Vui lòng vào admin để tiến hành <strong>đóng hàng & giao hàng</strong>.
    </p>

    <p>
        <a href="{{ route('backend.ShopOrder.index', ['status' => 'Pending']) }}">
            👉 Xem danh sách đơn chờ xử lý
        </a>
    </p>

</body>

</html>
