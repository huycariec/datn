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
                                        <h5>Thêm mới danh mục</h5>
                                    </div>

                                    <form class="theme-form theme-form-2 mega-form" action="{{ route('categories.store') }}" method="post">
                                        @csrf
                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Danh mục</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="name" value="{{old('name')}}" placeholder="Nhập tên danh mục">
                                                @error('name')
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
