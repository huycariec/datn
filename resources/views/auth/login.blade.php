@extends('app')

@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-3 pb-3 bg-light text-center">
    <div class="container">
        <h2 class="fw-bold">Đăng nhập</h2>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Login Section Start -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Form đăng nhập -->
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Chào mừng trở lại LINGOAN</h3>
                        <p class="text-muted">Vui lòng đăng nhập để tiếp tục</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" placeholder="Nhập email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Mật khẩu</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Nhập mật khẩu" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                            <a href="" class="text-primary">Quên mật khẩu?</a>
                        </div>

                        <button class="btn btn-primary w-100 fw-bold py-2">Đăng nhập</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Bạn chưa có tài khoản? 
                            <a href="{{ route('register') }}" class="text-primary fw-bold">Đăng ký ngay</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->

@endsection
