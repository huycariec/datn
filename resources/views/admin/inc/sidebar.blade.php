<!-- Page Body Start-->
<div class="page-body-wrapper">
    <!-- Page Sidebar Start-->
    <div class="sidebar-wrapper">
        <div id="sidebarEffect"></div>
        <div>
            <div class="logo-wrapper logo-wrapper-center">
                <a href="index.html" data-bs-original-title="" title="">
                    <img class="img-fluid for-white" src="/assets/images/logo/full-white.png" alt="logo">
                </a>
                <div class="back-btn">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div class="toggle-sidebar">
                    <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
                </div>
            </div>
            <div class="logo-icon-wrapper">
                <a href="index.html">
                    <img class="img-fluid main-logo main-white" src="/assets/images/logo/logo.png" alt="logo">
                    <img class="img-fluid main-logo main-dark" src="/assets/images/logo/logo-white.png"
                         alt="logo">
                </a>
            </div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow">
                    <i data-feather="arrow-left"></i>
                </div>

                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn"></li>

                        @can('dashboard')
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                                    <i class="ri-home-line"></i>
                                    <span>Bảng điều khiển</span>
                                </a>
                            </li>
                        @endcan
                        @canany(['orders_list'])
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('orders.index') }}">
                                <i class="ri-archive-line"></i>
                                <span>Đơn hàng</span>
                            </a>
                        </li>
                        @endcanany

                        @canany(['products_list', 'products_create'])
                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                                <i class="ri-store-3-line"></i>
                                <span>Sản phẩm</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('products_list')
                                    <li>
                                        <a href="{{route('admin.product.index')}}">Danh sách sản phẩm</a>
                                    </li>
                                @endcan
                                @can('products_create')
                                <li>
                                    <a href="{{route('admin.product.create')}}">Thêm mới sản phẩm</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @canany(['categories_list', 'categories_create'])
                            <li class="sidebar-list">
                                <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                                    <i class="ri-list-check-2"></i>
                                    <span>Danh mục</span>
                                </a>
                                <ul class="sidebar-submenu">
                                    @can('categories_list')
                                        <li>
                                            <a href="{{route('categories.index')}}">Danh sách</a>
                                        </li>
                                    @endcan
                                    @can('categories_create')
                                        <li>
                                            <a href="{{route('categories.create')}}">Thêm mới danh mục</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        @canany(['attributes_list', 'attributes_create'])
                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                                <i class="ri-list-settings-line"></i>
                                <span>Thuộc tính sản phẩm</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('attributes_list')
                                    <li>
                                        <a href="{{route('admin.attribute.index')}}">Thuộc tính sản phẩm</a>
                                    </li>
                                @endcan
                                @can('attributes_create')
                                <li>
                                    <a href="{{route('admin.attribute.create')}}">Thêm thuộc tính sản phẩm</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @canany(['users_list'])
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <i class="ri-user-3-line"></i>
                                <span>Người dùng</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{route('admin.user.index', 'role=user')}}">Danh sách khách hàng</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.user.index', 'role=admin')}}">Danh sách quản trị viên</a>
                                </li>
                            </ul>
                        </li>
                        @endcanany

                        @canany(['roles_list', 'roles_create'])
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <i class="ri-user-3-line"></i>
                                <span>Vai trò</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('roles_list')
                                    <li>
                                        <a href="{{ route('roles.index') }}">Danh sách</a>
                                    </li>
                                @endcan
                                @can('roles_create')
                                <li>
                                    <a href="{{ route('roles.create') }}">Tạo mới</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @canany(['posts_list', 'posts_create'])
                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                                <i class="ri-article-line"></i>
                                <span>Bài viết</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('posts_list')
                                <li>
                                    <a href="{{ route("admin.blogs.index") }}">Danh sách bài viết</a>
                                </li>
                                @endcan
                                @can('posts_create')
                                <li>
                                    <a href="{{ route("admin.blogs.create") }}">Thêm bài viết</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @canany(['coupons_list', 'coupons_create'])
                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                                <i class="ri-price-tag-3-line"></i>
                                <span>Mã giảm giá</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('coupons_list')
                                    <li>
                                        <a href="{{ route("discounts.index") }}">Danh sách</a>
                                    </li>
                                @endcan
                                @can('coupons_create')
                                <li>
                                    <a href="{{ route("discounts.create") }}">Phát hành mã</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        @canany(['reviews_list'])
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{route('reviews.index')}}">
                                <i class="ri-star-line"></i>
                                <span>Đánh giá</span>
                            </a>
                        </li>
                        @endcanany

                        @canany(['banners_list', 'pages_list'])
                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                                <i class="ri-settings-line"></i>
                                <span>Cài đặt</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @can('banners_list')
                                    <li>
                                        <a href="{{ route('banners.index') }}">Cài đặt banner</a>
                                    </li>
                                @endcan
                                @can('pages_list')
                                <li>
                                    <a href="{{ route('pages.index') }}">Quản lý trang</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany
                    </ul>
                </div>

                <div class="right-arrow" id="right-arrow">
                    <i data-feather="arrow-right"></i>
                </div>
            </nav>
        </div>
    </div>

    <!-- Page Sidebar Ends-->
