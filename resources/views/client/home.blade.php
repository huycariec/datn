@extends('app')
@section('content')
    <div class="mobile-menu d-md-none d-block mobile-cart">
        <ul>
            <li class="active">
                <a href="index.html">
                    <i class="iconly-Home icli"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="mobile-category">
                <a href="javascript:void(0)">
                    <i class="iconly-Category icli js-link"></i>
                    <span>Category</span>
                </a>
            </li>

            <li>
                <a href="search.html" class="search-box">
                    <i class="iconly-Search icli"></i>
                    <span>Search</span>
                </a>
            </li>

            <li>
                <a href="wishlist.html" class="notifi-wishlist">
                    <i class="iconly-Heart icli"></i>
                    <span>My Wish</span>
                </a>
            </li>

            <li>
                <a href="cart.html">
                    <i class="iconly-Bag-2 icli fly-cate"></i>
                    <span>Cart</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- mobile fix menu end -->

    <!-- Home Section Start -->
    <section class="home-section-2 home-section-bg pt-0 overflow-hidden">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="slider-animate">
                        <div>
                            {{-- danh mục sản phẩm --}}
                            <div class="home-contain rounded-0 p-0">
                                <img
                                    src="{{ isset($banners[1]->image) ? \Illuminate\Support\Facades\Storage::url($banners[1]->image) : "../assets/client/assets/images/fashion/home-banner/1.jpg" }}"
                                    class="img-fluid bg-img blur-up lazyload" alt="">
                                <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                                    <div class="container-fluid-lg">
                                        <div>
                                            <h6 class="ls-expanded text-uppercase text-danger">Chủ nhật siêu giảm giá
                                            </h6>
                                            <h1 class="heding-2">Chất lượng đỉnh cao</h1>
                                            <h5 class="text-content">Sản phẩm tốt giá rẻ nhất thị trường!
                                            </h5>
                                            @isset($banners[1]->link)
                                                <a href="{{$banners[1]->link}}" target="_blank"
                                                   class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto">Mua
                                                    ngay <i
                                                        class="fa-solid fa-arrow-right icon"></i></a>
                                            @endisset
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
    <!-- Home Section End -->

    <!-- Category Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="slider-9">
                        @foreach($categories as $index => $category)
                            <a href="{{ route('products.byCategory', $category->id) }}"
                               class="category-box category-dark wow fadeInUp"
                               data-wow-delay="{{ ($index * 0.05) }}s"
                               tabindex="0">
                                <div>
                                    <img src="{{ isset($category->image) && file_exists(storage_path('app/public/' . $category->image)) ? asset('storage/' . $category->image) : '/assets/images/placeholder_image.webp' }}"
                                         class="blur-up lazyload img-fluid rounded shadow-sm"
                                         alt="{{ $category->name }}"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                    <h5>{{ $category->name }}</h5>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section End -->
    <!-- Products Section Start -->
    <section class="product-section product-section-3">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Siêu ưu đãi hôm nay</h2>
            </div>
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-12 ratio_110">
                    <div class="slider-6 img-slider">
                        @foreach($discountProducts as $product)
                        <div>
                            <div class="product-box-5 wow fadeInUp">
                                <div class="product-image">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        @if ($product->images->count())
                                            <img src="{{ Storage::url($product->images->first()->url) }}"
                                                 class="img-fluid blur-up lazyload bg-img" alt="{{ $product->name }}">
                                        @endif
                                    </a>

                                    <a href="javascript:void(0)" class="wishlist-top" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Wishlist">
                                        <i data-feather="bookmark"></i>
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="{{ route('product.detail', $product->id) }}">
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

                                <div class="product-detail">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <h5 class="name">{{ $product->name }}</h5>
                                    </a>

                                    <h5 class="sold text-content d-flex flex-column text-center">
                                        @if(!empty($product->price_old) && $product->price_old > 0 && $product->price_old > $product->price)
                                            <span class="old-price text-danger text-decoration-line-through mb-1">
                                                giá gốc: {{ number_format($product->price_old, 0, ',', '.') }} đ
                                            </span>
                                        @endif


                                        <span class="theme-color price fw-bold fs-5">
                                            giá siêu ưu đãi: {{ number_format($product->price, 0, ',', '.') }} đ
                                        </span>
                                    </h5>
                                    <span>danh mục: {{ $product->category->name }}</span>

                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row g-md-4 g-3">
                <div class="col-xxl-8 col-xl-12 col-md-7">
                    <div class="banner-contain hover-effect">
                        <img
                            src="{{ isset($banners[2]->image) ? \Illuminate\Support\Facades\Storage::url($banners[2]->image) : "../assets/client/assets/images/fashion/banner/1.jpg"}}"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="banner-details p-center-left p-4">
                            <div>
                                <h2 class="text-kaushan fw-normal theme-color">Hãy sẵn sàng để</h2>
                                <h3 class="mt-2 mb-3">TIẾP TỤC NGÀY HÔM NAY!</h3>
                                <p class="text-content banner-text">Siêu sale, giảm giá</p>
                                @isset($banners[2]->link)
                                    <a href="{{$banners[2]->link}}" target="_blank"
                                       class="btn btn-animation btn-sm mend-auto">Mua ngay <i
                                            class="fa-solid fa-arrow-right icon"></i></a>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12 col-md-5">
                    <a href="shop-left-sidebar.html" class="banner-contain hover-effect h-100">
                        <img
                            src="{{ isset($banners['3']->image) ? \Illuminate\Support\Facades\Storage::url($banners['3']->image) : "../assets/client/assets/images/fashion/banner/2.jpg"}}"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="banner-details p-center-left p-4 h-100">
                            <div>
                                <h2 class="text-kaushan fw-normal text-danger">20% Off</h2>
                                <h3 class="mt-2 mb-2 theme-color">SUMMRY</h3>
                                <h3 class="fw-normal product-name text-title">Product</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section end -->


    <!-- Top Selling Section Start -->
    <section class="top-selling-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 col-lg-4 d-lg-block d-none">
                    <div class="ratio_156">
                        <div class="banner-contain-2 hover-effect">
                            <img src="../assets/client/assets/images/fashion/banner/3.jpg"
                                 class="bg-img blur-up lazyload" alt="">
                            <div class="banner-detail-2 p-bottom-center text-center home-p-medium">
                                <div>
                                    <h2 class="text-qwitcher">Passion Meet</h2>
                                    <h3>PERFECTION</h3>
                                    <button onclick="location.href = 'shop-left-sidebar.html';" class="btn btn-md">Shop
                                        Now <i class="fa-solid fa-arrow-right icon"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <div class="slider-3_3 product-wrapper">
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-selling-box">
                                        <div class="top-selling-title">
                                            <h3>Bán chạy nhất</h3>
                                        </div>

                                       @foreach($topProducts->take(4) as $product)
                                           <div class="top-selling-contain wow fadeInUp">
                                               <a href="{{ route('product.detail', $product->id) }}" class="top-selling-image">
                                                   @if($product->images->first())
                                                       <img src="{{ Storage::url($product->images->first()->url) }}"
                                                            class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                                   @else
                                                       <img src="{{ asset('path/to/default.jpg') }}"
                                                            class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                                   @endif
                                               </a>

                                               <div class="top-selling-detail">
                                                   <a href="{{ route('product.detail', $product->id) }}">
                                                       <h5>{{ $product->name }}</h5>
                                                   </a>
                                                   <div class="product-rating">
                                                       <ul class="rating">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i data-feather="star" class="{{ $i <= floor($product->average_rating) ? 'fill' : '' }}"></i>
                                                                </li>
                                                            @endfor
                                                       </ul>
                                                       <span>({{ number_format($product->average_rating, 1) }})</span>
                                                   </div>

                                                   <h6>{{ number_format($product->price, 0, ',', '.') }} đ</h6>
                                               </div>
                                           </div>
                                       @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-selling-box">
                                        <div class="top-selling-title">
                                            <h3>Lượt Xem Nhiều Nhất</h3>
                                        </div>
                                        {{--lấy ra 4 sản phẩm đổ vào vị trí này, foreach div.top-selling-contain --}}
                                        @foreach($mostViewedProducts->take(4) as $product)
                                            <div class="top-selling-contain wow fadeInUp">
                                                <a href="{{ route('product.detail', $product->id) }}" class="top-selling-image">
                                                    @if($product->images->first())
                                                        <img src="{{ Storage::url($product->images->first()->url) }}"
                                                             class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                                    @else
                                                        <img src="{{ asset('path/to/default.jpg') }}"
                                                             class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                                    @endif
                                                </a>

                                                <div class="top-selling-detail">
                                                    <a href="{{ route('product.detail', $product->id) }}">
                                                        <h5>{{ $product->name }}</h5>
                                                    </a>

                                                    <div class="product-rating">
                                                        <ul class="rating">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i data-feather="star" class="{{ $i <= floor($product->average_rating) ? 'fill' : '' }}"></i>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                        <span>({{ number_format($product->average_rating, 1) }})</span>
                                                    </div>

                                                    <h6>{{ number_format($product->price, 0, ',', '.') }} đ</h6>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-selling-box">
                                        <div class="top-selling-title">
                                            <h3>Thêm mới nhất</h3>
                                        </div>

                                        {{--lấy ra 4 sản phẩm đổ vào vị trí này, foreach div.top-selling-contain --}}

                                        @foreach($newProducts->take(4) as $product)
                                            <div class="top-selling-contain wow fadeInUp">
                                                <a href="{{ route('product.detail', $product->id) }}" class="top-selling-image">
                                                    @if($product->images->first())
                                                        <img src="{{ Storage::url($product->images->first()->url) }}"
                                                             class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                                    @else
                                                        <img src="{{ asset('path/to/default.jpg') }}"
                                                             class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                                    @endif
                                                </a>

                                                <div class="top-selling-detail">
                                                    <a href="{{ route('product.detail', $product->id) }}">
                                                        <h5>{{ $product->name }}</h5>
                                                    </a>

                                                    <div class="product-rating">
                                                        <ul class="rating">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i data-feather="star" class="{{ $i <= floor($product->average_rating) ? 'fill' : '' }}"></i>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                        <span>({{ number_format($product->average_rating, 1) }})</span>
 
                                                    </div>

                                                    <h6>{{ number_format($product->price, 0, ',', '.') }} đ</h6>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Top Selling Section End -->


    <!-- banner section start -->
    <section class="section-t-space">
        <div class="container-fluid-lg">
            <div class="banner-contain">
                <img src="../assets/client/assets/images/fashion/banner/4.jpg" class="bg-img blur-up lazyload" alt="">
                <div class="banner-details p-center p-4 text-white text-center">
                    <div>
                        <h3 class="lh-base fw-bold offer-text">Nhanh tay nhập là nhận ngay mã giảm giá chất !</h3>\
                        <h6 class="coupon-code coupon-code-white">Mã: </h6>
                        {{--                        foreach mã giảm giá ra đây, cho chạy carousel--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section start -->


    <!-- Deal Section Start -->
    <section class="product-section product-section-3">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Sản phẩm mới nhất</h2>
            </div>
            <div class="row g-sm-4 g-3 section-b-space">
                <div class="col-xxl-12 ratio_110">
                    <div class="slider-6 img-slider">
                        @foreach($newProducts as $newProduct)
                            <div>
                                <div class="product-box-5 wow fadeInUp">
                                    <div class="product-image">
                                    @foreach ($newProduct->images as $image)
                                        <a href="{{route('product.detail',$newProduct->id)}}">
                                            <img src="{{Storage::url($image->url)}}"
                                                class="img-fluid blur-up lazyload bg-img" alt="{{$newProduct->name}}">
                                        </a>
                                    @endforeach
                                        <a href="javascript:void(0)" class="wishlist-top" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Wishlist">
                                            <i data-feather="bookmark"></i>
                                        </a>

                                        <ul class="product-option">
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
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

                                    <div class="product-detail">
                                        <a href="{{ route('product.detail', $product->id) }}">
                                            <h5 class="name">{{ $product->name }}</h5>
                                        </a>
    
                                        <h5 class="sold text-content d-flex flex-column text-center">
                                            @if(!empty($product->price_old) && $product->price_old > 0 && $product->price_old > $product->price)
                                                <span class="old-price text-danger text-decoration-line-through mb-1">
                                                    giá gốc: {{ number_format($product->price_old, 0, ',', '.') }} đ
                                                </span>
                                            @endif
    
    
                                            <span class="theme-color price fw-bold fs-5">
                                                giá sản phẩm: {{ number_format($product->price, 0, ',', '.') }} đ
                                            </span>
                                        </h5>
                                        <span>danh mục: {{ $product->category->name }}</span>
    
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Deal Section End -->

    <!-- Deal Section Start -->
    <section class="product-section product-section-3 mb-5">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Sản phẩm bán chạy nhất</h2>
            </div>
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-12 ratio_110">
                    <div class="slider-6 img-slider">
                       @foreach($topProducts as $product)
                       <div>
                           <div class="product-box-5 wow fadeInUp">
                               <div class="product-image">
                                   @foreach ($product->images as $image)
                                   <a href="{{ route('product.detail', $product->id) }}">
                                       <img src="{{Storage::url($image->url)}}"
                                            class="img-fluid blur-up lazyload bg-img" alt="{{ $product->name }}">
                                   </a>
                                   @endforeach

                                   <a href="javascript:void(0)" class="wishlist-top" data-bs-toggle="tooltip"
                                      data-bs-placement="top" title="Wishlist">
                                       <i data-feather="bookmark"></i>
                                   </a>

                                   <ul class="product-option">
                                       <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                           <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
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

                                <div class="product-detail">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <h5 class="name">{{ $product->name }}</h5>
                                    </a>

                                    <h5 class="sold text-content d-flex flex-column text-center">
                                        @if(!empty($product->price_old) && $product->price_old > 0 && $product->price_old > $product->price)
                                            <span class="old-price text-danger text-decoration-line-through mb-1">
                                                giá gốc: {{ number_format($product->price_old, 0, ',', '.') }} đ
                                            </span>
                                        @endif


                                        <span class="theme-color price fw-bold fs-5">
                                            giá siêu ưu đãi: {{ number_format($product->price, 0, ',', '.') }} đ
                                        </span>
                                    </h5>
                                    <span>danh mục: {{ $product->category->name }}</span>

                                </div>
                           </div>
                       </div>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Deal Section End -->

    <!-- Newsletter Section Start -->
       {{-- <section class="newsletter-section section-b-space">
           <div class="container-fluid-lg">
               <div class="newsletter-box newsletter-box-2">
                   <div class="newsletter-contain py-5">
                       <div class="container-fluid">
                           <div class="row">
                               <div class="col-xxl-4 col-lg-5 col-md-7 col-sm-9 offset-xxl-2 offset-md-1">
                                   <div class="newsletter-detail">
                                       <h2>Join our newsletter and get...</h2>
                                       <h5>$20 discount for your first order</h5>
                                       <div class="input-box">
                                           <input type="email" class="form-control" id="exampleFormControlInput1"
                                                  placeholder="Enter Your Email">
                                           <i class="fa-solid fa-envelope arrow"></i>
                                           <button class="sub-btn  btn-animation">
                                               <span class="d-sm-block d-none">Subscribe</span>
                                               <i class="fa-solid fa-arrow-right icon"></i>
                                           </button>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </section> --}}
    <!-- Newsletter Section End -->
@endsection
