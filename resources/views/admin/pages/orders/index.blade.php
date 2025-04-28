@extends("admin.app")

@section("content")
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>Danh sách đơn hàng</h5>
                            </div>

                            <form method="GET" action="{{ route('orders.index') }}" class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <input type="text" name="name" placeholder="Khách hàng ..." value="{{ request('name') }}"
                                           class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">Tất cả trạng thái</option>
                                        @foreach (\App\Enums\OrderStatus::toArray() as $status)
                                            <option value="{{ $status['value'] }}"
                                                {{ request('status') === $status['value'] ? 'selected' : '' }}>
                                                {{ $status['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="payment_method" class="form-select">
                                        <option value="">Tất cả phương thức</option>
                                        @foreach (\App\Enums\PaymentMethod::toArray() as $method)
                                            <option value="{{ $method['value'] }}"
                                                {{ ($data['payment_method'] ?? '') === $method['value'] ? 'selected' : '' }}>
                                                {{ $method['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="min_amount" placeholder="Tổng tiền tối thiểu"
                                           value="{{ request('min_amount') }}" class="form-control" step="0.01" min="0">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="max_amount" placeholder="Tổng tiền tối đa"
                                           value="{{ request('max_amount') }}" class="form-control" step="0.01" min="0">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                </div>
                            </form>

                            <div class="table-responsive order-table mt-4">
                                <table class="table all-package theme-table" id="table_id">
                                    <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Người dùng</th>
                                        <th>Tổng tiền</th>
                                        <th>Phí ship</th>
                                        <th>Trạng thái</th>
                                        <th>Phương thức thanh toán</th>
                                        <th>Ngày tạo</th>
                                        <th>Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ GenerateOrderNumber($order->id) }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ number_format($order->total_amount) }} đ</td>
                                            <td>{{ number_format($order->shipping_fee) }} đ</td>
                                            <td>{!! $order->status->getBadgeLabel() !!}</td>
                                            <td>{!! $order->payment_method->getBadgeLabel() !!}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <ul class="d-flex list-unstyled">
                                                    @if(!in_array($order->status->value, [\App\Enums\OrderStatus::REFUNDED->value, \App\Enums\OrderStatus::CANCELLED->value, \App\Enums\OrderStatus::RECEIVED->value, \App\Enums\OrderStatus::DELIVERED->value, \App\Enums\OrderStatus::NOT_RECEIVED->value]))
                                                        <li class="me-2">
                                                            <a href="#" class="edit-order" data-id="{{ $order->id }}"
                                                               data-status="{{ $order->status }}"
                                                               data-return-reason="{{ $order->return_reason ?? '' }}"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#{{ $order->status == \App\Enums\OrderStatus::RETURNED ? 'approveReturnModal' : ($order->status == \App\Enums\OrderStatus::PENDING_CANCELLATION ? 'approveCancelModal' : 'editOrderModal') }}">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if($order->status->value == \App\Enums\OrderStatus::NOT_RECEIVED->value)
                                                        <li class="me-2">
                                                            <a href="tel:{{ $order->user->profile->phone }}">
                                                                <i class="ri-phone-line"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="{{ route('orders.show', $order) }}">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        Xem {{ $orders->count() }} của {{ $orders->total() }} đơn hàng
                                    </div>
                                    <div>
                                        {{ $orders->appends(request()->all())->links() }}
                                    </div>
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

            // Xử lý nút chỉnh sửa trạng thái
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
                        // Hiển thị modal chỉnh sửa trạng thái thông thường
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
            let isSubmit = false;
            document.getElementById('updateBtn').addEventListener('click', function () {
                if (isSubmit) return;
                isSubmit = true;

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
                    },
                    complete: function () {
                        isSubmit = false;
                        const editModal = bootstrap.Modal.getInstance(document.getElementById('editOrderModal'));
                        editModal.hide();
                    }
                });
            });

            // Xử lý phê duyệt trả hàng
            document.getElementById('approveReturnBtn').addEventListener('click', function () {
                if (isSubmit) return;
                isSubmit = true;

                const orderId = document.getElementById('approveOrderId').value;
                updateOrderStatus(orderId, 'returned_accept', 'Phê duyệt trả hàng thành công!');
            });

            // Xử lý không phê duyệt trả hàng
            document.getElementById('rejectReturnBtn').addEventListener('click', function () {
                if (isSubmit) return;
                isSubmit = true;

                const orderId = document.getElementById('approveOrderId').value;
                updateOrderStatus(orderId, 'received', 'Đã từ chối yêu cầu trả hàng.');
            });

            // Xử lý phê duyệt hủy đơn
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

            // Hàm gửi AJAX cập nhật trạng thái
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
