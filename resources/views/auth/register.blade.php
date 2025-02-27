@extends('app')
@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-3 pb-3 bg-light text-center">
    <div class="container">
        <h2 class="fw-bold">Đăng ký tài khoản</h2>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Registration Section Start -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Form đăng ký -->
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Chào mừng bạn đến với LINGOAN</h3>
                        <p class="text-muted">Hãy tạo tài khoản để bắt đầu mua sắm ngay!</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Họ và Tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" placeholder="Nhập họ tên" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Tôi đồng ý với <a href="#" class="text-primary">Điều khoản</a> & <a href="#" class="text-primary">Chính sách bảo mật</a>
                            </label>
                        </div>

                        <button class="btn btn-primary w-100 fw-bold py-2">Đăng ký</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Bạn đã có tài khoản? 
                            <a href="{{ route('login') }}" class="text-primary fw-bold">Đăng nhập</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Registration Section End -->

@endsection
