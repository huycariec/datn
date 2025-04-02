@extends("admin.app")

@section("content")
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-warning p-2 text-white rounded-2 d-flex justify-content-between">
                            <h5 class="mb-0">Chi tiết đơn hàng #{{ GenerateOrderNumber($order->id) }}</h5>
                            <button onclick="window.print()" class="btn btn-secondary">In hóa đơn</button>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fa fa-info-circle"></i> Thông tin đơn hàng</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Mã đơn hàng</label>
                                            <div class="col-sm-8">
                                                <span class="fw-bold text-dark">{{ GenerateOrderNumber($order->id) }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Khách hàng</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark">{{ $order->user ? $order->user->name : 'Khách vãng lai' }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Email</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark">{{ $order->user ? $order->user->email : 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Số điện thoại</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark">{{ $order->user && $order->user->profile ? $order->user->profile->phone : 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Ngày sinh</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark">{{ $order->user && $order->user->profile && $order->user->profile->dob ? $order->user->profile->dob->format('d/m/Y') : 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Trạng thái</label>
                                            <div class="col-sm-8">
                                            <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $order->status->label() }}
                                            </span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Phương thức thanh toán</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark">{!! $order->payment_method->getBadgeLabel()  !!}</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Phí vận chuyển</label>
                                            <div class="col-sm-8">
                                                <span class="text-dark">{{ number_format($order->shipping_fee, 0, ',', '.') }} VND</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-sm-4 font-weight-bold">Giới tính</label>
                                            <div class="col-sm-8">
                                            <span class="text-dark">
                                                {{ $order->user && $order->user->profile ? ($order->user->profile->gender == 1 ? 'Nam' : ($order->user->profile->gender == 0 ? 'Nữ' : 'Khác')) : 'N/A' }}
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fa fa-map-marker"></i> Địa chỉ giao hàng</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <span class="text-dark">{{ $order->userAddress ? 'Tỉnh/TP: ' . $order->userAddress->province->name . ', Quận/Huyện: ' . $order->userAddress->district->name . ', Xã/Phường: ' . $order->userAddress->ward->name : 'Chưa có thông tin' }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-dark">{{ $order->userAddress ? 'Địa chỉ chi tiết: ' . $order->userAddress->address_detail : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3"><i class="fa fa-shopping-cart"></i> Chi tiết sản phẩm</h6>
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
                                <h6 class="border-bottom pb-2 mb-3"><i class="fa fa-ticket"></i> Thông tin giảm giá</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-light">
                                        <tr>
                                            <th>Mã giảm giá</th>
                                            <th>Giá trị giảm</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($order->orderDiscounts as $discount)
                                            <tr>
                                                <td>{{ $discount->discount_id }}</td>
                                                <td>{{ $discount->discount_value }}</td>
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
                                <h6 class="border-bottom pb-2 mb-3"><i class="fa fa-money"></i> Tổng quan thanh toán</h6>
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
                                            <span>- {{ number_format($order->orderDiscounts->sum('discount_value'), 0, ',', '.') }} VND</span>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
@endsection
