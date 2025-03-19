@extends("admin.app")

@section('content')
<div class="page-body">

<!-- New Blog Post Add Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-8 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Thêm Bài Viết</h5>
                            </div>
                            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="theme-form theme-form-2 mega-form">
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Tiêu đề</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="title" placeholder="Nhập tiêu đề" required>
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Nội dung</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="content" rows="5" placeholder="Nhập nội dung" required></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Hình ảnh</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="image">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">Lưu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- New Blog Post Add End -->
@endsection
