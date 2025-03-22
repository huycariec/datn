@extends('app')

@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-3 pb-3 bg-light text-center">
    <div class="container">
        <h2 class="fw-bold">Quên mật khẩu</h2>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Khôi phục mật khẩu</h3>
                        <p class="text-muted">Vui lòng nhập email của bạn để nhận liên kết khôi phục mật khẩu.</p>
                    </div>

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" placeholder="Nhập email của bạn" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100 fw-bold py-2">Gửi liên kết khôi phục</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</section>
<!-- Forgot Password Section End -->

@endsection
