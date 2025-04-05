@extends('app')
@section('content')

    {{-- Thông báo --}}
    @if (session('success'))
        <div id="cartAlert"
             class="position-fixed top-50 start-50 translate-middle p-4 rounded-4 shadow-lg d-flex align-items-center"
             style="background: rgba(94, 104, 107, 0.85); color: white; z-index: 1050; text-align: center; display: none; width: 320px;">
            <i class="bi bi-check-circle-fill text-success me-3" style="font-size: 3rem;"></i>
            <div>
                <strong class="fs-5">Thành công!</strong>
                <p class="m-0">{{ session('success') }}</p>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let cartAlert = document.getElementById("cartAlert");
                cartAlert.style.display = "flex"; // Hiển thị thông báo
                cartAlert.style.opacity = "0";
                cartAlert.style.transition = "opacity 0.5s ease-in-out";

                setTimeout(() => {
                    cartAlert.style.opacity = "1";
                }, 100); // Hiệu ứng fade-in

                setTimeout(() => {
                    cartAlert.style.opacity = "0";
                    setTimeout(() => cartAlert.style.display = "none", 500);
                }, 5000); // Ẩn sau 2.5 giây
            });
        </script>
    @endif
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>{{ $product->name }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ $product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-2">
                                    {{-- Ảnh lớn (Main Image Slider) --}}
                                    <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                        <div class="product-main-2 no-arrow">
                                            @foreach ($product->variants as $variant)
                                                @foreach ($variant->images as $index => $image)
                                                    <div>
                                                        <div class="slider-image">
                                                            <img src="{{ Storage::url($image->url) }}"
                                                                 data-zoom-image="{{ Storage::url($image->url) }}"
                                                                 class="img-fluid image_zoom_cls-{{ $index }} blur-up lazyload"
                                                                 alt="Product Image">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Ảnh nhỏ (Thumbnail Slider) --}}
                                    <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                        <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                            @foreach ($product->variants as $variant)
                                                @foreach ($variant->images as $image)
                                                    <div>
                                                        <div class="sidebar-image">
                                                            <img src="{{ Storage::url($image->url) }}"
                                                                 class="img-fluid blur-up lazyload"
                                                                 alt="Thumbnail">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="right-box-contain">
                                <h6 class="offer-top">30% Off</h6>
                                <h2 class="name">{{$product->name}}</h2>
                                <div class="price-rating">
                                    <h3 class="theme-color price">${{ number_format($product->price, 2) }}
                                        <del class="text-content">$58.46</del>
                                    </h3>
                                    <span class="offer theme-color">(8% off)</span></h3>
                                </div>
                            </div>
                            @foreach($attributesGrouped as $attributeName => $attributeValues)
                                <div class="product-package">
                                    <div class="product-title">
                                        <h4>{{ strtoupper($attributeName) }}</h4>
                                    </div>
                                    <div class="btn-group flex-wrap" role="group">
                                        @foreach($attributeValues as $index => $attribute)
                                            <input type="radio"
                                                   class="btn-check"
                                                   name="{{ $attributeName }}"
                                                   id="attr-{{ $attributeName }}-{{ $index }}"
                                                   autocomplete="off"
                                                   value="{{ $attribute['value'] }}"
                                                   data-attribute-name="{{ $attributeName }}">
                                            <label class="btn btn-outline-primary fw-bold"
                                                   for="attr-{{ $attributeName }}-{{ $index }}">
                                                {{ $attribute['value'] }} {{-- Hiển thị giá trị (Vàng, Xanh, S, M, ...) --}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            <p id="error-message" style="color: red; display: none;"></p>


                            <form action="{{route('cart.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <div class="note-box product-package">
                                    <div class="cart_qty qty-box product-qty">
                                        <div class="input-group">
                                            <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="number"
                                                   name="quantity" value="1" min="1" max="10" id="quantity-input">
                                            <button type="button" class="qty-left-minus" data-type="minus"
                                                    data-field="">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <small id="quantity-error" class="text-danger" style="display: none;">⚠️ Số
                                            lượng không hợp lệ!</small>

                                    </div>
                                    <input type="hidden" name="sku" id="selected-sku-input" value="">
                                    <button id="btnAddToCart" class="btn btn-md bg-dark cart-button text-white w-100"
                                            disabled>Thêm Vào Giỏ Hàng
                                    </button>
                                </div>
                            </form>
                            <div class="buy-box">
                                <div class="buy-box">
                                    @php
                                        $wishlistItems = Auth::check()
                                            ? \App\Models\Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
                                            : [];
                                    @endphp

                                    @if(in_array($product->id, $wishlistItems))
                                        <button class="btn btn-secondary" disabled>❤️ Đã yêu thích</button>
                                    @else
                                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger">❤️ Thêm vào Yêu Thích
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <a href="compare.html"><i
                                        data-feather="eye"></i><span>Lượt xem: {{ $product->view }}</span></a>
                                <div class="pickup-box">
                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                            <li>Loại : <a href="javascript:void(0)">{{ $product->category_id}}</a></li>
                                            <li>Mã sản phẩm : <a href="javascript:void(0)">SDFVW65467</a></li>
                                            <li>Ngày đăng : <a href="javascript:void(0)">{{ $product->created_at->format('d/m/Y') }}</a></li>
                                            <li id="product-stock">Còn : <a href="javascript:void(0)">2 sản phẩm trong kho</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-option">
                                <div class="product-title">
                                    <h4>Đảm bảo thanh toán an toàn</h4>
                                </div>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <img
                                                src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/1.svg"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <img
                                                src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/2.svg"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <img
                                                src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/3.svg"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <img
                                                src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/4.svg"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <img
                                                src="https://themes.pixelstrap.com/fastkart/assets/images/product/payment/5.svg"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="product-section-box">
                    <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-selected="false">Mô tả</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-selected="true">Đánh giá</button>
                        </li>
                    </ul>

                    <div class="tab-content custom-tab" id="myTabContent">
                        <div class="tab-pane fade" id="description" role="tabpanel">
                            <div class="product-description">
                                <div class="nav-desh">
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade active show" id="review" role="tabpanel">
                            <div class="review-box">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <div class="product-rating-box">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="product-main-rating">
                                                        <h2>{{ number_format($averageRating, 1) }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                        </h2>
                                                        <h5>{{ $totalReviews }} số lượt đánh giá</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <ul class="product-rating-list">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <li>
                                                                <div class="rating-product">
                                                                    <h5>{{ $i }}<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" style="width: {{ $totalReviews > 0 ? ($ratingStats[$i] / $totalReviews * 100) : 0 }}%;">
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="total">{{ $ratingStats[$i] }}</h5>
                                                                </div>
                                                            </li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-7">
                                        <div class="review-people">
                                            <!-- Dropdown lọc SKU -->
                                            <div class="mb-3">
                                                <select id="sku-filter" class="form-select">
                                                    <option value="">Tất cả phân loại</option>
                                                    @foreach($variants as $variant)
                                                        <option value="{{ $variant->sku }}">{{ $variant->sku }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <ul class="review-list" id="review-list">
                                                @foreach($reviews as $review)
                                                    <li class="review-item" data-sku="{{ $review->productVariant->sku ?? 'Không xác định' }}">
                                                        <div class="people-box">
                                                            <div>
                                                                <div class="people-image people-text">
                                                                    <img alt="user" class="img-fluid" src="{{ \Illuminate\Support\Facades\Storage::url($review->user?->profile?->avatar) }}">
                                                                </div>
                                                            </div>
                                                            <div class="people-comment">
                                                                <div class="people-name">
                                                                    <a href="javascript:void(0)" class="name">{{ $review->user->name ?? 'Người dùng không xác định' }}</a>
                                                                    <div class="date-time">
                                                                        <h6 class="text-content">{{ $review->created_at->format('d-m-Y h:i A') }}</h6>
                                                                        <div class="product-rating">
                                                                            <ul class="rating">
                                                                                @for($i = 1; $i <= 5; $i++)
                                                                                    <li>
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                                                    </li>
                                                                                @endfor
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="reply">
                                                                    <p>{{ $review->content }}</p>
                                                                    <p class="text-muted">Phân loại: {{ $review->productVariant->sku ?? 'Không xác định' }}</p>
                                                                    {!! $review->image ? '<img src="' . \Illuminate\Support\Facades\Storage::url($review->image) . '" style="width: 70px; height: 100px" alt="Ảnh review">' : '' !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div id="no-reviews" class="d-none">Chưa có đánh giá nào cho phân loại này.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Product Section Start -->
    <section class="product-list-section section-b-space">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Sản phẩm liên quan</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-6_1 product-wrapper">
                        <div>
                            <div class="product-box-3 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="product-header">
                                    <div class="product-image">
                                        <a href="product-left-thumbnail.html">
                                            <img src="../assets/client/assets/images/cake/product/7.png"
                                                 class="img-fluid" alt="">
                                        </a>

                                        <ul class="product-option">
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                   data-bs-target="#view">
                                                    <i data-feather="eye"></i>
                                                </a>
                                            </li>

                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                                <a href="compare.html">
                                                    <i data-feather="refresh-cw"></i>
                                                </a>
                                            </li>

                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                <a href="wishlist.html" class="notifi-wishlist">
                                                    <i data-feather="heart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="product-footer">
                                    <div class="product-detail">
                                        <span class="span-name">Vegetable</span>
                                        <a href="product-left-thumbnail.html">
                                            <h5 class="name">Fresh Bread and Pastry Flour 200 g</h5>
                                        </a>
                                        <div class="product-rating mt-2">
                                            <ul class="rating">
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star"></i>
                                                </li>
                                            </ul>
                                            <span>(3.8)</span>
                                        </div>

                                        <h6 class="unit">1 Kg</h6>

                                        <h5 class="price"><span class="theme-color">$12.68</span>
                                            <del>$14.69</del>
                                        </h5>
                                        <div class="add-to-cart-box bg-white">
                                            <button class="btn btn-add-cart addcart-button">Add
                                                <span class="add-icon bg-light-gray">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </button>
                                            <div class="cart_qty qty-box">
                                                <div class="input-group bg-white">
                                                    <button type="button" class="qty-left-minus bg-gray"
                                                            data-type="minus" data-field="">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text"
                                                           name="quantity" value="0">
                                                    <button type="button" class="qty-right-plus bg-gray"
                                                            data-type="plus" data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
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
        </div>
    </section>
@endsection
@section('js-custom')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Xử lý lọc review theo SKU
            const skuFilter = document.getElementById('sku-filter');
            const reviewList = document.getElementById('review-list');
            const reviewItems = reviewList.getElementsByClassName('review-item');
            const noReviewsMessage = document.getElementById('no-reviews');

            skuFilter.addEventListener('change', function () {
                const selectedSku = this.value;
                let visibleCount = 0;

                for (let item of reviewItems) {
                    const itemSku = item.getAttribute('data-sku');
                    if (!selectedSku || itemSku === selectedSku) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                }

                noReviewsMessage.classList.toggle('d-none', visibleCount > 0);
            });

            // Xử lý logic thêm vào giỏ hàng và cập nhật SKU
            let productVariants = {!! $resultJson !!}; // Dữ liệu từ Laravel
            let errorMessage = document.getElementById("error-message");
            let priceElement = document.querySelector(".theme-color.price");
            let stockElement = document.getElementById("product-stock");
            let quantityInput = document.getElementById("quantity-input");
            let skuInput = document.getElementById("selected-sku-input");
            let btnAddToCart = document.getElementById("btnAddToCart");
            let btnPlus = document.querySelector(".qty-right-plus");
            let btnMinus = document.querySelector(".qty-left-minus");
            let quantityError = document.getElementById("quantity-error");

            function getAvailableAttributes(selectedAttributes) {
                let availableAttributes = {};
                Object.values(productVariants).forEach(variant => {
                    let variantAttributes = variant.attributes.map(attr => attr.value);
                    variant.attributes.forEach(attr => {
                        if (!availableAttributes[attr.value]) {
                            availableAttributes[attr.value] = new Set();
                        }
                        variantAttributes.forEach(otherAttr => {
                            if (attr.value !== otherAttr) {
                                availableAttributes[attr.value].add(otherAttr);
                            }
                        });
                    });
                });
                return availableAttributes;
            }

            function updateUI(selectedAttributes) {
                let availableAttributes = getAvailableAttributes(selectedAttributes);
                document.querySelectorAll(".btn-check").forEach(radio => {
                    let attributeValue = radio.value;
                    let label = document.querySelector(`label[for="${radio.id}"]`);
                    let attributeName = radio.getAttribute("name");

                    let selectedValues = Object.values(selectedAttributes);
                    let selectedKeys = Object.keys(selectedAttributes);

                    if (selectedValues.length === 0) {
                        radio.disabled = false;
                        label.style.display = "inline-block";
                        return;
                    }

                    if (selectedKeys.includes(attributeName)) {
                        radio.disabled = false;
                        label.style.display = "inline-block";
                        return;
                    }

                    let isValid = selectedValues.every(value => availableAttributes[value]?.has(attributeValue));
                    if (isValid) {
                        radio.disabled = false;
                        label.style.display = "inline-block";
                    } else {
                        radio.disabled = true;
                        label.style.display = "none";
                    }
                });

                let hasValidOptions = Array.from(document.querySelectorAll(".btn-check")).some(radio => !radio.disabled);
                if (!hasValidOptions) {
                    showError();
                } else {
                    errorMessage.style.display = "none";
                }

                validateAddToCart();
            }

            function showError() {
                errorMessage.style.display = "block";
                errorMessage.innerText = "❌ Không có sản phẩm phù hợp!";
                priceElement.innerHTML = `<span class="text-danger">N/A</span>`;
                stockElement.innerHTML = `<span class="text-danger">Hết hàng</span>`;
                quantityInput.setAttribute("max", 0);
                quantityInput.value = 0;
                skuInput.value = "";
            }

            function updateProductInfo(matchedProduct, selectedAttributes) {
                if (!matchedProduct) {
                    console.log("⚠️ Không tìm thấy sản phẩm phù hợp:", selectedAttributes);
                    showError();
                } else {
                    console.log("✅ Tìm thấy sản phẩm:", matchedProduct);
                    errorMessage.style.display = "none";
                    let newPrice = matchedProduct.product_variant.price;
                    let newStock = matchedProduct.product_variant.stock;

                    priceElement.innerHTML = `$${parseFloat(newPrice).toFixed(2)} <del class="text-content">$58.46</del>`;
                    stockElement.innerHTML = `Còn : <a href="javascript:void(0)">${newStock} sản phẩm trong kho</a>`;
                    quantityInput.setAttribute("max", newStock);

                    if (parseInt(quantityInput.value) > newStock) {
                        quantityInput.value = newStock;
                    }

                    if (Object.keys(selectedAttributes).length === Object.keys(matchedProduct.attributes).length) {
                        let skuValue = matchedProduct.product_variant.sku;
                        skuInput.value = skuValue;
                        console.log("✅ SKU được gán:", skuValue);
                    } else {
                        skuInput.value = "";
                        console.log("⚠️ Chưa chọn đủ thuộc tính, SKU rỗng");
                    }
                }
                validateAddToCart();
            }

            function handleAttributeSelection(selectedAttributes) {
                console.log("🔍 Thuộc tính đã chọn:", selectedAttributes);
                let matchedProduct = null;

                for (let sku in productVariants) {
                    let variant = productVariants[sku];
                    let isMatch = Object.keys(selectedAttributes).every(
                        key => variant.attributes.some(attr => attr.value == selectedAttributes[key])
                    );
                    if (isMatch) {
                        matchedProduct = variant;
                        break;
                    }
                }

                updateUI(selectedAttributes);
                updateProductInfo(matchedProduct, selectedAttributes);
            }

            function updateQuantity(change) {
                let maxStock = parseInt(quantityInput.getAttribute("max")) || 10;
                let minStock = parseInt(quantityInput.getAttribute("min")) || 1;
                let currentValue = parseInt(quantityInput.value) || minStock;

                let newValue = currentValue + change;
                quantityInput.value = Math.min(Math.max(newValue, minStock), maxStock);
                validateAddToCart();
            }

            function validateAddToCart() {
                let selectedAttributes = {};
                document.querySelectorAll(".btn-check:checked").forEach(checkedRadio => {
                    let attributeName = checkedRadio.getAttribute("name");
                    let attributeValue = checkedRadio.value;
                    selectedAttributes[attributeName] = attributeValue;
                });

                if (!btnAddToCart) {
                    console.error("⚠️ btnAddToCart không tìm thấy!");
                    return;
                }

                if (Object.keys(selectedAttributes).length === 0) {
                    console.log("⚠️ Chưa chọn thuộc tính, tắt nút Add to Cart");
                    btnAddToCart.disabled = true;
                    return;
                }

                let isAttributesSelected = Object.keys(selectedAttributes).length === Object.keys(productVariants[Object.keys(productVariants)[0]].attributes).length;
                let stockAvailable = parseInt(quantityInput.getAttribute("max")) > 0;
                let quantityValid = parseInt(quantityInput.value) > 0;

                if (isAttributesSelected && stockAvailable && quantityValid) {
                    console.log("✅ Điều kiện đúng, bật nút Add to Cart");
                    btnAddToCart.disabled = false;
                } else {
                    console.log("❌ Điều kiện sai, tắt nút Add to Cart");
                    btnAddToCart.disabled = true;
                }
            }

            document.querySelectorAll(".btn-check").forEach(radio => {
                radio.addEventListener("change", function () {
                    let selectedAttributes = {};
                    document.querySelectorAll(".btn-check:checked").forEach(checkedRadio => {
                        let attributeName = checkedRadio.getAttribute("name");
                        let attributeValue = checkedRadio.value;
                        selectedAttributes[attributeName] = attributeValue;
                    });
                    handleAttributeSelection(selectedAttributes);
                });
            });

            btnPlus.addEventListener("click", function (event) {
                event.preventDefault();
                updateQuantity(1);
            });

            btnMinus.addEventListener("click", function (event) {
                event.preventDefault();
                updateQuantity(-1);
            });

            quantityInput.addEventListener("input", function () {
                let maxStock = parseInt(quantityInput.getAttribute("max")) || 10;
                let minStock = parseInt(quantityInput.getAttribute("min")) || 1;
                let currentValue = parseInt(quantityInput.value) || minStock;

                if (currentValue > maxStock) {
                    quantityInput.value = maxStock;
                    quantityError.innerText = `⚠️ Chỉ còn ${maxStock} sản phẩm trong kho!`;
                    quantityError.style.display = "block";
                } else if (currentValue < minStock) {
                    quantityInput.value = minStock;
                    quantityError.innerText = `⚠️ Số lượng tối thiểu là ${minStock}!`;
                    quantityError.style.display = "block";
                } else {
                    quantityError.style.display = "none";
                }
                validateAddToCart();
            });

            btnAddToCart.disabled = true;
            console.log("🔍 Dữ liệu productVariants ban đầu:", productVariants);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".wishlist-btn").forEach((button) => {
                button.addEventListener("click", function () {
                    let productId = this.getAttribute("data-product-id");
                    let icon = this.querySelector("i");

                    fetch(`/wishlist/toggle/${productId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ product_id: productId }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.status === "added") {
                                icon.classList.remove("far");
                                icon.classList.add("fas", "text-danger"); // Đổi màu đỏ
                            } else {
                                icon.classList.remove("fas", "text-danger");
                                icon.classList.add("far"); // Trở lại trái tim trống
                            }
                        });
                });
            });
        });
    </script>
@endsection
