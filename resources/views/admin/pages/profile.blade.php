@extends("admin.app")

@section("content")
<div class="page-body">

    <!-- New Product Add Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8 m-auto">
                        <div class="card">
                            <div class="card-body" data-select2-id="select2-data-32-f94z">
                                <div class="card-header-2">
                                    <h5>Profile</h5>
                                </div>

                                <form class="theme-form theme-form-2 mega-form" action="{{ route('admin.updateProfile') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Tên</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" value="{{ Auth::user()->name}}" placeholder="Nhập tên">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Email</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" value="{{ Auth::user()->email}}" placeholder="Nhập tên" disabled>
                                           
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Ảnh</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="avatar" >
                                            @if(Auth::user()->profile?->avatar)
                                            <img src="{{ asset('storage/image/' . Auth::user()->profile->avatar) }}" width="150" class="mt-2">
                                            @endif
                                            @error('avatar')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Giới tính</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="gender" value="{{ Auth::user()->profile?->gender}}" placeholder="Nhập giới tính">
                                            @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Ngày sinh</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="date" name="dob" value="{{ Auth::user()->profile?->dob}}" placeholder="Nhập ngày sinh">
                                            @error('dob')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Số điện thoại</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="phone" value="{{ Auth::user()->profile?->phone}}" placeholder="Nhập số điện thoại">
                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="text-end">
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