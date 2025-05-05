@extends("admin.app")

@section('content')
<br>
<br>
<br>
<br>
<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="text-center">Sửa bài viết</h2>
            <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" class="form-control" rows="5" required>{{ $blog->content }}</textarea>
                </div>

                <div class="mb-3 text-center">
                    <label class="form-label d-block">Hình ảnh</label>
                    <input type="file" name="image" class="form-control">
                    @if ($blog->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $blog->image) }}" width="150" class="border rounded">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Xuất bản</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
