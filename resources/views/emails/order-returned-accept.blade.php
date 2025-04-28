<!DOCTYPE html>
<html>
<head>
    <title>
        @if($order->status == \App\Enums\OrderStatus::RETURNED_ACCEPT)
            Yêu cầu trả hàng của bạn đã được phê duyệt
        @else
            Yêu cầu trả hàng của bạn không được phê duyệt
        @endif
    </title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h1>
    @if($order->status == \App\Enums\OrderStatus::RETURNED_ACCEPT)
        Yêu cầu trả hàng của bạn đã được phê duyệt
    @else
        Yêu cầu trả hàng của bạn không được phê duyệt
    @endif
</h1>
<p>Kính gửi {{ $order->user->name }},</p>

@if($order->status == \App\Enums\OrderStatus::RETURNED_ACCEPT)
    <p>Chúng tôi xin thông báo rằng yêu cầu trả hàng cho đơn hàng #{{ GenerateOrderNumber($order->id) }} của quý khách đã được phê duyệt.</p>
@else
    <p>Chúng tôi xin thông báo rằng yêu cầu trả hàng cho đơn hàng #{{ GenerateOrderNumber($order->id) }} của quý khách không được phê duyệt.</p>
@endif

<h2>Thông tin đơn hàng</h2>
<ul>
    <li><strong>Mã đơn hàng:</strong> {{ GenerateOrderNumber($order->id) }}</li>
    <li><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</li>
    <li><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</li>
    <li><strong>Lý do trả hàng:</strong> {{ $order->return_reason ?? 'Không cung cấp lý do' }}</li>
    @if($order->status == \App\Enums\OrderStatus::RECEIVED && $order->reject_reason)
        <li><strong>Lý do từ chối:</strong> {{ $order->reject_reason }}</li>
    @endif
</ul>

@if($order->status == \App\Enums\OrderStatus::RETURNED_ACCEPT)
    <p>Chúng tôi sẽ liên hệ với quý khách để sắp xếp việc nhận lại hàng và hoàn tiền (nếu có) trong thời gian sớm nhất. Vui lòng chuẩn bị sản phẩm để trả lại theo hướng dẫn của nhân viên hỗ trợ.</p>
@else
    <p>Chúng tôi rất tiếc vì không thể đáp ứng yêu cầu trả hàng lần này. Nếu quý khách cần thêm thông tin hoặc hỗ trợ, vui lòng liên hệ với chúng tôi.</p>
@endif

<p>Nếu có bất kỳ câu hỏi nào, quý khách có thể liên hệ với chúng tôi qua email <a href="mailto:support@huydeptrai.com">support@huydeptrai.com</a> hoặc số điện thoại <a href="tel:0338475943">0338475943</a>.</p>

<p>Cảm ơn quý khách đã tin tưởng và mua sắm tại cửa hàng chúng tôi!</p>
<p>Trân trọng,<br>HuyDepTraiCompany</p>
</body>
</html>
