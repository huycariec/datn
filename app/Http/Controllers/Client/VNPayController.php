<?php

namespace App\Http\Controllers\client;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VNPayController extends Controller
{
    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode'); // Mã phản hồi của VNPAY
        $vnp_TxnRef = $request->input('vnp_TxnRef'); // Mã đơn hàng
        $order = Order::find($vnp_TxnRef);
    
        if (!$order) {
            dd('không tìm thấy đơn hàng');
        }
    
        if ($vnp_ResponseCode == "00") {
            // Cập nhật trạng thái đơn hàng thành 'paid'
            $order->update(['status' => 'paid']);
            dd('thanh toán thành công');
    
        } else {
            dd('thanh toán thất bại');
        }
    }
    
}
