<!DOCTYPE html>
<html>
<head>
    <title>Đơn Hàng Đã Bị Quản Trị Viên Hủy</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h1>Đơn Hàng Của Bạn Đã Bị Quản Trị Viên Hủy</h1>
<p>Kính gửi {{ $order->user->name }},</p>

<p>Cảm ơn quý khách đã đặt hàng! Chúng tôi xin xác nhận đơn hàng {{ GenerateOrderNumber($order->id) }} của quý khách đã bị hủy bởi quản trị viên.</p>

<h2>Thông Tin Đơn Hàng Bị Quản trị viên hủy</h2>
<ul>
    <li><strong>Mã đơn hàng:</strong> {{ GenerateOrderNumber($order->id) }}</li>
    <li><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</li>
    <li><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</li>
</ul>

<p>Chân thành xin lỗi quý khách và cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi !</p>
<p>Trân trọng,<br>[HuyDepTraiCompany]</p>
</body>
</html>
