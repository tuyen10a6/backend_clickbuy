
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
            text-align: left;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            color: #555555;
            line-height: 1.5;
        }
        .footer {
            padding: 20px;
            text-align: center;
            color: #888888;
        }
        .btn {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Đặt hàng thành công!</h1>
    </div>
    <div class="content">
        <p>Cảm ơn bạn đã mua hàng tại CLICKBUY. Đơn hàng của bạn đã được xử lý thành công.</p>
        <p><strong>Mã đơn hàng:</strong> {{ $order['OrderID'] }}</p>
        <p><strong>Ngày đặt hàng:</strong> {{ $order['OrderDate'] }}</p>
        <a href="{{ url('/') }}" class="btn">Quay lại trang chủ</a>
    </div>
    <div class="footer">
        <p>&copy; 2024 CLICKBUY. Tuyển chelsea.</p>
    </div>
</div>
</body>
</html>
