@extends('app')
@section('css')
<style>
    .product-info-box {
    transition: all 0.2s ease-in-out;
    }
    .product-info-box:hover {
        box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.05);
    }


</style>
@endsection
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
                                <h2 class="name">{{ $product->name }}</h2>
                                <div class="price-rating">
                                    {{-- giá sản phẩm--}}
                                    <h3 class="theme-color price"><span class="text-primary fw-bold fs-4" id="product-price">{{ number_format($product->price, 0, ',', '.') }} vnđ</span>   
                                        <del class="text-content">
                                            @if($product->price_old && $product->price_old > $product->price)
                                                <span class="text-muted text-decoration-line-through fs-6">
                                                    {{ number_format($product->price_old, 0, ',', '.') }} đ
                                                </span>
                                            @endif</del>    

                                    <div class="product-rating custom-rate">
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
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span class="review">23 Customer Review</span>
                                    </div>
                                </div>
                                <!-- Mô tả ngắn -->
                                <div class="product-contain">
                                    <p>                                
                                        @if(!empty($product->short_description))
                                            <p class="text-muted fs-6 mb-0">
                                                {!! $product->short_description !!}
                                            </p>
                                        @endif
                                    </p>
                                </div>

                                {{-- biến thể sản phẩm  --}}

                                <div class="product-package">
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
                                </div>




                                <div class="note-box product-package">
                                    <form id="form-add-to-cart" action="{{route('cart.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <div class="note-box product-package">
                                            <div class="cart_qty qty-box product-qty">
                                                <div class="input-group">
                                                    <button type="button" class="qty-left-minus" data-type="minus"
                                                    data-field=""><i class="fa fa-minus"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="number"name="quantity" value="1" id="quantity-input">
                                                    <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
        
        
                                                </div>

        
                                            </div>
                                            <input type="hidden" name="sku" id="selected-sku-input" value="">
                                            <button id="btnAddToCart" class="btn btn-md bg-dark cart-button text-white w-100">Thêm Vào Giỏ Hàng</button>
                                        </div>
                                        <small id="quantity-error" class="text-danger" style="display: none;">⚠️ Số lượng không hợp lệ!</small>

                                    </form>
                                </div>

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

                                <a href="compare.html" class="d-flex align-items-center my-3">
                                    <i data-feather="eye" class="me-2"></i>
                                    <span>Lượt xem: {{ $product->view }}</span>
                                  </a>
                                  
                                <div class="pickup-box">
                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                            <li>Loại : <a href="javascript:void(0)">{{ $product->category->name}}</a></li>
                                            <li>Mã sản phẩm : <a href="javascript:void(0)">{{ $product->id}}</a></li>
                                            <li>Ngày đăng : <a href="javascript:void(0)">{{ $product->created_at->format('d/m/Y') }}</a></li>
                                            <li id="product-stock">
                                                Còn : <a href="javascript:void(0)" class="stock-value">{{ number_format($product->total_quantity) }} sản phẩm trong kho</a>
                                            </li>                                        
                                        </ul>
                                    </div>
                                </div>

                                <div class="payment-option">
                                    <div class="product-title">
                                        <h4>Đảm bảo thanh toán</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://vinadesign.vn/uploads/images/2023/05/vnpay-logo-vinadesign-25-12-57-55.jpg"
                                                alt="VNPay Logo" width="50" height="50">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                    <div class="right-sidebar-box">
                        <!-- Trending Product -->
                        <div class="pt-25">
                            <div class="category-menu">
                                <h3>Sản Phẩm mới nhất</h3>

                                <ul class="product-list product-right-sidebar border-0 p-0">
                                    {{-- <li>
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="../assets/images/vegetable/product/23.png"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Meatigo Premium Goat Curry</h6>
                                                    </a>
                                                    <span>450 G</span>
                                                    <h6 class="price theme-color">$ 70.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li> --}}
                                    @foreach($newProducts as $product)
                                    <li>
                                        <div class="offer-product">
                                            <a href="{{route('product.detail', $product->id)}}" class="offer-image">
                                                <img src="{{  Storage::url($product->firstImage->url) ?? asset('assets/images/default.png') }}"
                                                     class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                            </a>
                                            <div class="offer-detail">
                                                <div>
                                                    <a href="{{route('product.detail', $product->id)}}">
                                                        <h6 class="name">{{ $product->name }}</h6>
                                                    </a>
                                                    <span>{{ $product->weight ?? 'Đang cập nhật' }}</span>
                                                    <h6 class="price theme-color">{{ (int)$product->price, 2 }}vnđ</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                
                                    {{-- <li>
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="../assets/images/vegetable/product/24.png"
                                                    class="blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Dates Medjoul Premium Imported</h6>
                                                    </a>
                                                    <span>450 G</span>
                                                    <h6 class="price theme-color">$ 40.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="../assets/images/vegetable/product/25.png"
                                                    class="blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Good Life Walnut Kernels</h6>
                                                    </a>
                                                    <span>200 G</span>
                                                    <h6 class="price theme-color">$ 52.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="mb-0">
                                        <div class="offer-product">
                                            <a href="product-left-thumbnail.html" class="offer-image">
                                                <img src="../assets/images/vegetable/product/26.png"
                                                    class="blur-up lazyload" alt="">
                                            </a>

                                            <div class="offer-detail">
                                                <div>
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">Apple Red Premium Imported</h6>
                                                    </a>
                                                    <span>1 KG</span>
                                                    <h6 class="price theme-color">$ 80.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>

                        <!-- Banner Section -->
                        {{-- <div class="ratio_156 pt-25">
                            <div class="home-contain">
                                <img src="../assets/images/vegetable/banner/8.jpg" class="bg-img blur-up lazyload"
                                    alt="">
                                <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h6 class="text-yellow home-banner">Seafood</h6>
                                        <h3 class="text-uppercase fw-normal"><span
                                                class="theme-color fw-bold">Freshes</span> Products</h3>
                                        <h3 class="fw-light">every hour</h3>
                                        <button onclick="location.href = 'shop-left-sidebar.html';"
                                            class="btn btn-animation btn-md fw-bold mend-auto">Shop Now <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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
                                    <p>{!! $product->description !!}</p>
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
                        @foreach($relatedProducts as $product)

                        <div>
                                <div class="product-box-3 wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="product-header">
                                        <div class="product-image">
                                            @foreach($product->images as $image)

                                            <a href="{{route('product.detail', $product->id)}}">
                                                <img src="{{ Storage::url($image->url) }}"
                                                    class="img-fluid" alt="">
                                            </a>
                                            @endforeach

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
                                            <span class="span-name"> danh mục: {{ $product->category->name}}</span>

                                            <a href="product-left-thumbnail.html">
                                                <h5 class="name">{{ $product->name}}</h5>
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

                                            <h5 class="price"><span class="theme-color">{{(int)$product->price}}</span>
                                                <del>{{(int)$product->price_old}}</del>
                                            </h5>
                                            <div class="add-to-cart-box bg-white">
                                                <a href="{{route('product.detail', $product->id)}}">
                                                <button class="btn btn-add-cart addcart-button"> Xem Chi Tiết</button>
                                                </a>
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
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js-custom')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const skuFilter = document.getElementById('sku-filter');
    const reviewList = document.getElementById('review-list');
    const reviewItems = reviewList.getElementsByClassName('review-item');
    const noReviewsMessage = document.getElementById('no-reviews');

    const productVariants = {!! $resultJson !!};

    const errorMessage = document.getElementById("error-message");
    const priceElement = document.getElementById("product-price");
    const stockElement = document.getElementById("product-stock");
    const quantityInput = document.getElementById("quantity-input");
    const skuInput = document.getElementById("selected-sku-input");
    const btnAddToCart = document.getElementById("btnAddToCart");
    const btnPlus = document.querySelector(".qty-right-plus");
    const btnMinus = document.querySelector(".qty-left-minus");
    const quantityError = document.getElementById("quantity-error");
    

    skuFilter.addEventListener('change', function () {
        const selectedSku = this.value;
        let visibleCount = 0;
        Array.from(reviewItems).forEach(item => {
            const isVisible = !selectedSku || item.dataset.sku === selectedSku;
            item.style.display = isVisible ? 'block' : 'none';
            if (isVisible) visibleCount++;
        });
        noReviewsMessage.classList.toggle('d-none', visibleCount > 0);
    });

    function getSelectedAttrs() {
        const selectedAttrs = {};
        document.querySelectorAll(".btn-check:checked").forEach(radio => {
            selectedAttrs[radio.name] = radio.value;
        });
        return selectedAttrs;
    }

    function getAvailableAttributes() {
        const available = {};
        Object.values(productVariants).forEach(variant => {
            const values = variant.attributes.map(attr => attr.value);
            variant.attributes.forEach(attr => {
                available[attr.value] = available[attr.value] || new Set();
                values.forEach(v => v !== attr.value && available[attr.value].add(v));
            });
        });
        return available;
    }

    function showError(msg = "❌ Không có sản phẩm phù hợp!") {
        errorMessage.style.display = "block";
        errorMessage.innerHTML = msg;
        // priceElement.innerHTML = `<span class="text-danger">N/A</span>`;
        stockElement.innerHTML = `<span class="text-danger">Hết hàng</span>`;
        quantityInput.value = 0;
        quantityInput.setAttribute("max", 0);
        skuInput.value = "";
    }

    // Lấy ra list sku hết hàng
    const outOfStockSkus = Object.keys(productVariants).filter(sku => productVariants[sku].product_variant.stock == 0);

    function updateUI(selectedAttrs) {
        const availableAttrs = getAvailableAttributes();
        const selectedKeys = Object.keys(selectedAttrs);

        let hasEnabledOption = false;

        document.querySelectorAll(".btn-check").forEach(radio => {
            const attrValue = radio.value;
            const attrName = radio.name;
            const label = document.querySelector(`label[for="${radio.id}"]`);
            const sku = radio.getAttribute('data-sku');

            let isEnabled = true;

            if (outOfStockSkus.includes(sku)) {
                isEnabled = false;
            } else {
                selectedKeys.forEach(key => {
                    if (key !== attrName) {
                        const selectedValue = selectedAttrs[key];
                        if (!availableAttrs[selectedValue] || !availableAttrs[selectedValue].has(attrValue)) {
                            isEnabled = false;
                        }
                    }
                });
            }

            radio.disabled = !isEnabled;
            label.style.opacity = isEnabled ? "1" : "0.5";

            if (isEnabled) hasEnabledOption = true;
        });

        if (!hasEnabledOption) {
            showError();
        } else {
            errorMessage.style.display = "none";
        }
    }


    function updateProductInfo(selectedAttrs) {
        let matched = null;
        let totalStock = 0;

        console.log("Selected Attrs:", selectedAttrs);

        for (let sku in productVariants) {
            const variant = productVariants[sku];
            const isMatch = Object.keys(selectedAttrs).every(
                key => variant.attributes.some(attr => attr.value == selectedAttrs[key])
            );

            if (isMatch) {
                totalStock += variant.product_variant.stock;

                if (Object.keys(selectedAttrs).length === variant.attributes.length) {
                    matched = variant;
                }
            }
        }

        console.log("Matched Variant:", matched);
        console.log("Total Stock Of Matched Variants:", totalStock);

        if (!totalStock) {
            showError();
            return;
        }

        if (matched) {
            const { price, stock, sku } = matched.product_variant;

            if (priceElement) {
                priceElement.innerHTML = `${parseInt(price).toLocaleString()} vnđ`;
            }

            if (stockElement) {
                stockElement.innerHTML = `${stock} sản phẩm trong kho`;
            }

            skuInput.value = sku;
            quantityInput.setAttribute("max", stock);
            if (+quantityInput.value > stock) quantityInput.value = stock;
        } else {
            skuInput.value = "";
            quantityInput.setAttribute("max", totalStock);
            if (+quantityInput.value > totalStock) quantityInput.value = totalStock;

            if (stockElement) {
                stockElement.innerHTML = `${totalStock} sản phẩm trong kho`;
            }

            if (priceElement) {
                priceElement.innerHTML = `<span class="text-muted">Vui lòng chọn đủ thuộc tính để xem giá</span>`;
            }
        }


        errorMessage.style.display = "none";
        validateAddToCart();
    }



    function validateAddToCart() {
        const selectedAttrs = getSelectedAttrs();
        const requiredAttrCount = productVariants[Object.keys(productVariants)[0]].attributes.length;
        const qty = parseInt(quantityInput.value);
        const errors = [];

        // Check đã chọn đủ thuộc tính chưa
        if (Object.keys(selectedAttrs).length < requiredAttrCount) {
            errors.push("⚠️ Vui lòng chọn đầy đủ thuộc tính.");
        } else {
            let matchedVariant = null;

            // Tìm variant đúng với selectedAttrs
            for (let sku in productVariants) {
                const variant = productVariants[sku];
                const isMatch = Object.keys(selectedAttrs).every(key =>
                    variant.attributes.some(attr => attr.value == selectedAttrs[key])
                );

                if (isMatch && variant.attributes.length === requiredAttrCount) {
                    matchedVariant = variant;
                    break;
                }
            }

            if (!matchedVariant) {
                errors.push("⚠️ Không tìm thấy biến thể phù hợp.");
            } else {
                const stock = matchedVariant.product_variant.stock;

                if (stock <= 0) {
                    errors.push("⚠️ Biến thể này đã hết hàng.");
                }

                if (!qty || qty <= 0) {
                    errors.push("⚠️ Số lượng không hợp lệ.");
                }

                if (qty > stock) {
                    errors.push(`⚠️ Chỉ còn ${stock} sản phẩm trong kho.`);
                }
            }
        }

        if (errors.length) {
            errorMessage.style.display = "block";
            errorMessage.innerHTML = errors.join("<br>");
            return false;
        }

        errorMessage.style.display = "none";
        return true;
    }



    function updateQuantity(delta) {
        const max = parseInt(quantityInput.getAttribute("max")) || 10;
        const min = parseInt(quantityInput.getAttribute("min")) || 1;
        let val = parseInt(quantityInput.value) || min;
        quantityInput.value = Math.min(Math.max(val + delta, min), max);
        validateAddToCart();
    }

    document.querySelectorAll(".btn-check").forEach(radio => {
        radio.addEventListener("change", () => {
            const selectedAttrs = getSelectedAttrs();
            updateUI(selectedAttrs);
            updateProductInfo(selectedAttrs);
        });
    });

    // btnPlus.addEventListener("click", e => {
    //     e.preventDefault();
    //     updateQuantity(1);
    // });

    // btnMinus.addEventListener("click", e => {
    //     e.preventDefault();
    //     updateQuantity(-1);
    // });

    // quantityInput.addEventListener("input", () => {
    //     const max = parseInt(quantityInput.getAttribute("max")) || 10;
    //     const min = parseInt(quantityInput.getAttribute("min")) || 1;
    //     let val = parseInt(quantityInput.value) || min;

    //     if (val > max) {
    //         quantityInput.value = max;
    //         quantityError.innerText = `⚠️ Chỉ còn ${max} sản phẩm trong kho!`;
    //         quantityError.style.display = "block";
    //     } else if (val < min) {
    //         quantityInput.value = min;
    //         quantityError.innerText = `⚠️ Số lượng tối thiểu là ${min}!`;
    //         quantityError.style.display = "block";
    //     } else {
    //         quantityError.style.display = "none";
    //     }

    //     validateAddToCart();
    // });
        btnPlus.addEventListener("click", e => {
            e.preventDefault();
            changeQuantity(1);
        });

        btnMinus.addEventListener("click", e => {
            e.preventDefault();
            changeQuantity(-1);
        });

        quantityInput.addEventListener("input", () => {
            checkQuantity();
        });

        function changeQuantity(amount) {
            const max = parseInt(quantityInput.getAttribute("max")) || 10;
            const min = parseInt(quantityInput.getAttribute("min")) || 1;
            let val = parseInt(quantityInput.value) || min;

            val += amount;

            if (val > max) val = max;
            if (val < min) val = min;

            quantityInput.value = val;

            checkQuantity();
        }

        function checkQuantity() {
            const max = parseInt(quantityInput.getAttribute("max")) || 10;
            const min = parseInt(quantityInput.getAttribute("min")) || 1;
            let val = parseInt(quantityInput.value) || min;

            if (val > max) {
                quantityInput.value = max;
                quantityError.innerText = `⚠️ Chỉ còn ${max} sản phẩm trong kho!`;
                quantityError.style.display = "block";
            } else if (val < min) {
                quantityInput.value = min;
                quantityError.innerText = `⚠️ Số lượng tối thiểu là ${min}!`;
                quantityError.style.display = "block";
            } else {
                quantityError.style.display = "none";
            }

            validateAddToCart(); // check nút add to cart
        }

        const formAddToCart = document.getElementById("form-add-to-cart");

        btnAddToCart.addEventListener("click", function(e) {
            e.preventDefault();

            if (validateAddToCart()) {
                if (formAddToCart) {
                    formAddToCart.submit();
                } else {
                    console.log('Không tìm thấy form-add-to-cart');
                }
            }
        });


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
