@extends('app')

@section('content')
    <section class="order-section py-5" style="background: #f5f5f5; min-height: 100vh;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-uppercase"
                    style="color: #ee4d2d; font-size: 2.5rem; letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    Danh sách đơn hàng</h2>
                <p class="text-muted">Theo dõi trạng thái mua sắm của bạn</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @forelse($orders as $order)
                        <div class="card mb-4 shadow-sm border-0"
                             style="border-radius: 10px; overflow: hidden; background: #fff;">
                            <!-- Header đơn hàng -->
                            <div class="card-header p-3 d-flex justify-content-between align-items-center"
                                 style="background: #fff; border-bottom: 1px solid #eee;">
                                <div>
                                    <span class="fw-bold text-muted">Đơn hàng</span>
                                    <span class="text-danger fw-bold">#{{ GenerateOrderNumber($order->id) }}</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box2" viewBox="0 0 16 16">
                                        <path d="M2.95.4a1 1 0 0 1 .8-.4h8.5a1 1 0 0 1 .8.4l2.85 3.8a.5.5 0 0 1 .1.3V15a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4.5a.5.5 0 0 1 .1-.3zM7.5 1H3.75L1.5 4h6zm1 0v3h6l-2.25-3zM15 5H1v10h14z"/>
                                    </svg>: {!! $order->status->getBadgeLabel() !!} -
                                    @if($order->payment->method == \App\Enums\PaymentMethod::VNPAY)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                            <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                                        </svg>:
                                        {!! $order->payment->status->getBadgeLabel() !!}
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                        </svg>:
                                        <span class="badge bg-primary">Thanh toán khi nhận hàng</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Body đơn hàng -->
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <!-- Ảnh sản phẩm -->
                                    <div class="col-md-2 col-3">
                                        @php
                                            $imageDemo = \App\Models\Images::where('product_id', $order->orderDetails->first()->product->id)->first()->url;
                                        @endphp
                                        @if($order->orderDetails->isNotEmpty() && $order->orderDetails->first()->product && $order->orderDetails->first() && $imageDemo)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($imageDemo) }}"
                                                 alt="Product" class="img-fluid rounded"
                                                 style="max-width: 80px; border: 1px solid #ddd;">
                                        @else
                                            <img src="/assets/images/placeholder.png" alt="No Image"
                                                 class="img-fluid rounded"
                                                 style="max-width: 80px; border: 1px solid #ddd;">
                                        @endif
                                    </div>

                                    <!-- Thông tin đơn hàng -->
                                    <div class="col-md-7 col-9">
                                        <div class="mb-2">
                                            @if($order->orderDetails->isNotEmpty())
                                                @php
                                                    $productNames = $order->orderDetails->take(2)->pluck('product.name')->implode(', ');
                                                    $remainingCount = $order->orderDetails->count() - 2;
                                                @endphp
                                                <span class="fw-bold text-dark">{{ $productNames }}</span>
                                                @if($remainingCount > 0)
                                                    <span class="text-muted"> + {{ $remainingCount }} sản phẩm khác</span>
                                                @endif
                                            @else
                                                <span class="fw-bold text-dark">Sản phẩm không xác định</span>
                                            @endif
                                            <span class="text-muted"> x {{ $order->orderDetails->sum('quantity') }}</span>
                                        </div>
                                        <p class="mb-1 text-muted"><i
                                                class="bi bi-calendar3 me-2"></i>{{ $order->created_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="mb-0 text-muted"><i
                                                class="bi bi-credit-card me-2"></i>{!! $order->payment->method->getBadgeLabel() !!}
                                        </p>
                                    </div>

                                    <!-- Tổng tiền và hành động -->
                                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                        <p class="mb-2"><span class="text-muted">Tổng tiền:</span> <span
                                                class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span>
                                        </p>
                                        <div class="d-flex gap-2 justify-content-md-end">
                                            @if($order->payment->method == \App\Enums\PaymentMethod::VNPAY &&
                                                in_array($order->payment->status, [\App\Enums\PaymentStatus::PENDING, \App\Enums\PaymentStatus::FAILED]))
                                                <form action="{{ route('vnpay.generate') }}" method="POST"
                                                      style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="total_price"
                                                           value="{{ $order->total_amount }}">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm fw-bold"
                                                            style="border-radius: 20px; padding: 6px 15px;">
                                                        Tiếp tục thanh toán
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('order.detail', $order->id) }}"
                                               class="btn btn-outline-primary btn-sm fw-bold"
                                               style="border-radius: 20px; padding: 6px 15px;">Chi tiết đơn hàng</a>

                                            @if(in_array($order->status, [\App\Enums\OrderStatus::PENDING_CONFIRMATION, \App\Enums\OrderStatus::CONFIRMED, \App\Enums\OrderStatus::PREPARING, \App\Enums\OrderStatus::PREPARED]))
                                                <button type="button"
                                                        class="btn btn-outline-danger btn-sm fw-bold cancel-order-btn"
                                                        style="border-radius: 20px; padding: 6px 15px;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#cancelOrderModal"
                                                        data-order-id="{{ $order->id }}">
                                                    Hủy đơn hàng
                                                </button>
                                            @endif

                                            @if(in_array($order->status, [\App\Enums\OrderStatus::RECEIVED]))
                                                @php
                                                    $canReturn = \Carbon\Carbon::now()->diffInDays($order->updated_at) <= 7;
                                                @endphp
                                                @if($canReturn)
                                                    <button type="button"
                                                            class="btn btn-outline-danger btn-sm fw-bold return-order-btn"
                                                            style="border-radius: 20px; padding: 6px 15px;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#returnOrderModal"
                                                            data-order-id="{{ $order->id }}">
                                                        Trả hàng
                                                    </button>
                                                @else
                                                    <span
                                                        class="badge bg-secondary">Đã quá 7 ngày, không thể trả hàng</span>
                                                @endif
                                            @endif

                                            @if($order->status === \App\Enums\OrderStatus::DELIVERED)
                                                <form action="{{ route('update-status') }}" method="POST"
                                                      style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="status"
                                                           value="{{ \App\Enums\OrderStatus::RECEIVED }}">
                                                    <button type="submit"
                                                            class="btn btn-outline-success btn-sm fw-bold"
                                                            style="border-radius: 20px; padding: 6px 15px;"
                                                            onclick="return confirm('Bạn có chắc đã nhận được hàng?')">
                                                        Xác nhận đã nhận được hàng
                                                    </button>
                                                </form>

{{--                                                <form action="{{ route('update-status') }}" method="POST"--}}
{{--                                                      style="display: inline;">--}}
{{--                                                    @csrf--}}
{{--                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">--}}
{{--                                                    <input type="hidden" name="status"--}}
{{--                                                           value="{{ \App\Enums\OrderStatus::NOT_RECEIVED }}">--}}
{{--                                                    <button type="submit"--}}
{{--                                                            class="btn btn-outline-danger btn-sm fw-bold"--}}
{{--                                                            style="border-radius: 20px; padding: 6px 15px;"--}}
{{--                                                            onclick="return confirm('Bạn có chắc chưa nhận được hàng?')">--}}
{{--                                                        Không nhận được hàng--}}
{{--                                                    </button>--}}
{{--                                                </form>--}}
                                            @endif
                                        </div>
                                        @if($order->status === \App\Enums\OrderStatus::NOT_RECEIVED)
                                            <p class="text-danger">Chờ quản trị viên liên hệ cho bạn hoặc
                                                <a href="tel:0338475943"> liên hệ quản trị viên</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <img src="/assets/images/empty-order.png" alt="No Orders" class="mb-4"
                                 style="width: 250px; opacity: 0.9; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));">
                            <h5 class="fw-bold text-muted">Bạn chưa có đơn hàng nào!</h5>
                            <a href="#" class="btn btn-primary mt-3 fw-bold"
                               style="border-radius: 25px; padding: 10px 30px; background: #ee4d2d; border: none; box-shadow: 0 4px 10px rgba(238,77,45,0.3);">Mua
                                sắm ngay</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Modal Lý do trả hàng -->
        <div class="modal fade" id="returnOrderModal" tabindex="-1" aria-labelledby="returnOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnOrderModalLabel">Lý do trả hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="returnOrderForm" action="{{ route('update-status') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" id="returnOrderId">
                            <input type="hidden" name="status" value="{{ \App\Enums\OrderStatus::RETURNED }}">
                            <div class="mb-3">
                                <label for="returnReason" class="form-label">Vui lòng nhập lý do trả hàng:</label>
                                <textarea class="form-control" id="returnReason" name="reason" rows="4" required></textarea>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-danger" id="submitReturnBtn">Gửi yêu cầu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Hủy đơn hàng -->
        <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelOrderModalLabel">Hủy đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('update-status') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="order_id" id="cancelOrderId">
                            <input type="hidden" name="status" value="{{ \App\Enums\OrderStatus::PENDING_CANCELLATION }}">
                            <div class="mb-3">
                                <label for="cancelReason" class="form-label">Lý do hủy đơn hàng</label>
                                <textarea class="form-control" id="cancelReason" name="reason" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Xác nhận hủy đơn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Hiệu ứng hover cho card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseover', () => {
                card.style.boxShadow = '0 8px 20px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseout', () => {
                card.style.boxShadow = '0 4px 10px rgba(0,0,0,0.05)';
            });
        });

        // Xử lý modal trả hàng
        document.querySelectorAll('.return-order-btn').forEach(button => {
            button.addEventListener('click', () => {
                const orderId = button.getAttribute('data-order-id');
                document.getElementById('returnOrderId').value = orderId;
            });
        });

        // Xử lý submit form trả hàng qua AJAX (giữ nguyên jQuery AJAX)
        document.getElementById('returnOrderForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const submitButton = document.getElementById('submitReturnBtn');
            submitButton.disabled = true;
            submitButton.textContent = 'Đang gửi...';

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                complete: function () {
                    alert('Gửi yêu cầu hoàn hàng thành công !')
                    submitButton.disabled = false;
                    submitButton.textContent = 'Gửi yêu cầu';
                    document.getElementById('returnOrderModal').querySelector('.btn-close').click();
                    location.reload();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý nút hủy đơn hàng
            document.querySelectorAll('.cancel-order-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    document.getElementById('cancelOrderId').value = orderId;
                });
            });
        });
    </script>
@endsection
