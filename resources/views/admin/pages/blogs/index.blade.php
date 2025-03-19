@extends('admin.app')

@section('content')
<!-- Container-fluid starts-->
<div class="page-body">
    <!-- Blog List Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="title-header option-title">
                            <h5>Danh Sách Bài Viết</h5>
                            <form class="d-inline-flex">
                                <a href="{{ route('admin.blogs.create') }}" class="align-items-center btn btn-theme d-flex">
                                    <i data-feather="plus"></i>Thêm Bài Viết Mới
                                </a>
                            </form>
                        </div>

                        <!-- Thông báo thành công -->
                        @if(session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Thanh tìm kiếm -->
                        <form action="{{ route('admin.blogs.index') }}" method="GET" class="mb-3 d-flex justify-content-center">
                            <div class="input-group w-50">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm blog..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-secondary">Tìm</button>
                            </div>
                        </form>

                        <div class="table-responsive table-product">
                            <table class="table all-package theme-table" id="table_id">
                                <thead>
                                    <tr>
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
                                            <td>
                                                <div class="table-image">
                                                    @if ($blog->image)
                                                        <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid" alt="{{ $blog->title }}">
                                                    @else
                                                        Không có
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="user-name">
                                                    <span>{{ $blog->title }}</span>
                                                </div>
                                            </td>
                                            <td>{{ Str::limit($blog->content, 50) }}</td>
                                            <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $blog->user->name ?? 'Admin' }}</td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <a href="{{ route('admin.blogs.edit', $blog) }}">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $blogs->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog List End -->
</div>
@endsection