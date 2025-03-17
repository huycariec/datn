@extends('app')
@section('content')

    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>Bạn không có quyền truy cập trang này</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">
                                        <i class="fa-solid fa-house"></i> Trang chủ
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">403 - Forbidden</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- 403 Forbidden Section Start -->
    <section class="section-404 section-lg-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="image-404">
                        <img src="../public/assets/images/inner-page/403.png" class="img-fluid blur-up lazyload" alt="403 Forbidden">
                    </div>
                </div>

                <div class="col-12">
                    <div class="contain-404">
                        <h3 class="text-content">Bạn không có quyền truy cập vào trang này. Vui lòng liên hệ với quản trị viên.</h3>
                        <button onclick="location.href = '{{ route('home') }}';" 
                                class="btn btn-md text-white theme-bg-color mt-4 mx-auto">
                            Quay lại trang chủ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 403 Forbidden Section End -->
@endsection
