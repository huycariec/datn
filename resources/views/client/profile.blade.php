@extends('app')
@section('content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Hồ sơ</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Hồ sơ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- log in section start -->
<section class="log-in-section section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <!-- <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="../assets/images/inner-page/sign-up.png" class="img-fluid" alt="">
                    </div>
                </div> -->

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h3>Chào mừng bạn tới Fastkart</h3>
                        <h4>Thay đổi hồ sơ</h4>
                    </div>

                    <div class="input-box">
                        <form class="row g-4" action="{{ route('client.updateProfile') }}" method="POST">
                            @csrf

                            @method('put')

                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="fullname" name="name"
                                        placeholder="Full Name" value="{{$user->name}}">
                                    <label for="name">Name</label>

                                    @if ($errors->has('name'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email Address" value="{{$user->email}}" disabled>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-animation w-100" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
</section>
<!-- log in section end -->
@endsection