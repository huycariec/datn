@extends('app')

@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-3 pb-3 bg-light text-center">
    <div class="container">
        <h2 class="fw-bold">Khôi phục mật khẩu</h2>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Reset Password Section Start -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Đặt lại mật khẩu</h3>
                        <p class="text-muted">Vui lòng nhập mật khẩu mới của bạn.</p>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Mật khẩu mới</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Nhập mật khẩu mới" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100 fw-bold py-2">Đặt lại mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Reset Password Section End -->
@endsection
