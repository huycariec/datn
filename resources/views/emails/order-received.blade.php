<!DOCTYPE html>
<html>
<head>
    <title>Thông Báo: Khách Hàng Xác Nhận Nhận Hàng</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h1>Thông Báo: Khách Hàng Xác Nhận Nhận Hàng</h1>
<p>Kính gửi Quản trị viên,</p>

<p>Khách hàng <strong>{{ $order->user->name }}</strong> vừa xác nhận đã nhận được đơn hàng <strong>{{ GenerateOrderNumber($order->id) }}</strong>.</p>

<h2>Thông Tin Đơn Hàng</h2>
<ul>
    <li><strong>Mã đơn hàng:</strong> {{ GenerateOrderNumber($order->id) }}</li>
    <li><strong>Khách hàng:</strong> {{ $order->user->name }}</li>
    <li><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</li>
    <li><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</li>
    <li><strong>Thời gian xác nhận:</strong> {{ now()->format('d/m/Y H:i') }}</li>
</ul>

<p>Trân trọng,<br>Hệ thống [HuyDepTraiCompany]</p>
</body>
</html>
