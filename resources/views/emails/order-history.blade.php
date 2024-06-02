<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff; /* Đặt màu nền trắng */
            margin: 0;
            padding: 0;
            font-size: 16px;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .header {
            text-align: center;

        }

        .logo {
            max-width: 100px; /* Điều chỉnh kích thước logo */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #f2f2f2;
        }
        p
        {
            font-size: 18px;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img style="width: 170px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOGWNWqXS0KChEzUKPDyuBTRaJGiJ4L33f8A&s" alt="Logo">
    </div>
    <h1>Thông tin đơn hàng</h1>
    <div style="width: 100%; display: flex; justify-content: space-between;">
        <div style="flex-grow: 1;width: 60%">
            <p><strong>Mã đơn hàng:</strong> {{ $order->OrderID }}</p>
            <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Khách hàng:</strong> {{ $order->customer->CustomerName }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->customer->CustomerPhone }}</p>
        </div>
        <div style="flex-grow: 1;">
            <p><strong>Trạng thái đơn hàng:</strong> {{ $order->orderStatus->OrderStatusName }}</p>
            <p><strong>Ghi chú:</strong> {{ $order->note_address}}</p>
        </div>
    </div>

    <h2>Sản phẩm trong đơn hàng</h2>
    <table>
        <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderDetail as $detail)
            <tr>
                <td>{{ $detail->productVariant->VARRIANNAME }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>

            </tr>
        @endforeach
        </tbody>

    </table>
</div>
<div class="footer">
   2024 CLICK BUY.
</div>
</body>
</html>
