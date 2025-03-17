@extends("admin.app")

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>Chỉnh sửa trang</h5>
                                <div class="right-options">
                                    <ul>
                                        <li>
                                            <a class="btn btn-solid" href="{{ route('pages.index') }}">Quay lại danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <form action="{{ route('pages.update', $page->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Tên trang</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $page->name) }}" required>
                                        @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Loại trang</label>
                                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="">Chọn loại trang</option>
                                            <option {{ $page->type == "instruct" ? "selected" : ""}} value="instruct">Hướng dẫn mua hàng</option>
                                            <option {{ $page->type == "introduction" ? "selected" : ""}} value="introduction">Giới thiệu</option>
                                            <option {{ $page->type == "policy_buy" ? "selected" : ""}} value="policy_buy">Chính sách mua hàng</option>
                                            <option {{ $page->type == "policy_return.blade.php" ? "selected" : ""}} value="policy_return">Chính sách đổi trả</option>
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="content">Nội dung</label>
                                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content', $page->content) }}</textarea>
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
