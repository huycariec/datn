@extends('app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-danger">🛒 Thanh Toán</h2>
    <form  id="checkoutForm" action="{{route('checkout.placeOrder')}}" method="POST">
        @csrf
        <!-- Địa chỉ nhận hàng -->
        <div class="bg-white p-3 rounded shadow-sm mb-4">
            <h5>📍 Địa Chỉ Nhận Hàng</h5>

            @php
                $defaultAddress = $userAddresses->sortBy('id')->first();
            @endphp
        
            @if(isset($defaultAddress))
                <div id="show-address">
                    <p><strong>{{ $user->name }}</strong> (+84) {{ $user->phone }}</p>
                    <p id="address-text">
                        {{ $defaultAddress->address_detail }},
                        {{ $defaultAddress->ward->name ?? '' }},
                        {{ $defaultAddress->district->name ?? '' }},
                        {{ $defaultAddress->province->name ?? '' }}
                    </p>
        
                    <div class="mb-2">
                        <select id="address-select" class="form-select" name="user_address_id" onchange="handleAddressChange()">
                            <option value="">-- Chọn địa chỉ có sẵn --</option>
                            @foreach($userAddresses as $address)
                            <option value="{{ $address->id }}"
                                data-district-id="{{ $address->district_id }}"
                                data-detail="{{ $address->address_detail }}"
                                data-ward="{{ $address->ward->name ?? '' }}"
                                data-district="{{ $address->district->name ?? '' }}"
                                data-province="{{ $address->province->name ?? '' }}"
                                {{ $address->id == $defaultAddress->id ? 'selected' : '' }}>
                                {{ $address->address_detail }}, {{ $address->ward->name ?? '' }}, {{ $address->district->name ?? '' }}, {{ $address->province->name ?? '' }}
                            </option>
                            
                            @endforeach
                        </select>
                        <p id="error_address" class="text-danger mt-2"></p>
                    </div>
        
                    <button type="button" class="btn btn-success btn-sm" onclick="toggleNewAddress()">➕ Thêm địa chỉ mới</button>
                </div>
            @endif
        
            <div id="new-address-fields" style="display: none;" class="mt-3">
                <label class="form-label">Địa chỉ chi tiết:</label>
                <input type="text" name="new_address_detail" class="form-control mb-2" placeholder="Số nhà, tên đường...">
        
                <label class="form-label">Tỉnh/Thành:</label>
                <select name="new_province_id" id="province-select" class="form-select mb-2">
                    <option value="">-- Chọn Tỉnh/Thành --</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
        
                <label class="form-label">Quận/Huyện:</label>
                <select name="new_district_id" id="district-select" class="form-select mb-2">
                    <option value="">-- Chọn Quận/Huyện --</option>
                </select>
        
                <label class="form-label">Phường/Xã:</label>
                <select name="new_ward_id" id="ward-select" class="form-select mb-2">
                    <option value="">-- Chọn Phường/Xã --</option>
                </select>
            </div>
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
                    @php $totalCart = 0; @endphp
                    @foreach($cartItems as $cartItem)
                        @php
                            $totalPrice = $cartItem->variant->price * $cartItem->quantity;
                            $totalCart += $totalPrice;

                        @endphp
                        <tr>
                            <input type="hidden" name="cart_items[{{ $cartItem->id }}][id]" value="[{{ $cartItem->id }}]">
       
                            <td class="d-flex align-items-center gap-3">
                                @foreach ($cartItem->product->images as $image)
                                  <a href="{{route('product.detail',$cartItem->product->id)}}">

                                    @if (empty($image->product_variant_id))
                                        <img src="{{ Storage::url($image->url) }}" alt="Hình ảnh sản phẩm" width="100" class="img-thumbnail">
                                        @break
                                    @endif
                                  </a>
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
                    <option value="{{ $voucher->id }}" data-type="{{ $voucher->type }}" data-value="{{ $voucher->computed_value }}">
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
                            <p id="error_payment" class="text-danger mt-2"></p>
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
            <button type="submit" id="checkout" class="btn btn-danger px-5 py-2">Đặt Hàng</button>
        </div>
    </form>
</div>
@endsection

@section('js-custom')
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        let totalCart = parseInt({{ $totalCart }});
        let shippingFee = 0;
        let discountValue = 0;
    
        const addressSelect = document.getElementById('address-select');
        const provinceSelect = document.getElementById('province-select');
        const districtSelect = document.getElementById('district-select');
        const wardSelect = document.getElementById('ward-select');
        const newAddressFields = document.getElementById('new-address-fields');
    
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }
    
        function updateTotalPayment() {
            let totalPayment = totalCart + shippingFee - discountValue;
            totalPayment = totalPayment < 0 ? 0 : totalPayment;
    
            document.getElementById('total_payment').textContent = formatCurrency(totalPayment);
            document.getElementById('total_payment_input').value = totalPayment;
            document.getElementById('total_cart_input').value = totalCart;
        }
    
        function fetchShippingFee(districtId) {
            if (!districtId) return;
            fetch(`/checkout/get-shipping-fee/${districtId}`)
                .then(res => res.json())
                .then(data => {
                    shippingFee = parseInt(data.fee) || 0;
                    document.getElementById('shipping_fee').textContent = formatCurrency(shippingFee);
                    document.getElementById('shipping_fee_input').value = shippingFee;
                    updateTotalPayment();
                })
                .catch(error => console.error("Lỗi khi lấy phí ship:", error));
        }
    
        function toggleNewAddress() {
            newAddressFields.style.display = 'block';
            if (addressSelect) addressSelect.value = ''; // Bỏ chọn địa chỉ cũ
        }
    
        function handleAddressChange() {
            if (!addressSelect) return;
            const selectedOption = addressSelect.options[addressSelect.selectedIndex];
    
            if (addressSelect.value) {
                // Nếu chọn địa chỉ cũ
                newAddressFields.style.display = 'none';
                const fullAddress = [selectedOption.dataset.detail, selectedOption.dataset.ward, selectedOption.dataset.district, selectedOption.dataset.province]
                    .filter(Boolean).join(', ');
                document.getElementById('address-text').textContent = fullAddress;
    
                if (selectedOption.dataset.districtId) {
                    fetchShippingFee(selectedOption.dataset.districtId);
                }
            }
        }
    
        // Lấy phí ship ban đầu nếu có địa chỉ mặc định
        let userAddress = @json($userAddress);
        if (userAddress && userAddress.district_id) {
            fetchShippingFee(userAddress.district_id);
        }
    
        // Sự kiện thay đổi Tỉnh
        provinceSelect?.addEventListener('change', function() {
            let provinceId = this.value;
            districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            shippingFee = 0;
            updateTotalPayment();
    
            if (!provinceId) return;
    
            fetch(`/checkout/get-districts/${provinceId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                });
        });
    
        // Sự kiện thay đổi Quận
        districtSelect?.addEventListener('change', function() {
            let districtId = this.value;
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            shippingFee = 0;
            updateTotalPayment();
    
            if (!districtId) return;
    
            fetch(`/checkout/get-wards/${districtId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(ward => {
                        wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                    });
                });
    
            fetchShippingFee(districtId);
        });
    
        // Khi chọn địa chỉ cũ
        addressSelect?.addEventListener('change', handleAddressChange);
    
        // Voucher
        document.getElementById('voucher-select')?.addEventListener('change', function() {
            let selectedOption = this.selectedOptions[0];
            let discountType = selectedOption.dataset.type;
            discountValue = parseInt(selectedOption.dataset.value) || 0;
    
            let displayText = "";
            if (discountType === 'percent') {
                displayText = `🔥 Giảm ${discountValue}% tổng đơn hàng!`;
            } else if (discountType === 'fixed') {
                displayText = `🔥 Giảm ${formatCurrency(discountValue)}!`;
            }
            document.getElementById('voucher-info').textContent = displayText;
            updateTotalPayment();
        });
    
        // Validate trước khi submit
        document.getElementById('checkout').addEventListener('click', function(e) {
            e.preventDefault(); // Ngừng hành động mặc định (submit form)

            const newAddressDetail = document.querySelector('input[name="new_address_detail"]');
            const provinceSelect = document.getElementById('province-select');
            const districtSelect = document.getElementById('district-select');
            const wardSelect = document.getElementById('ward-select');
            const addressSelect = document.getElementById('address-select');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            const errorPayment = document.getElementById('error_payment');
            const errorAddress = document.getElementById('error_address');
            
            let valid = true;

            // Reset lỗi cũ
            errorAddress.textContent = ""; 
            errorPayment.textContent = "";

            // Kiểm tra nếu đang nhập địa chỉ mới
            if (document.getElementById('new-address-fields').style.display === 'block') {
                if (!newAddressDetail.value.trim() || !provinceSelect.value || !districtSelect.value || !wardSelect.value) {
                    errorAddress.textContent = "⚠️ Vui lòng nhập đầy đủ địa chỉ nhận hàng mới!";
                    valid = false;
                }
            } else if (!addressSelect.value) {
                // Nếu không chọn địa chỉ cũ
                errorAddress.textContent = "⚠️ Vui lòng chọn địa chỉ giao hàng!";
                valid = false;
            }

            // Kiểm tra phương thức thanh toán
            if (!paymentMethod) {
                errorPayment.textContent = "⚠️ Vui lòng chọn phương thức thanh toán!";
                valid = false;
            }

            // Nếu tất cả hợp lệ thì submit form
            if (valid) {
                console.log(valid)
                document.getElementById('checkoutForm').submit(); // Gọi submit form
            }
        });





        

    
        // Gán toggle vào nút thêm mới
        window.toggleNewAddress = toggleNewAddress;
    });
    </script>
    

</script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let totalCart = parseInt({{ $totalCart }});
        let shippingFee = 0;
        let discountValue = 0;
        let isUsingNewAddress = false;

        const addressSelect = document.getElementById('address-select');
        const provinceSelect = document.getElementById('province-select');
        const districtSelect = document.getElementById('district-select');
        const wardSelect = document.getElementById('ward-select');
        const newAddressFields = document.getElementById('new-address-fields');

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        function updateTotalPayment() {
            let totalPayment = totalCart + shippingFee - discountValue;
            totalPayment = totalPayment < 0 ? 0 : totalPayment;

            document.getElementById('total_payment').textContent = formatCurrency(totalPayment);
            document.getElementById('total_payment_input').value = totalPayment;
            document.getElementById('total_cart_input').value = totalCart;
        }

        function fetchShippingFee(districtId) {
            if (!districtId) return;
            fetch(`/checkout/get-shipping-fee/${districtId}`)
                .then(res => res.json())
                .then(data => {
                    shippingFee = parseInt(data.fee) || 0;
                    document.getElementById('shipping_fee').textContent = formatCurrency(shippingFee);
                    document.getElementById('shipping_fee_input').value = shippingFee;
                    updateTotalPayment();
                })
                .catch(error => console.error("Lỗi khi lấy phí ship:", error));
        }

        function toggleNewAddress() {
            isUsingNewAddress = true;
            newAddressFields.style.display = 'block';
            if (addressSelect) addressSelect.value = ''; // Bỏ chọn địa chỉ cũ
        }

        function handleAddressChange() {
            isUsingNewAddress = false; // Đang chọn địa chỉ cũ

            if (!addressSelect) return;
            const selectedOption = addressSelect.options[addressSelect.selectedIndex];

            if (addressSelect.value) {
                newAddressFields.style.display = 'none';
                const fullAddress = [selectedOption.dataset.detail, selectedOption.dataset.ward, selectedOption.dataset.district, selectedOption.dataset.province]
                    .filter(Boolean).join(', ');
                document.getElementById('address-text').textContent = fullAddress;

                const districtId = selectedOption.dataset.districtId;
                if (districtId) {
                    fetchShippingFee(districtId);
                }
            }
        }

        // Lấy phí ship ban đầu nếu có địa chỉ mặc định
        let userAddress = @json($userAddress);
        if (userAddress && userAddress.district_id) {
            fetchShippingFee(userAddress.district_id);
        }

        // Sự kiện thay đổi Tỉnh
        provinceSelect?.addEventListener('change', function() {
            let provinceId = this.value;
            districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            if (isUsingNewAddress) {
                shippingFee = 0;
                updateTotalPayment();
            }

            if (!provinceId) return;

            fetch(`/checkout/get-districts/${provinceId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                });
        });

        // Sự kiện thay đổi Quận
        districtSelect?.addEventListener('change', function() {
            let districtId = this.value;
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            if (isUsingNewAddress) {
                shippingFee = 0;
                updateTotalPayment();
                fetchShippingFee(districtId);
            }

            if (!districtId) return;

            fetch(`/checkout/get-wards/${districtId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(ward => {
                        wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                    });
                });
        });

        // Khi chọn địa chỉ cũ
        addressSelect?.addEventListener('change', handleAddressChange);

        // Voucher
        document.getElementById('voucher-select')?.addEventListener('change', function() {
            let selectedOption = this.selectedOptions[0];
            let discountType = selectedOption.dataset.type;
            discountValue = parseInt(selectedOption.dataset.value) || 0;

            let displayText = "";
            if (discountType === 'percent') {
                displayText = `🔥 Giảm ${discountValue}% tổng đơn hàng!`;
            } else if (discountType === 'fixed') {
                displayText = `🔥 Giảm ${formatCurrency(discountValue)}!`;
            }
            document.getElementById('voucher-info').textContent = displayText;
            updateTotalPayment();
        });

        // Validate trước khi submit
        document.getElementById('checkout').addEventListener('click', function(e) {
            e.preventDefault();

            const newAddressDetail = document.querySelector('input[name="new_address_detail"]');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            const errorPayment = document.getElementById('error_payment');
            const errorAddress = document.getElementById('error_address');

            let valid = true;
            errorAddress.textContent = "";
            errorPayment.textContent = "";

            if (newAddressFields.style.display === 'block') {
                if (!newAddressDetail.value.trim() || !provinceSelect.value || !districtSelect.value || !wardSelect.value) {
                    errorAddress.textContent = "⚠️ Vui lòng nhập đầy đủ địa chỉ nhận hàng mới!";
                    valid = false;
                }
            } else if (!addressSelect.value) {
                errorAddress.textContent = "⚠️ Vui lòng chọn địa chỉ giao hàng!";
                valid = false;
            }

            if (!paymentMethod) {
                errorPayment.textContent = "⚠️ Vui lòng chọn phương thức thanh toán!";
                valid = false;
            }

            if (valid) {
                document.getElementById('checkoutForm').submit();
            }
        });

        // Gán toggle vào nút thêm mới
        window.toggleNewAddress = toggleNewAddress;
    });
</script>

@endsection
