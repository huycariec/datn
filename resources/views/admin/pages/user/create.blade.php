@extends("admin.app")

@section("content")
    <div class="page-body">
        <!-- New User Add Start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-8 m-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header-2">
                                        <h5>Thông tin nhân viên</h5>
                                    </div>

                                    <form class="theme-form theme-form-2 mega-form" action="{{ route('users.store') }}" method="post">
                                        @csrf

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Tên</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Nhập tên nhân viên">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Email</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email">
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Mật khẩu</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="password" name="password" placeholder="Nhập mật khẩu">
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Xác nhận mật khẩu</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu">
                                                @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Vai trò</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="role">
                                                    <option value="">Chọn vai trò</option>
                                                    @foreach($roles as $role)
                                                        <option {{ old('role') == $role->name ? 'selected' : '' }} value="{{ $role->name }}">
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-end d-flex">
                                            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary me-2">Hủy</a>
                                            <button class="btn btn-primary" type="submit">Lưu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
