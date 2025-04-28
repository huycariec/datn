@extends("admin.app")

@section("content")
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-warning p-2 text-white rounded-2 d-flex justify-content-between">
                            <h5 class="mb-0">Chi tiết đơn hàng #{{ GenerateOrderNumber($order->id) }}</h5>
                            @if($order->status->value !== \App\Enums\OrderStatus::CANCELLED->value)
                                <button onclick="window.print()" class="btn btn-secondary">In hóa đơn</button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-info-circle"></i> Thông tin đơn hàng</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Mã đơn hàng</label>
                                            <div class="col-sm-8">
                                                <span class="fw-bold text-dark">{{ GenerateOrderNumber($order->id) }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Thời gian đặt hàng</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">Ngày: {{ $order->created_at->format('d/m/Y') . ' lúc ' . $order->created_at->format('H:i') . ' phút'}}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Khách hàng</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">{{ $order->user ? $order->user->name : 'Khách vãng lai' }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Email</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">{{ $order->user ? $order->user->email : 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Số điện thoại</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">{{ $order->user && $order->user->profile ? $order->user->profile->phone : 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Trạng thái</label>
                                            <div class="col-sm-8 d-flex align-items-center gap-2">
                                                {!! $order->status->getBadgeLabel() !!}
                                                @if(!in_array($order->status->value, [\App\Enums\OrderStatus::REFUNDED->value, \App\Enums\OrderStatus::CANCELLED->value, \App\Enums\OrderStatus::RETURNED_ACCEPT->value, \App\Enums\OrderStatus::RECEIVED->value, \App\Enums\OrderStatus::DELIVERED->value, \App\Enums\OrderStatus::NOT_RECEIVED->value]))
                                                    <a href="#" class="edit-order" data-id="{{ $order->id }}"
                                                       data-status="{{ $order->status }}"
                                                       data-return-reason="{{ $order->reason ?? '' }}"
                                                       data-bs-toggle="modal" data-bs-target="#{{ $order->status == \App\Enums\OrderStatus::RETURNED->value ? "approveReturnModal" : ($order->status == \App\Enums\OrderStatus::PENDING_CANCELLATION->value ? "approveCancelModal" : "editOrderModal") }}">
                                                        <i class="ri-pencil-line fs-5"></i>
                                                    </a>
                                                @endif
                                                @if($order->status->value == \App\Enums\OrderStatus::NOT_RECEIVED->value)
                                                    <a class="text-decoration-underline text-danger" href="tel:{{ $order->user->profile->phone }}">
                                                        <i class="ri-phone-line"></i> Liên hệ người mua
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Phương thức thanh toán</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">{!! $order->payment_method->getBadgeLabel() !!}</span>
                                                @if($order->payment_method !== 'cash')
                                                    <span class="fw-bold">{!! $order->payment->status->getBadgeLabel() !!}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Phí vận chuyển</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">{{ number_format($order->shipping_fee, 0, ',', '.') }} VND</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Giới tính</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark fw-bold">
                                                    {{ $order->user && $order->user->profile ? ($order->user->profile->gender == 1 ? 'Nam' : ($order->user->profile->gender == 0 ? 'Nữ' : 'Khác')) : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-map-marker"></i> Địa chỉ giao hàng</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <span class="text-dark">
                                                Tỉnh/TP:
                                                <span class="fw-bold">
                                                    {{ $order->province_id ? \App\Models\Province::find($order->province_id)?->name : 'Chưa có thông tin' }}
                                                </span>,
                                                Quận/Huyện:
                                                <span class="fw-bold">
                                                    {{ $order->district_id ? \App\Models\District::find($order->district_id)?->name : '' }}
                                                </span>,
                                                Xã/Phường:
                                                <span class="fw-bold">
                                                    {{ $order->ward_id ? \App\Models\Ward::find($order->ward_id)?->name : '' }}
                                                </span>
                                            </span>

                                        </div>
                                        <div class="mb-3">
                                            Địa chỉ chi tiết: <span class="text-dark fw-bold">{{ $order->address_detail ?? "" }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-shopping-cart"></i> Chi tiết sản phẩm</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-light">
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Biến thể</th>
                                            <th>Số lượng</th>
                                            <th>Giá</th>
                                            <th>Tổng</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($order->orderDetails as $detail)
                                            <tr>
                                                <td>{{ $detail->product->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if($detail->product_variant_id)
                                                        @php
                                                            $variant = \App\Models\ProductVariant::find($detail->product_variant_id);
                                                        @endphp
                                                        @if($variant)
                                                            <p class="text-muted">({{ $variant->sku }})</p>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ number_format($detail->unit_price, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ number_format($detail->quantity * $detail->unit_price, 0, ',', '.') }} VNĐ</td>
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

                            <div class="mb-4">
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-ticket"></i> Thông tin giảm giá</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-light">
                                        <tr>
                                            <th>Mã giảm giá</th>
                                            <th>Giá trị giảm của mã</th>
                                            <th>Giá trị giảm cho đơn hàng</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($order->discounts as $discount)
                                            <tr>
                                                <td>{{ $discount->code }}</td>
                                                <td>{{ number_format($discount->value) }} {{ $discount->type == 'fixed' ? ' vnd' : ' %'}}</td>
                                                <td>{{ number_format($discount->pivot->discount_value) }} vnd</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Không áp dụng mã giảm giá</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-ticket"></i> Thông tin giao dịch</h6>
                                @if ($order->payment)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="bg-light">
                                            <tr>
                                                <th>Số tiền</th>
                                                <th>Phương thức</th>
                                                <th>Trạng thái</th>
                                                <th>Thời gian tạo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{ number_format($order->payment->amount, 0, ',', '.') }} VND</td>
                                                <td>{!! $order->payment->method->getBadgeLabel() !!}</td>
                                                <td>{!! $order->payment->status->getBadgeLabel() !!}</td>
                                                <td>{{ $order->payment->created_at ? $order->payment->created_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center text-muted">
                                        Không có thông tin giao dịch
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-money"></i> Tổng quan thanh toán</h6>
                                <div class="row justify-content-end">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tổng tiền sản phẩm:</span>
                                            <span>{{ number_format($order->orderDetails->sum(fn($detail) => $detail->quantity * $detail->unit_price), 0, ',', '.') }} VND</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Phí vận chuyển:</span>
                                            <span>{{ number_format($order->shipping_fee, 0, ',', '.') }} VND</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Giảm giá:</span>
                                            <span>- {{ number_format($order->discounts->sum('discount_value'), 0, ',', '.') }} VND</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between font-weight-bold">
                                            <span>Tổng thanh toán:</span>
                                            <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập nhật trạng thái -->
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderModalLabel">Cập nhật trạng thái đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateOrderForm">
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-select"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" id="updateBtn" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Phê duyệt trả hàng -->
    <div class="modal fade" id="approveReturnModal" tabindex="-1" aria-labelledby="approveReturnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveReturnModalLabel">Phê duyệt yêu cầu trả hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="approveOrderId">
                    <div class="mb-3">
                        <label class="form-label">Lý do trả hàng:</label>
                        <p id="returnReason" class="text-muted"></p>
                    </div>
                    <p>Bạn có muốn phê duyệt yêu cầu trả hàng này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="rejectReturnBtn" class="btn btn-danger">Không phê duyệt</button>
                    <button type="button" id="approveReturnBtn" class="btn btn-success">Phê duyệt</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Phê duyệt hủy đơn -->
    <div class="modal fade" id="approveCancelModal" tabindex="-1" aria-labelledby="approveCancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveCancelModalLabel">Phê duyệt yêu cầu hủy đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="approveCancelOrderId">
                    <div class="mb-3">
                        <label class="form-label">Lý do hủy đơn:</label>
                        <p id="cancelReason" class="text-muted"></p>
                    </div>
                    <p>Bạn có muốn phê duyệt yêu cầu hủy đơn này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="rejectCancelBtn" class="btn btn-danger">Không phê duyệt</button>
                    <button type="button" id="approveCancelBtn" class="btn btn-success">Phê duyệt</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusTransitions = {
                'pending_confirmation': ['pending_confirmation', 'confirmed', 'cancelled'],
                'confirmed': ['confirmed', 'preparing', 'cancelled'],
                'preparing': ['preparing', 'prepared', 'cancelled'],
                'prepared': ['prepared', 'picked_up'],
                'picked_up': ['picked_up', 'in_transit'],
                'in_transit': ['in_transit', 'delivered'],
                'delivered': ['delivered'],
                'received': ['received'],
                'returned': ['returned', 'returned_accept', 'received'],
                'returned_accept': ['returned_accept', 'refunded'],
                'cancelled': [],
                'refunded': [],
                'pending_cancellation': ['pending_cancellation', 'cancelled', 'confirmed']
            };

            const allStatuses = @json(\App\Enums\OrderStatus::toArray());

            document.querySelectorAll('.edit-order').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const orderId = this.getAttribute('data-id');
                    const currentStatus = this.getAttribute('data-status');
                    const returnReason = this.getAttribute('data-return-reason');

                    if (currentStatus === 'returned') {
                        // Hiển thị modal phê duyệt trả hàng
                        document.getElementById('approveOrderId').value = orderId;
                        document.getElementById('returnReason').textContent = returnReason || 'Không có lý do được cung cấp';
                        const approveModal = new bootstrap.Modal(document.getElementById('approveReturnModal'));
                        approveModal.show();
                    } else if (currentStatus === 'pending_cancellation') {
                        // Hiển thị modal phê duyệt hủy đơn
                        document.getElementById('approveCancelOrderId').value = orderId;
                        document.getElementById('cancelReason').textContent = returnReason || 'Không có lý do được cung cấp';
                        const approveModal = new bootstrap.Modal(document.getElementById('approveCancelModal'));
                        approveModal.show();
                    } else {
                        // Hiển thị modal cập nhật trạng thái thông thường
                        document.getElementById('order_id').value = orderId;
                        const statusSelect = document.getElementById('status');
                        statusSelect.innerHTML = '';
                        const allowedStatuses = statusTransitions[currentStatus] || [];
                        allStatuses.forEach(status => {
                            if (allowedStatuses.includes(status.value)) {
                                const option = document.createElement('option');
                                option.value = status.value;
                                option.textContent = status.label;
                                statusSelect.appendChild(option);
                            }
                        });
                        const editModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
                        editModal.show();
                    }
                });
            });

            // Xử lý cập nhật trạng thái thông thường
            document.getElementById('updateBtn').addEventListener('click', function () {
                const orderId = document.getElementById('order_id').value;
                const status = document.getElementById('status').value;

                $.ajax({
                    url: '{{ route("orders.update", "__ID__") }}'.replace('__ID__', orderId),
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('Đã có lỗi xảy ra khi cập nhật trạng thái.');
                    }
                });
            });

            // Xử lý phê duyệt trả hàng
            document.getElementById('approveReturnBtn').addEventListener('click', function () {
                const orderId = document.getElementById('approveOrderId').value;
                updateOrderStatus(orderId, 'returned_accept', 'Phê duyệt trả hàng thành công!');
            });

            // Xử lý không phê duyệt trả hàng
            document.getElementById('rejectReturnBtn').addEventListener('click', function () {
                const orderId = document.getElementById('approveOrderId').value;
                updateOrderStatus(orderId, 'received', 'Đã từ chối yêu cầu trả hàng.');
            });

            let isSubmit = false;
            document.getElementById('approveCancelBtn').addEventListener('click', function () {
                if (isSubmit) return;
                isSubmit = true;

                const orderId = document.getElementById('approveCancelOrderId').value;
                updateOrderStatus(orderId, 'cancelled', 'Phê duyệt hủy đơn thành công!');
            });

            // Xử lý không phê duyệt hủy đơn
            document.getElementById('rejectCancelBtn').addEventListener('click', function () {
                if (isSubmit) return;
                isSubmit = true;

                const orderId = document.getElementById('approveCancelOrderId').value;
                updateOrderStatus(orderId, 'confirmed', 'Đã từ chối yêu cầu hủy đơn.');
            });

            function updateOrderStatus(orderId, status, successMessage) {
                $.ajax({
                    url: '{{ route("orders.update", "__ID__") }}'.replace('__ID__', orderId),
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(successMessage);
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('Đã có lỗi xảy ra khi cập nhật trạng thái.');
                    },
                    complete: function () {
                        isSubmit = false;
                        const approveModal = bootstrap.Modal.getInstance(document.getElementById('approveReturnModal'));
                        approveModal.hide();
                    }
                });
            }
        });
    </script>
@endsection
