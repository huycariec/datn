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
                                <div>{!! $order->status->getBadgeLabel() !!}</div>
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
                                                    <span
                                                        class="text-muted"> + {{ $remainingCount }} sản phẩm khác</span>
                                                @endif
                                            @else
                                                <span class="fw-bold text-dark">Sản phẩm không xác định</span>
                                            @endif
                                            <span
                                                class="text-muted"> x {{ $order->orderDetails->sum('quantity') }}</span>
                                        </div>
                                        <p class="mb-1 text-muted"><i
                                                class="bi bi-calendar3 me-2"></i>{{ $order->created_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="mb-0 text-muted"><i
                                                class="bi bi-credit-card me-2"></i>{!! $order->payment_method->getBadgeLabel() !!}
                                        </p>
                                    </div>

                                    <!-- Tổng tiền và hành động -->
                                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                        <p class="mb-2"><span class="text-muted">Tổng tiền:</span> <span
                                                class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span>
                                        </p>
                                        <div class="d-flex gap-2 justify-content-md-end">
                                            <a href="{{ route('order.detail', $order->id) }}"
                                               class="btn btn-outline-primary btn-sm fw-bold"
                                               style="border-radius: 20px; padding: 6px 15px;">Chi tiết</a>
                                            @if($order->status === \App\Enums\OrderStatus::PENDING_CONFIRMATION)
                                                <a href="#" class="btn btn-outline-danger btn-sm fw-bold"
                                                   style="border-radius: 20px; padding: 6px 15px;">Hủy đơn</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <img src="/assets/images/empty-order.png" alt="No Orders" class="mb-4" style="width: 250px; opacity: 0.9; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));">
                            <h5 class="fw-bold text-muted">Bạn chưa có đơn hàng nào!</h5>
                            <a href="#" class="btn btn-primary mt-3 fw-bold" style="border-radius: 25px; padding: 10px 30px; background: #ee4d2d; border: none; box-shadow: 0 4px 10px rgba(238,77,45,0.3);">Mua sắm ngay</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Script cho hiệu ứng hover -->
    <script>
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseover', () => {
                card.style.boxShadow = '0 8px 20px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseout', () => {
                card.style.boxShadow = '0 4px 10px rgba(0,0,0,0.05)';
            });
        });
    </script>
@endsection
