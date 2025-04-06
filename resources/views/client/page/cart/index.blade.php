@extends('app')
@section('css')
<style>
    .edit-popup {
        position: absolute;
        top: 100px;
        left: 50%;
        transform: translateX(-50%);
        width: 350px;
        padding: 15px;
        background: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 0 8px rgba(0,0,0,0.2);
        border-radius: 8px;
        z-index: 999;
    }
    .hidden {
        display: none;
    }
    .options button {
        padding: 6px 12px;
        margin: 5px 5px 0 0;
        border: 1px solid #ccc;
        background-color: #f7f7f7;
        cursor: pointer;
        border-radius: 4px;
    }
    .options button.active {
        border-color: red;
        color: red;
        background-color: #ffeaea;
    }
    .popup-actions {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
    }
    .popup-actions button {
        padding: 8px 16px;
        border: none;
        background-color: orange;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }
    .back-btn {
        background-color: #ddd;
        color: #333;
    }


</style>
@endsection
@section('content')
<section class="cart-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-5 g-3">
            <div class="col-xxl-9">


                <div class="cart-table">
                    <div class="table-responsive-xl">
                        @if (session('success'))
                            <div id="alert-message" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
        
                        @if (session('error'))
                            <div id="alert-message" class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (empty($cartItems))

                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <h5>Giỏ hàng của bạn đang trống. Hãy thêm sản phẩm vào giỏ hàng!</h5>
                                    </td>
                                </tr>
                            @else
                                @foreach ($cartItems as $item)
                                <tr>
                                    <!-- Checkbox -->
                                    <td>
                                        <input type="checkbox" class="cart-item-checkbox" 
                                        data-price="{{ $item['quantity'] * $item['variant_price'] }}"> 
                                    </td>
                        
                                    <!-- Sản phẩm -->
                                    <td class="text-start d-flex align-items-center">
                                        <a href="#" class="me-3">
                                            <img src="{{ Storage::url($item['product_image']) }}" class="img-thumbnail" 
                                                 style="width: 100px; height: 100px; object-fit: cover;" 
                                                 alt="{{ $item['product_name'] }}">
                                        </a>
                                        <div>
                                            <div>
                                                <strong class="d-block text-primary fs-5">{{ $item['product_name'] }}</strong>
                                                <div class="mt-1">
                                                    @foreach ($item['selected_attributes'] as $attrName => $attrValue)
                                                        <span class="badge bg-secondary-subtle text-dark border px-2 py-1 me-1">
                                                            <i class="fa fa-tag text-muted"></i> {{ $attrName }}: <strong>{{ $attrValue }}</strong>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                        <!-- Nút mở popup, gắn data-cart-id để nhận diện -->
                                        <button class="edit-btn" data-cart-id="{{ $item['cart_id'] }}">Chỉnh sửa</button>

                                    <!-- Popup gắn ID theo cart_id -->
                                    <div class="edit-popup hidden" id="edit-popup-{{ $item['cart_id'] }}" data-all-attributes='@json((object) $item["all_attributes"])'>

                                        <h3>Phân loại hàng</h3>
                                    
                                        @php
                                            // Lấy key các thuộc tính (bỏ qua stock)
                                            $attributeKeys = [];
                                            foreach ($item['all_attributes'] as $variant) {
                                                foreach($variant as $key => $value) {
                                                    if($key != 'stock') {
                                                        $attributeKeys[] = $key;
                                                    }
                                                }
                                                break;
                                            }
                                    
                                            // Gom giá trị từng thuộc tính (loại trùng lặp)
                                            $attributeValues = [];
                                            foreach ($attributeKeys as $key) {
                                                $attributeValues[$key] = [];
                                                foreach ($item['all_attributes'] as $variant) {
                                                    if (isset($variant[$key]) && !in_array($variant[$key], $attributeValues[$key])) {
                                                        $attributeValues[$key][] = $variant[$key];
                                                    }
                                                }
                                            }
                                        @endphp
                                    
                                        @foreach($attributeValues as $attrKey => $values)
                                            <div style="margin-top: 10px;">
                                                <strong>{{ ucfirst($attrKey) }}:</strong>
                                                <div class="options {{ $attrKey }}-options">
                                                    @foreach($values as $value)
                                                        <button 
                                                            data-key="{{ $attrKey }}" 
                                                            data-value="{{ $value }}"
                                                            @if(($item['selected_attributes'][$attrKey] ?? '') == $value) 
                                                                class="selected" 
                                                            @endif
                                                        >
                                                            {{ ucfirst($value) }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    
                                        {{-- ✅ Hiển thị lỗi realtime --}}
                                        <div class="error-message text-red-500 text-sm mt-2"></div>
                                    
                                        <div class="popup-actions" style="margin-top: 15px;">
                                            <form action="{{ route('cart.updateVariant') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cart_id" value="{{ $item['cart_id'] }}">
                                                <input type="hidden" name="sku" value="">
                                                <button type="button" class="back-btn">Trở lại</button>
                                                <button type="button" class="confirm-btn" data-cart-id="{{ $item['cart_id'] }}">Xác nhận</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                            
                         
                                    </td>
                        
                                    <!-- Giá -->
                                    <td>
                                        <span class="fw-bold text-danger" data-price="{{ $item['variant_price'] }}">
                                            {{ number_format($item['variant_price'], 0, ',', '.') }}₫
                                        </span>
                                    </td>
                                    
                        
                                    <!-- Số lượng -->
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary qty-left-minus" type="button" data-type="minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center qty-input" 
                                            name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            data-id="{{ $item['cart_id'] }}" data-stock="{{ $item['stock'] }}">
                                                                            
                                            <button class="btn btn-outline-secondary qty-right-plus" type="button" data-type="plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                        
                                    <!-- Tổng tiền -->
                                    <td>
                                                <span class="fw-bold item-total" data-total="{{ $item['quantity'] * $item['variant_price'] }}">
                                                    {{ number_format($item['quantity'] * $item['variant_price'], 0, ',', '.') }}₫
                                                </span> 
                                    </td>
                                    
                                    
                        
                                    <!-- Hành động -->
                                    <td>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="cart_id" value="{{ $item['cart_id'] }}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="summery-box p-sticky">
                <form action="{{route('checkout.index')}}" method="GET">
                    @csrf
                    <div class="summery-header">
                        <h3>Tổng đơn hàng</h3>
                    </div>
            
                    <div class="summery-contain">
                        <ul>
                            <li>
                                <h4>Tạm tính</h4>
                                <h4 class="price" id="subtotal-price">0₫</h4>
                            </li>
                        
                            <li>
                                <h4>Giảm giá</h4>
                                <h4 class="price">(-) 0₫</h4>
                            </li>
                        </ul>
                        
                        <ul class="summery-total">
                            <li class="list-total border-top-0">
                                <h4>Tổng tiền</h4>
                                <h4 class="price theme-color" id="total-price">0₫</h4>
                            </li>
                        </ul>
                        
            
                    <div class="button-group cart-button">
                        <ul>
                            <li>
                                @if (!empty($cartItems))
                                <div class="dynamic-hidden">
                                    <input type="hidden" name="cart_id[]" class="cart-id" data-cart-id="{{ $item['cart_id'] }}" value="{{ $item['cart_id'] }}">
                                    <input type="hidden" name="quantity_update[]" class="quantity-update" data-cart-id="{{ $item['cart_id'] }}" value="{{ $item['quantity'] }}">
                                </div>
                                @endif

                                
    
                                <button 
                                    class="btn btn-animation proceed-btn fw-bold">Tiến hành thanh toán</button>
                            </li>
            
                            <li>
                                <button
                                    class="btn btn-light shopping-button text-dark">
                                    <i class="fa-solid fa-arrow-left-long"></i> Quay lại mua sắm
                                </button>
                            </li>
                        </ul>
                    </div>
                </form>
                </div>
            </div>
            
            
        </div>
    </div>



</section>

@endsection
@section('js-custom')
<script>
document.addEventListener("DOMContentLoaded", function () {

const selectAllCheckbox = document.getElementById('selectAll');
const checkboxes = document.querySelectorAll('.cart-item-checkbox');
const quantityInputs = document.querySelectorAll(".qty-input");
const orderTotalElement = document.getElementById("total-price");
const subtotalElement = document.getElementById("subtotal-price");
const checkoutForm = document.querySelector("form[action='{{route('checkout.index')}}']");

function numberFormat(number) {
    return new Intl.NumberFormat("vi-VN").format(number);
}

function updateHiddenInputs() {
    const hiddenContainer = checkoutForm.querySelector('.dynamic-hidden') || document.createElement('div');
    hiddenContainer.classList.add('dynamic-hidden');
    hiddenContainer.innerHTML = '';

    document.querySelectorAll('.cart-item-checkbox:checked').forEach(checkbox => {
        const row = checkbox.closest('tr');
        const cartId = row.querySelector('.qty-input').dataset.id;
        const quantity = row.querySelector('.qty-input').value;

        hiddenContainer.innerHTML += `<input type="hidden" name="cart_id[]" value="${cartId}">`;
        hiddenContainer.innerHTML += `<input type="hidden" name="quantity[]" value="${quantity}">`;
    });

    checkoutForm.appendChild(hiddenContainer);
}

function updateOrderTotal() {
    let subtotal = 0;
    document.querySelectorAll('.cart-item-checkbox:checked').forEach(checkbox => {
        const row = checkbox.closest("tr");
        const itemTotal = parseFloat(row.querySelector(".item-total").dataset.total);
        subtotal += itemTotal;
    });

    subtotalElement.textContent = numberFormat(subtotal) + "₫";
    orderTotalElement.textContent = numberFormat(subtotal) + "₫";
    updateHiddenInputs();
}

selectAllCheckbox.addEventListener('change', function () {
    const isChecked = this.checked;
    checkboxes.forEach(checkbox => {
        if (!checkbox.disabled) {
            checkbox.checked = isChecked;
        }
    });
    updateOrderTotal();
});

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        selectAllCheckbox.checked = document.querySelectorAll('.cart-item-checkbox:checked').length === document.querySelectorAll('.cart-item-checkbox:not(:disabled)').length;
        updateOrderTotal();
    });
});

quantityInputs.forEach(input => {
    const stock = parseInt(input.dataset.stock);
    const minusBtn = input.closest(".input-group").querySelector(".qty-left-minus");
    const plusBtn = input.closest(".input-group").querySelector(".qty-right-plus");
    const row = input.closest("tr");
    const checkbox = row.querySelector('.cart-item-checkbox');

    if (stock === 0) {
        input.value = 0;
        input.disabled = true;
        minusBtn.disabled = true;
        plusBtn.disabled = true;
        checkbox.disabled = true;

        const stockNotice = document.createElement('small');
        stockNotice.classList.add('text-danger');
        stockNotice.textContent = 'Hết hàng';
        input.closest('.input-group').appendChild(stockNotice);
        return;
    }

    function updateItemTotal() {
        const price = parseFloat(row.querySelector(".text-danger").dataset.price);
        const quantity = parseInt(input.value);
        const totalElement = row.querySelector(".item-total");
        const itemTotal = price * quantity;

        totalElement.dataset.total = itemTotal;
        totalElement.textContent = numberFormat(itemTotal) + "₫";
        updateOrderTotal();
    }

    plusBtn.addEventListener("click", function () {
        let currentQty = parseInt(input.value);
        if (currentQty < stock) {
            input.value = currentQty + 1;
            hideStockError(input);
            updateItemTotal();
        } else {
            showStockError(input, stock);
        }
    });

    minusBtn.addEventListener("click", function () {
        let currentQty = parseInt(input.value);
        if (currentQty > 1) {
            input.value = currentQty - 1;
            hideStockError(input);
            updateItemTotal();
        }
    });

    input.addEventListener("input", function () {
        let value = parseInt(input.value);
        if (isNaN(value) || value < 1) {
            input.value = 1;
            hideStockError(input);
        } else if (value > stock) {
            input.value = stock;
            showStockError(input, stock);
        } else {
            hideStockError(input);
        }
        updateItemTotal();
    });

});

checkoutForm.addEventListener('submit', function (e) {
    let hasError = false;
    let errorMessages = [];

    quantityInputs.forEach(input => {
        const stock = parseInt(input.dataset.stock);
        const qty = parseInt(input.value);
        const productName = input.dataset.name; // lấy tên sản phẩm từ data-name

        if (!input.disabled && qty > stock) {
            showStockError(input, stock);
            hasError = true;
            errorMessages.push(`- ${productName}: tối đa ${stock} sản phẩm`);
        }
    });

    if (document.querySelectorAll('.cart-item-checkbox:checked').length === 0) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
    } else if (hasError) {
        e.preventDefault();
        alert('Có sản phẩm vượt quá số lượng trong kho:\n' + errorMessages.join('\n'));
    }
});


function showStockError(input, stock) {
    let errorElement = input.closest('.input-group').querySelector('.stock-error');

    if (!errorElement) {
        errorElement = document.createElement('small');
        errorElement.classList.add('stock-error', 'text-danger');
        input.closest('.input-group').appendChild(errorElement);
    }

    errorElement.textContent = `⚠️ Tối đa chỉ còn ${stock} sản phẩm trong kho!`;
}

function hideStockError(input) {
    const errorElement = input.closest('.input-group').querySelector('.stock-error');
    if (errorElement) {
        errorElement.remove();
    }
}

updateOrderTotal();

});

// document.addEventListener("DOMContentLoaded", function () {

//     const selectAllCheckbox = document.getElementById('selectAll');
//     const checkboxes = document.querySelectorAll('.cart-item-checkbox');
//     const quantityInputs = document.querySelectorAll(".qty-input");
//     const orderTotalElement = document.getElementById("total-price");
//     const subtotalElement = document.getElementById("subtotal-price");
//     const checkoutForm = document.querySelector("form[action='{{route('checkout.index')}}']");

//     function numberFormat(number) {
//         return new Intl.NumberFormat("vi-VN").format(number);
//     }

//     function updateHiddenInputs() {
//         const hiddenContainer = checkoutForm.querySelector('.dynamic-hidden') || document.createElement('div');
//         hiddenContainer.classList.add('dynamic-hidden');
//         hiddenContainer.innerHTML = '';

//         document.querySelectorAll('.cart-item-checkbox:checked').forEach(checkbox => {
//             const row = checkbox.closest('tr');
//             const cartId = row.querySelector('.qty-input').dataset.id;
//             const quantity = row.querySelector('.qty-input').value;

//             hiddenContainer.innerHTML += `<input type="hidden" name="cart_id[]" value="${cartId}">`;
//             hiddenContainer.innerHTML += `<input type="hidden" name="quantity[]" value="${quantity}">`;
//         });

//         checkoutForm.appendChild(hiddenContainer);
//     }

//     function updateOrderTotal() {
//         let subtotal = 0;
//         document.querySelectorAll('.cart-item-checkbox:checked').forEach(checkbox => {
//             const row = checkbox.closest("tr");
//             const itemTotal = parseFloat(row.querySelector(".item-total").dataset.total);
//             subtotal += itemTotal;
//         });

//         subtotalElement.textContent = numberFormat(subtotal) + "₫";
//         orderTotalElement.textContent = numberFormat(subtotal) + "₫";
//         updateHiddenInputs();
//     }

//     selectAllCheckbox.addEventListener('change', function () {
//         const isChecked = this.checked;
//         checkboxes.forEach(checkbox => {
//             if (!checkbox.disabled) {
//                 checkbox.checked = isChecked;
//             }
//         });
//         updateOrderTotal();
//     });

//     checkboxes.forEach(checkbox => {
//         checkbox.addEventListener('change', function () {
//             selectAllCheckbox.checked = document.querySelectorAll('.cart-item-checkbox:checked').length === document.querySelectorAll('.cart-item-checkbox:not(:disabled)').length;
//             updateOrderTotal();
//         });
//     });

//     quantityInputs.forEach(input => {
//         const stock = parseInt(input.dataset.stock);
//         const minusBtn = input.closest(".input-group").querySelector(".qty-left-minus");
//         const plusBtn = input.closest(".input-group").querySelector(".qty-right-plus");
//         const row = input.closest("tr");
//         const checkbox = row.querySelector('.cart-item-checkbox');

//         // Nếu hết hàng
//         if (stock === 0) {
//             input.value = 0;
//             input.disabled = true;
//             minusBtn.disabled = true;
//             plusBtn.disabled = true;
//             checkbox.disabled = true;

//             const stockNotice = document.createElement('small');
//             stockNotice.classList.add('text-danger');
//             stockNotice.textContent = 'Hết hàng';
//             input.closest('.input-group').appendChild(stockNotice);
//             return; // bỏ qua không gán event nữa
//         }

//         function updateItemTotal() {
//             const price = parseFloat(row.querySelector(".text-danger").dataset.price);
//             const quantity = parseInt(input.value);
//             const totalElement = row.querySelector(".item-total");
//             const itemTotal = price * quantity;

//             totalElement.dataset.total = itemTotal;
//             totalElement.textContent = numberFormat(itemTotal) + "₫";
//             updateOrderTotal();
//         }

//         plusBtn.addEventListener("click", function () {
//             let currentQty = parseInt(input.value);
//             if (currentQty < stock) {
//                 input.value = currentQty + 1;
//                 updateItemTotal();
//             } else {
//                 showStockError(input, stock);
//             }
//         });

//         minusBtn.addEventListener("click", function () {
//             let currentQty = parseInt(input.value);
//             if (currentQty > 1) {
//                 input.value = currentQty - 1;
//                 hideStockError(input);
//                 updateItemTotal();
//             }
//         });

//         input.addEventListener("input", function () {
//             let value = parseInt(input.value);
//             if (isNaN(value) || value < 1) {
//                 input.value = 1;
//                 hideStockError(input);
//             } else if (value > stock) {
//                 input.value = stock;
//                 showStockError(input, stock);
//             } else {
//                 hideStockError(input);
//             }
//             updateItemTotal();
//         });
//     });

//     checkoutForm.addEventListener('submit', function (e) {
//         if (document.querySelectorAll('.cart-item-checkbox:checked').length === 0) {
//             e.preventDefault();
//             alert('Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
//         }
//     });

//     function showStockError(input, stock) {
//         let errorElement = input.closest('.input-group').querySelector('.stock-error');

//         if (!errorElement) {
//             errorElement = document.createElement('small');
//             errorElement.classList.add('stock-error', 'text-danger');
//             input.closest('.input-group').appendChild(errorElement);
//         }

//         errorElement.textContent = `⚠️ Tối đa chỉ còn ${stock} sản phẩm trong kho!`;
//     }

//     function hideStockError(input) {
//         const errorElement = input.closest('.input-group').querySelector('.stock-error');
//         if (errorElement) {
//             errorElement.remove();
//         }
//     }

//     updateOrderTotal();

// });

document.addEventListener('DOMContentLoaded', () => {
    // Mở popup
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {
            const cartId = e.target.dataset.cartId;
            const popup = document.querySelector(`#edit-popup-${cartId}`);

            // Ẩn hết popup khác
            document.querySelectorAll('.edit-popup').forEach(p => p.classList.add('hidden'));

            // Reset trạng thái active
            popup.querySelectorAll('.options button').forEach(button => {
                button.classList.remove('active');
                if (button.classList.contains('selected')) {
                    button.classList.add('active');
                }
            });

            // Ẩn lỗi cũ
            popup.querySelector('.error-message').textContent = '';

            popup.classList.remove('hidden');
            validateSelectionAndSetSKU(popup);
        }
    });

    // Đóng popup
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('back-btn')) {
            e.preventDefault();
            e.target.closest('.edit-popup').classList.add('hidden');
        }
    });

    // ✅ Bắt sự kiện click từng button chọn thuộc tính và validate realtime
    document.addEventListener('click', function (e) {
        if (e.target.matches('.options button')) {
            const button = e.target;
            const key = button.dataset.key;
            const popup = button.closest('.edit-popup');

            // Đổi active
            popup.querySelectorAll(`.options.${key}-options button`).forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Validate ngay khi chọn
            validateSelectionAndSetSKU(popup);
        }
    });

    // Xác nhận chọn - Gửi form
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('confirm-btn')) {
            e.preventDefault();
            const confirmBtn = e.target;
            const popup = confirmBtn.closest('.edit-popup');
            const form = popup.querySelector('form');
            const cartId = confirmBtn.dataset.cartId;

            // Validate lần cuối trước khi submit
            const result = validateSelectionAndSetSKU(popup);
            if (!result.success) {
                return;
            }

            // Gán SKU vào hidden input
            const skuInput = popup.querySelector('input[name="sku"]');
            skuInput.value = result.sku;

            console.log(`✅ Cart ID ${cartId} đã chọn:`, result.selected, 'SKU:', result.sku);

            // Submit form
            form.submit();
        }
    });
});

    // ✅ Hàm validate chung - gọi được khi chọn hoặc bấm xác nhận
    function validateSelectionAndSetSKU(popup) {
    let selected = {};
    let errorEl = popup.querySelector('.error-message');
    errorEl.textContent = ''; // Clear lỗi cũ

    const optionGroups = popup.querySelectorAll('.options');
    const totalOptions = optionGroups.length;

    // Lấy lựa chọn của user
    if (totalOptions === 1) {
        // Sản phẩm chỉ có 1 thuộc tính -> key cố định là 'option'
        const activeBtn = popup.querySelector('.options button.active') || popup.querySelector('.options button.selected');
        if (activeBtn) {
            selected['option'] = activeBtn.dataset.value;
        }
    } else {
        // Sản phẩm có nhiều thuộc tính -> lấy key động
        optionGroups.forEach(optionGroup => {
            const key = optionGroup.dataset.key 
                || Array.from(optionGroup.classList).find(cls => cls !== 'options')?.replace('-options', '') 
                || 'option';

            const activeBtn = optionGroup.querySelector('button.active') || optionGroup.querySelector('button.selected');
            if (activeBtn) {
                selected[key] = activeBtn.dataset.value;
            }
        });
    }

    // Check đã chọn đủ chưa
    if (Object.keys(selected).length < totalOptions) {
        popup.querySelector('input[name="sku"]').value = '';
        errorEl.textContent = '❌ Vui lòng chọn đầy đủ các phân loại!';
        return { success: false };
    }

    // Parse all_attributes
    let allAttributes;
    try {
        allAttributes = JSON.parse(popup.dataset.allAttributes);
    } catch (err) {
        popup.querySelector('input[name="sku"]').value = '';
        errorEl.textContent = '❌ Dữ liệu biến thể không hợp lệ!';
        return { success: false };
    }

    // So khớp SKU và check stock
    let matchedSKU = null;
    for (const [skuKey, variant] of Object.entries(allAttributes)) {
        let isMatch = true;
        for (const key in selected) {
            if (variant[key] !== selected[key]) {
                isMatch = false;
                break;
            }
        }
        if (isMatch) {
            if (variant.stock > 0) {
                matchedSKU = skuKey;
            } else {
                popup.querySelector('input[name="sku"]').value = '';
                errorEl.textContent = '❌ Biến thể bạn chọn đã hết hàng!';
                return { success: false };
            }
            break;
        }
    }

    if (!matchedSKU) {
        popup.querySelector('input[name="sku"]').value = '';
        errorEl.textContent = '❌ Biến thể bạn chọn không tồn tại!';
        return { success: false };
    }

    // Thành công
    popup.querySelector('input[name="sku"]').value = matchedSKU;
    errorEl.textContent = ''; // Clear lỗi
    return { success: true, sku: matchedSKU, selected };
}


setTimeout(function () {
    const alert = document.getElementById('alert-message');
    if (alert) {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.style.display = 'none', 500);
    }
}, 5000);


</script>
@endsection
