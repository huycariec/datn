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

                            <form method="GET" action="{{ route('orders.index') }}"
                                  class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <input type="text" name="name" placeholder="Khách hàng ..."
                                           value="{{ request('name') }}"
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
                                           value="{{ request('min_amount') }}"
                                           class="form-control" step="0.01" min="0">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="max_amount" placeholder="Tổng tiền tối đa"
                                           value="{{ request('max_amount') }}"
                                           class="form-control" step="0.01" min="0">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                </div>
                            </form>

                            <div class="table-responsive order-table mt-4">
                                <div>
                                    <table class="table all-package theme-table" id="table_id">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
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
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ number_format($order->total_amount) }} đ</td>
                                                <td>{{ number_format($order->shipping_fee) }} đ</td>
                                                <td>{!! $order->status->getBadgeLabel() !!}</td>
                                                <td>{!! $order->payment_method->getBadgeLabel() !!}</td>
                                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @can('orders_update')
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('orders.edit', $order) }}">
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
        </div>
    </div>
@endsection
