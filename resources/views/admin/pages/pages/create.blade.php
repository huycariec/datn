@extends("admin.app")

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>Thêm trang mới</h5>
                                <div class="right-options">
                                    <ul>
                                        <li>
                                            <a class="btn btn-solid" href="{{ route('pages.index') }}">Quay lại danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <form action="{{ route('pages.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Tên trang</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                        @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Loại trang</label>
                                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="">Chọn loại trang</option>
                                            <option value="instruct">Hướng dẫn mua hàng</option>
                                            <option value="introduction">Giới thiệu</option>
                                            <option value="policy_buy">Chính sách mua hàng</option>
                                            <option value="policy_return">Chính sách đổi trả</option>
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="content">Nội dung</label>
                                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content') }}</textarea>
                                        @error('content')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-2 mt-2">
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                        <a href="{{ route('pages.index') }}" class="btn btn-warning">Hủy</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
