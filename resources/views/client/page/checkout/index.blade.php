@extends('app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-danger">🛒 Thanh Toán</h2>

    <!-- Địa chỉ nhận hàng -->
    <div class="bg-white p-3 rounded shadow-sm mb-4">
        <h5>📍 Địa Chỉ Nhận Hàng</h5>

        @if(isset($userAddress) && $userAddress)
            <div id="show-address">
                <p><strong>{{ $user->name }}</strong> (+84) {{ $user->phone }}</p>
                <p>{{ $userAddress->address_detail }}, {{ $userAddress->ward->name ?? '' }}, {{ $userAddress->district->name ?? '' }}, {{ $userAddress->province->name ?? '' }}</p>
                <a href="javascript:void(0);" onclick="toggleAddressForm()" class="text-primary">Chỉnh sửa</a>
            </div>
        @endif

        <!-- Form nhập địa chỉ -->
        <div id="address-form" style="{{ isset($userAddress) && $userAddress ? 'display:none;' : '' }}">
            <form id="addressForm" method="POST">
                @csrf
                <label>Địa chỉ chi tiết:</label>
                <input type="text" name="address_detail" value="{{ $userAddress->address_detail ?? '' }}" placeholder="Số nhà, tên đường..." required>

                <select name="province_id" id="province-select">
                  <option value="">-- Chọn Tỉnh/Thành --</option>
                  @foreach($provinces as $province)
                      <option value="{{ $province->id }}" {{ (isset($userAddress) && $userAddress->province_id == $province->id) ? 'selected' : '' }}>
                          {{ $province->name }}
                      </option>
                  @endforeach
              </select>
              
              <select name="district_id" id="district-select">
                  <option value="">-- Chọn Quận/Huyện --</option>
                  @foreach($districts as $district)
                      <option value="{{ $district->id }}" {{ (isset($userAddress) && $userAddress->district_id == $district->id) ? 'selected' : '' }}>
                          {{ $district->name }}
                      </option>
                  @endforeach
              </select>
              
              <select name="ward_id" id="ward-select">
                <option value="">-- Chọn Phường/Xã --</option>
                @foreach($wards as $ward)
                    <option value="{{ $ward->id }}" {{ (isset($userAddress) && $userAddress->ward_id == $ward->id) ? 'selected' : '' }}>
                        {{ $ward->name }}
                    </option>
                @endforeach
            </select>

                <button type="submit" class="btn btn-primary mt-2">Lưu địa chỉ</button>
            </form>
        </div>
    </div>

    <form  id="checkoutForm" action="{{route('checkout.placeOrder')}}" method="POST">
        @csrf
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
                    @php $totalCart = 0; @endphp
                    @foreach($cartItems as $cartItem)
                    @php
                        $totalPrice = $cartItem->variant->price * $cartItem->quantity;
                        $totalCart += $totalPrice;

                    @endphp
                    @foreach ($cartItem->product->images as $image)
                        <tr>
                            <input type="hidden" name="cart_items[{{ $cartItem->id }}][id]" value="{{ $cartItem->id }}">
                            <td class="d-flex align-items-center gap-3">
                                    @if (empty($image->product_variant_id))
                                        <img src="{{ Storage::url($image->url) }}" alt="Hình ảnh sản phẩm" width="100" class="img-thumbnail">
                                        @break
                                    @endif
                                @endforeach
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
                            <td>{{ number_format($totalPrice, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Voucher -->
        <div class="bg-white p-3 rounded shadow-sm mb-4">
            <label for="voucher-select" class="form-label">🎟 Chọn Voucher:</label>
            <select id="voucher-select" class="form-select" name="discount_id">
                <option value="" data-type="" data-value="0">-- Chọn Voucher --</option>
                @foreach($vouchers as $voucher)
                    <option value="{{ $voucher->id }}" 
                            data-type="{{ $voucher->type }}" 
                            data-value="{{ $voucher->computed_value }}">
                        {{ $voucher->code }} - 
                        @if($voucher->type === 'percent')
                            Giảm {{ $voucher->value }}%
                        @elseif($voucher->type === 'fixed')
                            Giảm {{ number_format($voucher->computed_value, 0, ',', '.') }}đ
                        @endif
                    </option>
                @endforeach
            </select>
            <p class="mt-2 text-success fw-bold" id="voucher-info"></p>
        </div>



        <div class="bg-white p-3 rounded shadow-sm mb-4">
            <h4 class="mb-3">Chọn phương thức thanh toán</h4>
                        <div class="card-body mx-3">
                            <label>
                                <input type="radio" name="payment_method" value="CASH" >
                                <img
                                    src="https://thumbs.dreamstime.com/b/earn-money-vector-logo-icon-design-salary-symbol-design-hand-illustrations-earn-money-vector-logo-icon-design-salary-symbol-152893719.jpg"
                                    alt="VNPay Logo" width="50" height="50">
                                Thanh toán khi nhận hàng
                            </label> <br> <br>
                            <label>
                                <input type="radio" name="payment_method" value="VNPAY" >
                                <img src="https://vinadesign.vn/uploads/images/2023/05/vnpay-logo-vinadesign-25-12-57-55.jpg"
                                    alt="VNPay Logo" width="50" height="50">
                                Thanh toán bằng VNPay
                            </label>
                            <br> <br>

                            <label>
                                <input type="radio" name="payment_method" value="MOMO" >
                                <img
                                    src="https://developers.momo.vn/v3/vi/assets/images/circle-a14ff76cbd316ccef146fa7deaaace2e.png"
                                    alt="Momo Logo" width="50" height="50">
                                Thanh toán bằng Momo
                            </label>
                            <br>
                            <span class="text-danger" id="error_payment"></span>
                        </div>
            
        </div>
        
        

        <!-- Tổng tiền -->
        <div class="bg-white p-3 rounded shadow-sm mb-4">
            <p>Phí vận chuyển: <span id="shipping_fee">{{ number_format(0, 0, ',', '.') }}đ</span></p>
            <input type="hidden" name="shipping_fee" id="shipping_fee_input" value="0"> <!-- Input ẩn phí ship -->
            <hr>
            <p>Tổng tiền: <span id="total_cart">{{ number_format($totalCart, 0, ',', '.') }}đ</span></p> <!-- Đổi id -->
            <input type="hidden" name="total_cart" id="total_cart_input" value="{{ $totalCart }}"> <!-- Input ẩn tổng tiền -->
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5 text-danger">
                <span>Tổng thanh toán:</span>
                <span id="total_payment">{{ number_format($totalCart, 0, ',', '.') }}đ</span>
                <input type="hidden" name="total_payment" id="total_payment_input" value="{{ $totalCart }}"> <!-- Input ẩn tổng thanh toán -->
            </div>
            
        </div>

        <!-- Nút đặt hàng -->
        <div class="text-end">
            <button type="submit" class="btn btn-danger px-5 py-2">Đặt Hàng</button>
        </div>
    </form>
</div>
@endsection

@section('js-custom')
<script>
document.addEventListener("DOMContentLoaded", function() {
    let totalCart = parseInt({{ $totalCart }}); // Tổng tiền giỏ hàng
    let shippingFee = 0; // Mặc định phí vận chuyển
    let discountValue = 0; // Giá trị giảm giá từ voucher

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }

    function updateTotalPayment() {
    let totalPayment = totalCart + shippingFee - discountValue;
    if (totalPayment < 0) totalPayment = 0;

    console.log("🛠 Tổng tiền giỏ hàng:", totalCart);
    console.log("🛠 Phí vận chuyển:", shippingFee);
    console.log("🛠 Giá trị giảm giá:", discountValue);
    console.log("🛠 Tổng thanh toán:", totalPayment);

    let totalPaymentEl = document.getElementById('total_payment');
    let totalPaymentInput = document.getElementById('total_payment_input');
    let totalCartInput = document.getElementById('total_cart_input');

    if (!totalPaymentEl || !totalPaymentInput || !totalCartInput) {
        console.error("❌ Lỗi: Không tìm thấy phần tử HTML cần cập nhật!");
        return;
    }

    totalPaymentEl.textContent = formatCurrency(totalPayment);
    totalPaymentInput.value = totalPayment;
    totalCartInput.value = totalCart;
}

    function fetchShippingFee(districtId) {
        if (!districtId) return;
        fetch(`/checkout/get-shipping-fee/${districtId}`)
            .then(response => response.json())
            .then(data => {
                shippingFee = parseInt(data.fee) || 0;
                document.getElementById('shipping_fee').textContent = formatCurrency(shippingFee);
                // Cập nhật input ẩn phí ship
                document.getElementById('shipping_fee_input').value = shippingFee;
                updateTotalPayment();
            })
            .catch(error => console.error("Lỗi khi lấy phí ship:", error));
    }

    // Tự động tính phí vận chuyển nếu đã có địa chỉ sẵn
    let userAddress = @json($userAddress);
    if (userAddress && userAddress.district_id) {
        fetchShippingFee(userAddress.district_id);
    }

    // Khi chọn tỉnh/thành -> Load quận/huyện
    document.getElementById('province-select').addEventListener('change', function() {
        let provinceId = this.value;
        let districtSelect = document.getElementById('district-select');
        let wardSelect = document.getElementById('ward-select');

        districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
        wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
        shippingFee = 0;
        updateTotalPayment();

        if (!provinceId) return;

        fetch(`/checkout/get-districts/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(district => {
                    districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                });
            });
    });

    // Khi chọn quận/huyện -> Load phường/xã & tính phí ship
    document.getElementById('district-select').addEventListener('change', function() {
        let districtId = this.value;
        let wardSelect = document.getElementById('ward-select');
        wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
        shippingFee = 0;
        updateTotalPayment();

        if (!districtId) return;

        fetch(`/checkout/get-wards/${districtId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(ward => {
                    wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                });
            });

        fetchShippingFee(districtId);
    });

    // Gửi form lưu địa chỉ
    document.getElementById('addressForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch('/checkout/save-address', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert('Lưu địa chỉ thành công!');
            location.reload();
        })
        .catch(error => {
            alert('Lưu địa chỉ thất bại!');
        });
    });

    // Ẩn/hiện form địa chỉ
    window.toggleAddressForm = function() {
        document.getElementById('show-address').style.display = 'none';
        document.getElementById('address-form').style.display = 'block';
    };

    // Xử lý khi chọn voucher
    document.getElementById('voucher-select').addEventListener('change', function() {
        let selectedOption = this.selectedOptions[0];
        let discountType = selectedOption.dataset.type;
        discountValue = parseInt(selectedOption.dataset.value) || 0;

        let displayText = "";
        if (discountType === 'percent') {
            displayText = `🔥 Bạn được giảm ${discountValue}đ tổng đơn hàng!`;
        } else if (discountType === 'fixed') {
            displayText = `🔥 Bạn được giảm ${formatCurrency(discountValue)}!`;
        } else {
            displayText = "";
        }

        document.getElementById('voucher-info').textContent = displayText;
        updateTotalPayment();
    });


    document.querySelector('.btn-danger').addEventListener('click', function(e) {
        e.preventDefault(); // Ngăn submit mặc định để kiểm tra hợp lệ

        let addressDetail = document.querySelector('input[name="address_detail"]');
        let province = document.querySelector('select[name="province_id"]');
        let district = document.querySelector('select[name="district_id"]');
        let ward = document.querySelector('select[name="ward_id"]');
        let paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        let errorPayment = document.getElementById('error_payment');

        // Kiểm tra địa chỉ có hợp lệ không
        if (!addressDetail.value.trim() || !province.value || !district.value || !ward.value) {
            alert("Vui lòng nhập đầy đủ địa chỉ nhận hàng!");
            return;
        }

        // Kiểm tra đã chọn phương thức thanh toán chưa
        if (!paymentMethod) {
            errorPayment.textContent = "Vui lòng chọn phương thức thanh toán!";
            return;
        } else {
            errorPayment.textContent = "";
        }

        // Nếu hợp lệ thì submit form
        document.getElementById('checkoutForm').submit();
    });

});





</script>
@endsection
