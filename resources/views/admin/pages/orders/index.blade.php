@extends("admin.app")

@section("content")
    <div class="page-body">
        <!-- Orders Table Start -->
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
                                                @can('orders_update')
                                                    <ul class="d-flex list-unstyled">
                                                        <li class="me-2">
                                                            <a href="#" class="edit-order" data-id="{{ $order->id }}"
                                                               data-status="{{ $order->status }}"
                                                               data-bs-toggle="modal" data-bs-target="#editOrderModal">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('orders.show', $order) }}">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endcan
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

        <!-- Modal cập nhật trạng thái đơn hàng (BS5) -->
        <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOrderModalLabel">Cập nhật trạng thái đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateOrderForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="order_id" id="order_id">
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" id="status" class="form-select">
                                    @foreach (\App\Enums\OrderStatus::toArray() as $status)
                                        <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.edit-order').on('click', function (e) {
                e.preventDefault();
                var orderId = $(this).data('id');
                var currentStatus = $(this).data('status');

                $('#order_id').val(orderId);
                $('#status').val(currentStatus);
            });

            $('#updateOrderForm').on('submit', function (e) {
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
                            alert('Cập nhật trạng thái thành công!');
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
