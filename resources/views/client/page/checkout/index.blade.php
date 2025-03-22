@extends('app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-danger">🛒 Thanh Toán</h2>

    <!-- Địa chỉ nhận hàng -->
    <div class="bg-white p-3 rounded shadow-sm mb-4">
      <h5>📍 Địa Chỉ Nhận Hàng</h5>
      <p><strong>Kiều Duy Du</strong> (+84) 869837118</p>
      <p>Đường Tiên Lệ 1, Xã Tiên Yên, Huyện Hoài Đức, Hà Nội</p>
      <a href="#" class="text-primary">Thay Đổi</a>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="bg-white p-3 rounded shadow-sm mb-4">
      <h5>🛍 Sản Phẩm</h5>
      <table class="table align-middle">
        <thead class="table-light">
          <tr>
            <th>Sản phẩm</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
          </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $cartItem)
            <tr>
                <td class="d-flex align-items-center gap-3">
                    {{-- Hình ảnh sản phẩm --}}
                    @foreach ($cartItem->product->images as $image)
                        @if (empty($image->product_variant_id))
                            <img src="{{ Storage::url($image->url) }}" alt="Hình ảnh sản phẩm" width="100" class="img-thumbnail">
                            @break  {{-- Hiển thị 1 ảnh đại diện thôi --}}
                        @endif
                    @endforeach
                
                    {{-- Thông tin sản phẩm --}}
                    <div>
                        <div class="fw-bold">{{ $cartItem->product->name }}</div>
                        <small class="text-muted d-block">
                            @foreach($cartItem->variant->variantAttributes as $variantAttribute)
                                {{ $variantAttribute->attributeValue->value ?? 'Không có' }}
                            @endforeach
                        </small>
                    </div>
                </td>
                
                <td>{{ number_format($cartItem->variant->price, 0, ',', '.') }}đ</td>

              <td>{{ $cartItem->quantity }}</td>
              @php
                $totalPrice = 0;
                $totalPrice += $cartItem->variant->price * $cartItem->quantity;
            @endphp
              <td>{{ number_format($totalPrice, 0, ',', '.') }}đ</td>
                
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Voucher -->
    <div class="bg-white p-3 rounded shadow-sm mb-4 d-flex justify-content-between align-items-center">
      <div>🎟 Voucher của Shop</div>
      <a href="#" class="text-primary">Chọn Voucher</a>
    </div>

    <!-- Tổng tiền -->
    <div class="bg-white p-3 rounded shadow-sm mb-4">
      <div class="d-flex justify-content-between">
        <span>Phí vận chuyển:</span>
        <span>65.000đ</span>
      </div>
      <hr>
      <div class="d-flex justify-content-between fw-bold fs-5 text-danger">
        <span>Tổng thanh toán:</span>
        <span>2.358.474đ</span>
      </div>
    </div>

    <!-- Nút đặt hàng -->
    <div class="text-end">
      <button class="btn btn-danger px-5 py-2">Đặt Hàng</button>
    </div>
  </div>

@endsection