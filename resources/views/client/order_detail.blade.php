@extends('app')

@section('content')
    <section class="order-detail-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header p-3 text-white d-flex justify-content-between align-items-center"
                             style="background-color: var(--theme-color)">
                            <h5 class="mb-0 fw-bold">Chi tiết đơn hàng #{{ GenerateOrderNumber($order->id) }}</h5>
                            <a class="text-white" href="{{ route('order') }}">Danh sách đơn hàng <i
                                    class="bi bi-arrow-return-left"></i></a>
                        </div>
                        <div class="card-body p-4">
                            <!-- Thông tin đơn hàng -->
                            <div class="mb-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3 fw-bold"><i
                                        class="bi bi-info-circle me-2"></i>Thông tin đơn hàng</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 fw-bold">Mã đơn hàng</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="fw-bold text-dark">#{{ GenerateOrderNumber($order->id) }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 fw-bold">Thời gian đặt hàng</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="text-dark fw-bold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 fw-bold">Khách hàng</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="text-dark fw-bold">{{ $order->user ? $order->user->name : 'Khách vãng lai' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 fw-bold">Trạng thái</label>
                                            <div class="col-sm-8">
                                                {!! $order->status->getBadgeLabel() !!}
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 fw-bold">Phương thức thanh toán</label>
                                            <div class="col-sm-8">
                                                {!! $order->payment_method->getBadgeLabel() !!}
                                                @if($order->payment_method !== \App\Enums\PaymentMethod::CASH)
                                                    {!! $order->payment->status->getBadgeLabel() !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 fw-bold">Phí vận chuyển</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">{{ number_format($order->shipping_fee, 0, ',', '.') }} VNĐ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Địa chỉ giao hàng -->
                            <div class="mb-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3 fw-bold"><i
                                        class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng</h6>
                                @if($order->userAddress)
                                    <p class="text-dark">
                                        <strong>Tỉnh/TP:</strong> {{ $order->userAddress->province->name }},
                                        <strong>Quận/Huyện:</strong> {{ $order->userAddress->district->name }},
                                        <strong>Xã/Phường:</strong> {{ $order->userAddress->ward->name }}
                                    </p>
                                    <p class="text-dark"><strong>Địa chỉ chi
                                            tiết:</strong> {{ $order->userAddress->address_detail }}</p>
                                @else
                                    <p class="text-muted">Chưa có thông tin địa chỉ.</p>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3 fw-bold"><i
                                        class="bi bi-cart3 me-2"></i>Chi tiết sản phẩm</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-light">
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá</th>
                                            <th>Tổng</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->orderDetails as $detail)
                                            <tr>
                                                <td>{{ $detail->name ?? 'N/A' }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}
                                                    VNĐ
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Không có sản phẩm nào.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Thông tin giảm giá -->
                            <div class="mb-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3 fw-bold"><i
                                        class="bi bi-ticket-perforated me-2"></i>Thông tin giảm giá</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-light">
                                        <tr>
                                            <th>Mã giảm giá</th>
                                            <th>Giá trị giảm</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->discounts as $discount)
                                            <tr>
                                                <td>{{ $discount->code }}</td>
                                                <td>{{ number_format($discount->pivot->discount_value, 0, ',', '.') }}
                                                    VNĐ
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">Không áp dụng mã giảm giá</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tổng quan thanh toán -->
                            <div class="mb-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3 fw-bold"><i
                                        class="bi bi-wallet2 me-2"></i>Tổng quan thanh toán</h6>
                                <div class="row justify-content-end">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tổng tiền sản phẩm:</span>
                                            <span>{{ number_format($order->orderDetails->sum(fn($detail) => $detail->quantity * $detail->price), 0, ',', '.') }} VNĐ</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Phí vận chuyển:</span>
                                            <span>{{ number_format($order->shipping_fee, 0, ',', '.') }} VNĐ</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Giảm giá:</span>
                                            <span>- {{ number_format($order->discounts->sum('pivot.discount_value'), 0, ',', '.') }} VNĐ</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Tổng thanh toán:</span>
                                            <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hành động -->
                            <div class="text-end d-flex justify-content-end gap-3">
                                @if($order->status === \App\Enums\OrderStatus::PENDING_CONFIRMATION)
                                    <a href="#" class="btn btn-danger fw-bold"
                                       style="border-radius: 20px; padding: 10px 20px;">Hủy đơn</a>
                                @endif
                                @if($order->status === \App\Enums\OrderStatus::DELIVERED)
                                    <a href="#" class="btn btn-success fw-bold"
                                       style="border-radius: 20px; padding: 10px 20px;"
                                       onclick="confirm('Xác nhận đã nhận hàng?') && alert('Đã xác nhận! Chức năng đang phát triển.')">Xác
                                        nhận đơn hàng</a>
                                @endif
                                @if($order->status === \App\Enums\OrderStatus::RECEIVED)
                                    <a href="#" class="btn btn-warning fw-bold"
                                       style="border-radius: 20px; padding: 10px 20px;"
                                       onclick="confirm('Bạn muốn trả đơn hàng này?') && alert('Chức năng trả hàng đang phát triển.')">Trả
                                        đơn</a>
                                    <a href="#" class="btn btn-success fw-bold"
                                       style="border-radius: 20px; padding: 10px 20px;"
                                       onclick="alert('Chức năng đánh giá đang phát triển.')">Đánh giá</a>
                                @endif
                                <a href="{{ route('order') }}" class="btn btn-outline-primary fw-bold"
                                   style="border-radius: 20px; padding: 10px 20px;">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
