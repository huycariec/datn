<!DOCTYPE html>
<html>
<head>
    <title>Xác Nhận Đơn Hàng</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h1>Xác Nhận Đơn Hàng</h1>
<p>Kính gửi {{ $order->user->name }},</p>

<p>Cảm ơn quý khách đã đặt hàng! Chúng tôi xin xác nhận đơn hàng {{ GenerateOrderNumber($order->id) }} của quý khách đã được xác nhận.</p>

<h2>Thông Tin Đơn Hàng</h2>
<ul>
    <li><strong>Mã đơn hàng:</strong> {{ GenerateOrderNumber($order->id) }}</li>
    <li><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</li>
    <li><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</li>
</ul>

<p>Chúng tôi sẽ thông báo khi đơn hàng của quý khách được giao đi.</p>

<p>Cảm ơn quý khách đã tin tưởng và mua sắm tại cửa hàng chúng tôi!</p>
<p>Trân trọng,<br>[HuyDepTraiCompany]</p>
</body>
</html>
