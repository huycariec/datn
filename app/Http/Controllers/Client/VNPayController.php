<?php

namespace App\Http\Controllers\client;

use App\Models\Order;
use App\Models\PaymentLog;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VNPayController extends Controller
{
    
    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $order = Order::find($vnp_TxnRef);
    
        if (!$order) {
            return redirect()->route('order.failed')->with('error', 'Không tìm thấy đơn hàng!');
        }
    
        // Tìm log cũ
        $paymentLog = PaymentLog::where('order_id', $order->id)->first();
    
        if (!$paymentLog) {
            return redirect()->route('order.failed')->with('error', 'Không tìm thấy log thanh toán!');
        }
    
        // Update status theo kết quả thanh toán
        $paymentLog->update([
            'response_code' => $vnp_ResponseCode,
            'status'        => $vnp_ResponseCode == "00" ? PaymentStatus::SUCCESS : PaymentStatus::FAILED,
            'message'       => $vnp_ResponseCode == "00" ? 'Thanh toán thành công' : 'Thanh toán thất bại',
        ]);
    
        if ($vnp_ResponseCode == "00") {
            dd('thanh toán thành công');
            return redirect()->route('order.success')->with('success', 'Thanh toán thành công!');
        } else {
            return redirect()->route('order.failed')->with('error', 'Thanh toán thất bại, vui lòng thử lại!');
        }
    }
        
}
