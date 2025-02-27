@extends('admin.app')

@section('content')
<br>
<br>
<br>
<br>
<br>

<!-- Blog list area start -->
<div class="blog_list blog_padding mt-23">
    <div class="container">
        <div class="row justify-content-center"> <!-- Căn giữa toàn bộ nội dung -->
            <div class="col-lg-10"> <!-- Thu hẹp nội dung để nhìn cân đối hơn -->
                <h3 class="text-center">Danh Sách Bài Viết</h3>

                <!-- Thông báo thành công -->
                @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Nút thêm blog -->
                <div class="text-center mb-3">
                    <a href="{{ route('blogs.create') }}" class="btn btn-primary">Thêm Bài Viết Mới</a>
                </div>

                <!-- Thanh tìm kiếm -->
                <form action="{{ route('blogs.index') }}" method="GET" class="mb-3 d-flex justify-content-center">
                    <div class="input-group w-50">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm blog..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-secondary">Tìm</button>
                    </div>
                </form>

                <!-- Danh sách blog -->
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hình Ảnh</th>
                            <th>Tiêu Đề</th>
                            <th>Nội Dung</th>
                            <th>Ngày Đăng</th>
                            <th>Người Đăng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>
                                    @if ($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="80">
                                    @else
                                        Không có
                                    @endif
                                </td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ Str::limit($blog->content, 50) }}</td>
                                <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                                <td>{{ $blog->user->name ?? 'Admin' }}</td>
                                <td>
                                    <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="{{ route('blogs.destroy', $blog) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog list area end -->
@endsection
