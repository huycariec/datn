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
                                            @if($order->status === \App\Enums\OrderStatus::NOT_RECEIVED)
                                                <p class="text-danger">Chờ quản trị viên liên hệ cho bạn hoặc
                                                    <a href="tel:0338475943"> liên hệ quản trị viên</a></p>
                                            @endif
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
                                            @if(in_array($order->status, [
                                                \App\Enums\OrderStatus::RECEIVED,
                                                \App\Enums\OrderStatus::RETURNED
                                            ]))
                                                <th>Đánh giá</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->orderDetails as $detail)
                                            <tr>
                                                <td>
                                                    {{ $detail->product->name ?? 'N/A' }}
                                                    @if($detail->product_variant_id)
                                                        @php
                                                            $variant = \App\Models\ProductVariant::find($detail->product_variant_id);
                                                        @endphp
                                                        @if($variant)
                                                            <br><small class="text-muted">({{ $variant->sku }})</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ number_format($detail->unit_price, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ number_format($detail->quantity * $detail->unit_price, 0, ',', '.') }}
                                                    VNĐ
                                                </td>
                                                @if(in_array($order->status, [
                                                    \App\Enums\OrderStatus::RECEIVED,
                                                    \App\Enums\OrderStatus::RETURNED
                                                ]))
                                                    @php
                                                        $hasReviewed = $detail->product->reviews()
                                                            ->where('user_id', auth()->id())
                                                            ->where('product_variant_id', $detail->product_variant_id ?? 0)
                                                            ->exists();
                                                    @endphp
                                                    <td>
                                                        @if($hasReviewed)
                                                            <span class="badge bg-success">Đã đánh giá</span>
                                                        @else
                                                            <button class="btn btn-outline-warning btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#reviewModal"
                                                                    data-product-id="{{ $detail->product->id }}"
                                                                    data-variant-id="{{ $detail->product_variant_id != null || $detail->product_variant_id != 0 ? $detail->product_variant_id : 0 }}"
                                                                    data-order-id="{{ $order->id }}">
                                                                Đánh giá sản phẩm
                                                            </button>
                                                    </td>
                                                @endif
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Không có sản phẩm nào.</td>
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
                                            <span>{{ number_format($order->orderDetails->sum(fn($detail) => $detail->quantity * $detail->unit_price), 0, ',', '.') }} VNĐ</span>
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
                                @endif
                                @if($order->payment->method == \App\Enums\PaymentMethod::VNPAY &&
                                            in_array($order->payment->status, [\App\Enums\PaymentStatus::PENDING, \App\Enums\PaymentStatus::FAILED]))
                                    <form action="{{ route('vnpay.generate') }}" method="POST"
                                          style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <input type="hidden" name="total_price"
                                               value="{{ $order->total_amount }}">
                                        <button style="border-radius: 20px; padding: 10px 20px;" type="submit" class="btn btn-outline-primary btn-sm fw-bold">
                                            Tiếp tục thanh toán
                                        </button>
                                    </form>
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
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('review.store') }}" method="POST" enctype="multipart/form-data" id="reviewForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="product_id">
                        <input type="hidden" name="product_variant_id" id="product_variant_id">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Điểm đánh giá (1-5) <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" name="rating" id="rating" required>
                                <option value="">Chọn số sao</option>
                                <option value="1">1 sao</option>
                                <option value="2">2 sao</option>
                                <option value="3">3 sao</option>
                                <option value="4">4 sao</option>
                                <option value="5">5 sao</option>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn số sao đánh giá.</div>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung đánh giá <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="content" id="content" rows="3" required></textarea>
                            <div class="invalid-feedback">Vui lòng nhập nội dung đánh giá.</div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                            <div class="invalid-feedback">Vui lòng chọn một hình ảnh.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Điền dữ liệu vào modal
            var reviewModal = document.getElementById('reviewModal');
            reviewModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var productId = button.getAttribute('data-product-id');
                var variantId = button.getAttribute('data-variant-id');
                var orderId = button.getAttribute('data-order-id');

                var modal = this;
                modal.querySelector('#product_id').value = productId;
                modal.querySelector('#product_variant_id').value = variantId;
                modal.querySelector('#order_id').value = orderId;
            });

            // Validate form
            var form = document.getElementById('reviewForm');
            form.addEventListener('submit', function (event) {
                var rating = document.getElementById('rating').value;
                var content = document.getElementById('content').value.trim();
                var image = document.getElementById('image').files.length;

                // Reset trạng thái invalid
                form.querySelectorAll('.form-control, .form-select').forEach(function (element) {
                    element.classList.remove('is-invalid');
                });

                var isValid = true;

                // Kiểm tra rating
                if (!rating) {
                    document.getElementById('rating').classList.add('is-invalid');
                    isValid = false;
                }

                // Kiểm tra content
                if (!content) {
                    document.getElementById('content').classList.add('is-invalid');
                    isValid = false;
                }

                // Kiểm tra image
                if (image === 0) {
                    document.getElementById('image').classList.add('is-invalid');
                    isValid = false;
                }

                // Nếu không hợp lệ, ngăn submit
                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            });
        });
    </script>
@endsection
