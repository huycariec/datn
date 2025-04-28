<!DOCTYPE html>
<html>
<head>
    <title>Thông Báo: Yêu Cầu Trả Hàng</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h1>Thông Báo: Yêu Cầu Trả Hàng</h1>
<p>Kính gửi Quản trị viên,</p>

<p>Khách hàng <strong>{{ $order->user->name }}</strong> vừa gửi yêu cầu trả đơn hàng <strong>{{ GenerateOrderNumber($order->id) }}</strong>.</p>

@if($reason)
    <p><strong>Lý do trả hàng:</strong> {{ $reason }}</p>
@else
    <p><strong>Lý do trả hàng:</strong> Không được cung cấp</p>
@endif

<h2>Thông Tin Đơn Hàng</h2>
<ul>
    <li><strong>Mã đơn hàng:</strong> {{ GenerateOrderNumber($order->id) }}</li>
    <li><strong>Khách hàng:</strong> {{ $order->user->name }}</li>
    <li><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</li>
    <li><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</li>
    <li><strong>Thời gian yêu cầu:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</li>
</ul>

<p>Vui lòng kiểm tra và xử lý yêu cầu trả hàng theo quy trình. Liên hệ khách hàng nếu cần thêm thông tin.</p>

<p>Trân trọng,<br>Hệ thống [HuyDepTraiCompany]</p>
</body>
</html>
