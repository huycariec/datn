<style>
    .nav-link.dropdown-toggle::before {
        display: none;
    }
</style>
<!-- Loader Start -->
<div class="fullpage-loader">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>
<!-- Loader End -->

<!-- Header Start -->
<header class="">
    <div class="header-top">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 d-xxl-block d-none">
                    <div class="top-left-header">
                        <i class="iconly-Location icli text-white"></i>
                        <span class="text-white">39 Hồ Tùng Mậu, Mai Dịch, Cầu Giấy, Hà Nội</span>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                    <div class="header-offer">
                        <div class="notification-slider">

                            <div>
                                <div class="timer-notification">
                                    <h6><strong class="me-1">LINGOAN xin chào bạn!</strong>Đến với chúng tôi để nhận ưu
                                        đãi
                                        <strong class="ms-1"> Cảm ơn vì đã tin dùng!
                                        </strong>

                                    </h6>
                                </div>
                            </div>

                            <div>
                                <div class="timer-notification">
                                    <h6>Có thể bạn sẽ hài lòng với các sản phẩm của chúng mình
                                        <a href="shop-left-sidebar.html" class="text-white">Mua ngay!!
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <ul class="about-list right-nav-about">
                        <li class="right-nav-list">
                            <div class="dropdown theme-form-select">
                                <button class="btn dropdown-toggle" type="button" id="select-language"
                                        data-bs-toggle="dropdown">
                                    <img src="../assets/images/country/united-states.png"
                                         class="img-fluid blur-up lazyload" alt="">
                                    <span>English</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="english">
                                            <img src="../assets/images/country/united-kingdom.png"
                                                 class="img-fluid blur-up lazyload" alt="">
                                            <span>English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="france">
                                            <img src="../assets/images/country/germany.png"
                                                 class="img-fluid blur-up lazyload" alt="">
                                            <span>Germany</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="chinese">
                                            <img src="../assets/images/country/turkish.png"
                                                 class="img-fluid blur-up lazyload" alt="">
                                            <span>Turki</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="right-nav-list">
                            <div class="dropdown theme-form-select">
                                <button class="btn dropdown-toggle" type="button" id="select-dollar"
                                        data-bs-toggle="dropdown">
                                    <span>USD</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end sm-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" id="aud" href="javascript:void(0)">AUD</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="eur" href="javascript:void(0)">EUR</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="cny" href="javascript:void(0)">CNY</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="top-nav top-header sticky-header">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="navbar-top">
                        <h1>LINGOAN</h1>
                        <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon">
                                    <i class="fa-solid fa-bars"></i>
                                </span>
                        </button>
                        <a href="index.html" class="web-logo nav-logo">
                            <img src="../assets/images/logo/6.png" class="img-fluid blur-up lazyload"
                                 alt="">
                        </a>


                        <div class="header-nav-middle">

                            {{-- SEARCH FORM --}}
                            <div class="d-flex justify-content-center mt-4 mb-4">
                                <form action="{{ route('product.search') }}" method="GET" class="d-flex w-75">
                                    @csrf
                                    <input class="form-control me-2" type="search" name="keyword" placeholder="Nhập tên, mô tả, danh mục..."
                                           value="{{ request('keyword') }}" required>

                                    <select name="sort" class="form-select me-2" style="max-width:150px;">
                                        <option value="">Sắp xếp</option>
                                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    </select>

                                    <button class="btn btn-danger" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                                <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                    <div class="offcanvas-header navbar-shadow">
                                        <h5>Menu</h5>
                                        <button class="btn-close lead" type="button"
                                                data-bs-dismiss="offcanvas"></button>
                                    </div>

                                    <div class="offcanvas-body">
                                        <ul class="navbar-nav">
                                            <li class="nav-item dropdown dropdown-mega">
                                                <a class="nav-link dropdown-toggle ps-xl-2 ps-0"
                                                   href="{{ route('home') }}">Trang chủ</a>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                   data-bs-toggle="dropdown">Danh mục</a>
                                                    <ul class="dropdown-menu">
                                                        @forelse($categoriesView as $category)
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('products.byCategory', $category) }}">{{ $category->name }}</a>
                                                        </li>
                                                        @empty

                                                        @endforelse
                                                    </ul>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                   data-bs-toggle="dropdown">Tin tức</a>

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="#">Bài viết</a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                   data-bs-toggle="dropdown">Chính sách</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{route('policy_buy')}}">Chính
                                                            sách mua hàng</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{route('policy_return.blade.php')}}">Chính sách đổi
                                                            trả</a>
                                                    </li>

                                                </ul>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                   data-bs-toggle="dropdown">Khác</a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('introduction') }}">Giới
                                                            thiệu</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('instruct') }}">Hướng
                                                            dẫn mua hàng</a>
                                                    </li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rightside-box">
                            <div class="search-full">
                                <div class="input-group">
                                        <span class="input-group-text">
                                            <i data-feather="search" class="font-light"></i>
                                        </span>
                                    <input type="text" class="form-control search-type"
                                           placeholder="Search here..">
                                    <span class="input-group-text close-search">
                                            <i data-feather="x" class="font-light"></i>
                                        </span>
                                </div>
                            </div>
                            <ul class="right-side-menu">
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <i data-feather="search"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="right-side">
                                        <a href="{{ route('wishlist.index') }}" class="btn p-0 position-relative header-wishlist">
                                            <i data-feather="bookmark"></i>
                                        </a>
                                    </li>
                                    <li class="right-side">
                                        <div class="onhover-dropdown header-badge">
                                            <!-- Nút giỏ hàng -->
                                            <button type="button" class="btn p-0 position-relative header-wishlist">
                                                <i data-feather="shopping-cart"></i>
                                                <span class="position-absolute top-0 start-100 translate-middle badge">
                                                    {{ $cart_quantity ?? 0 }}
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </button>

                                            <!-- Dropdown giỏ hàng -->
                                            <div class="onhover-div">
                                                <ul class="cart-list">
                                                    @forelse ($cart_items as $item)
                                                        <li class="product-box-contain">
                                                            <div class="drop-cart">
                                                                <a href="#" class="drop-image">
                                                                    <img src="{{ Storage::url($item['product_image']) }}" class="blur-up lazyload" alt="{{ $item['product_name'] }}">
                                                                </a>

                                                                <div class="drop-contain">
                                                                    <a href="#">
                                                                        <h5>{{ $item['product_name'] }}</h5>
                                                                    </a>
                                                                    <h6><span>{{ $item['quantity'] }} x</span> {{ number_format($item['variant_price'], 0, ',', '.') }}₫</h6>
                                                                    {{-- <button class="close-button close_button">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </button> --}}
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <li class="text-center p-3">Giỏ hàng trống</li>
                                                    @endforelse
                                                </ul>

                                                <!-- Tổng giá tiền -->
                                                <div class="price-box">
                                                    <h5>tổng tiền :</h5>
                                                    <h4 class="theme-color fw-bold">
                                                        {{ number_format($cart_items->sum(fn($item) => $item['variant_price'] * $item['quantity']), 0, ',', '.') }}₫
                                                    </h4>
                                                </div>

                                                <!-- Nút hành động -->
                                                <div class="button-group">
                                                    <a href="{{route('cart.index')}}" class="btn btn-sm cart-button">xem giỏ hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="right-side onhover-dropdown">
                                        <div class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <i data-feather="user"></i>
                                            </div>

                                            <div class="delivery-detail">
                                                @if (Auth::check())
                                                    <h6>Xin chào, {{ Auth::user()->name }}</h6>
                                                @else
                                                    <h5>Tài khoản</h5>
                                                @endif
                                            </div>
                                        </div>


                                    <div class="onhover-div onhover-div-login">
                                        <ul class="user-box-name">
                                            @if (Auth::check())
                                                <li class="product-box-contain">
                                                    <i></i>
                                                    <a href="{{ route('client.profile') }}">Thông tin cá nhân
                                                    </a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <i></i>
                                                    <a href="{{ route('order') }}">Đơn hàng của tôi
                                                    </a>
                                                </li>
                                                @if(auth()->user()->role == 'admin')
                                                    <li class="product-box-contain">
                                                        <a href="{{ route('admin.dashboard') }}">Trang quản trị
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="product-box-contain">
                                                    <i></i>
                                                    <a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng
                                                        xuất</a>
                                                </li>
                                                <form id="logout-form" action="{{ route('logout') }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            @else

                                                <li class="product-box-contain">
                                                    <i></i>
                                                    <a href="{{ route('login') }}">Đăng nhập</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('register') }}">Đăng ký</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="forgot.html">Quên mật khẩu</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->
@if (session('message'))
    <div class="alert alert-success" id="success-message">
        {{ session('message') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" id="error-message">
        {{ session('error') }}
    </div>
@endif
