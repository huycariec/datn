@extends('app')

@section('content')
    <section class="edit-profile-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <a href="{{ route('client.profile') }}">Trở lại</a>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Chỉnh sửa hồ sơ</h3>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('client.updateProfile') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                                    <label for="name">Tên</label>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" value="{{ $user->email ?? '' }}" disabled>
                                    <label for="email">Email</label>
                                </div>

                                <div class="mb-3">
                                    <label>Giới tính</label><br>
                                    <input type="radio" name="gender" value="1" id="male" {{ old('gender', $user->profile->gender ?? '') == 1 ? 'checked' : '' }}>
                                    <label for="male">Nam</label>
                                    <input type="radio" name="gender" value="0" id="female" {{ old('gender', $user->profile->gender ?? '') == 0 ? 'checked' : '' }}>
                                    <label for="female">Nữ</label>
                                    @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob', $user->profile->dob ?? '') }}">
                                    <label for="dob">Ngày sinh</label>
                                    @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                                    <label for="phone">Số điện thoại</label>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Lưu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
