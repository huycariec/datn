@extends("admin.app")

@section("content")
    <div class="page-body">

        <!-- Edit Category Start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-8 m-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header-2">
                                        <h5>Chỉnh sửa danh mục</h5>
                                    </div>

                                    <form class="theme-form theme-form-2 mega-form" action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Tên danh mục -->
                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Tên danh mục</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="name" value="{{ $category->name }}" placeholder="Nhập tên danh mục">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Mô tả danh mục -->
                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Mô tả</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="description" rows="3" placeholder="Nhập mô tả danh mục">{{ $category->description }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Ảnh danh mục -->
                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Ảnh danh mục</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="image">
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <!-- Hiển thị ảnh hiện tại nếu có -->
                                                @if ($category->image)
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/' . $category->image) }}" width="100" alt="Ảnh danh mục">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary" type="submit">Cập nhật</button>
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
