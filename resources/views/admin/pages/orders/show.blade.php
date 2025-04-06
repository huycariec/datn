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
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-info-circle"></i> Thông tin đơn hàng
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Mã đơn hàng</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="fw-bold text-dark">{{ GenerateOrderNumber($order->id) }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Thời gian đặt hàng</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="text-dark fw-bold">Ngày: {{ $order->created_at->format('d/m/Y') . ' lúc ' . $order->created_at->format('H:i') . ' phút'}}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Khách hàng</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="text-dark fw-bold">{{ $order->user ? $order->user->name : 'Khách vãng lai' }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Email</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="text-dark fw-bold">{{ $order->user ? $order->user->email : 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Số điện thoại</label>
                                            <div class="col-sm-8">
                                                <span
                                                    class="text-dark fw-bold">{{ $order->user && $order->user->profile ? $order->user->profile->phone : 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Trạng thái</label>
                                            <div class="col-sm-8 d-flex align-items-center gap-2">
                                                {!!  $order->status->getBadgeLabel() !!}
                                                @if(!in_array($order->status->value, [\App\Enums\OrderStatus::REFUNDED->value, \App\Enums\OrderStatus::CANCELLED->value, \App\Enums\OrderStatus::RECEIVED->value, \App\Enums\OrderStatus::DELIVERED->value, \App\Enums\OrderStatus::NOT_RECEIVED->value]))
                                                    <a href="#" class="edit-order" data-id="{{ $order->id }}"
                                                       data-status="{{ $order->status }}"
                                                       data-bs-toggle="modal" data-bs-target="#editOrderModal">
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
                                                <span
                                                    class="text-dark fw-bold">{!! $order->payment_method->getBadgeLabel()  !!}</span>
                                                @if($order->payment_method !== 'cash')
                                                    <span class="fw-bold">{!! $order->payment->status->getBadgeLabel()  !!}</span>
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
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-map-marker"></i> Địa chỉ giao hàng
                                </h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <span class="text-dark">
                                                Tỉnh/TP:
                                                <span
                                                    class="fw-bold">{{ $order->userAddress ? $order->userAddress->province->name : 'Chưa có thông tin' }}</span>,
                                                Quận/Huyện:
                                                <span class="fw-bold">{{ $order->userAddress ? $order->userAddress->district->name : '' }}</span>,
                                                Xã/Phường:
                                                <span class="fw-bold">{{ $order->userAddress ? $order->userAddress->ward->name : '' }}</span>
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            Địa chỉ chi tiết:  <span
                                                class="text-dark fw-bold">{{ $order->userAddress->address_detail ?? "" }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-shopping-cart"></i> Chi tiết sản
                                    phẩm</h6>
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
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <td>{{ $detail->product ? $detail->product->name : 'N/A' }}</td>
                                                <td>{{ $detail->productVariant ? $detail->productVariant->sku : 'N/A' }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ $detail->product ? number_format($detail->product->price, 0, ',', '.') . ' VND' : 'N/A' }}</td>
                                                <td>{{ $detail->product ? number_format($detail->quantity * $detail->product->price, 0, ',', '.') . ' VND' : 'N/A' }}</td>
                                            </tr>
                                        @endforeach
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
                                                <td colspan="2" class="text-center">Không áp dụng mã giảm giá</td>
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
                                <h6 class="text-danger border-bottom pb-2 mb-3"><i class="fa fa-money"></i> Tổng quan thanh toán
                                </h6>
                                <div class="row justify-content-end">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tổng tiền sản phẩm:</span>
                                            <span>{{ number_format($order->orderDetails->sum(fn($detail) => $detail->quantity * $detail->product->price), 0, ',', '.') }} VND</span>
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
                            <select name="status" id="status" class="form-select">
                            </select>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            const statusTransitions = {
                'pending_confirmation': ['pending_confirmation', 'confirmed', 'cancelled'],
                'confirmed': ['confirmed', 'preparing', 'cancelled'],
                'preparing': ['preparing', 'prepared', 'cancelled'],
                'prepared': ['prepared', 'picked_up'],
                'picked_up': ['picked_up', 'in_transit'],
                'in_transit': ['in_transit', 'delivered'],
                'delivered': ['delivered'],
                'received': ['received'],
                'returned': ['returned', 'refunded'],
                'cancelled': [],
                'refunded': []
            };

            const allStatuses = @json(\App\Enums\OrderStatus::toArray());

            $('.edit-order').on('click', function (e) {
                e.preventDefault();
                var orderId = $(this).data('id');
                var currentStatus = $(this).data('status');

                $('#order_id').val(orderId);

                $('#status').empty();

                var availableStatuses = statusTransitions[currentStatus] || [];

                availableStatuses.forEach(function(statusValue) {
                    var status = allStatuses.find(s => s.value === statusValue);
                    if (status) {
                        $('#status').append(
                            `<option value="${status.value}" ${status.value === currentStatus ? 'selected' : ''}>
                                ${status.label}
                            </option>`
                        );
                    }
                });

                if (availableStatuses.length === 0) {
                    $('#status').append(`<option value="${currentStatus}" selected disabled>Không thể thay đổi</option>`);
                    $('#updateBtn').prop('disabled', true);
                } else {
                    $('#updateBtn').prop('disabled', false);
                }
            });

            $('#updateBtn').on('click', function (e) {
                e.preventDefault();
                var orderId = $('#order_id').val();
                var status = $('#status').val();

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
        });
    </script>
@endsection
