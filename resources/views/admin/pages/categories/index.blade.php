@extends("admin.app")

@section("content")
    <div class="page-body">
        <!-- All User Table Start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>Danh sách danh mục</h5>

                                @can('categories_create')
                                    <div class="d-inline-flex">
                                        <a href="{{route('categories.create')}}"
                                           class="align-items-center btn btn-theme d-flex">
                                            <i data-feather="plus-square"></i>Thêm mới
                                        </a>
                                    </div>
                                @endcan
                            </div>

                            <form method="GET" action="{{ route('categories.index') }}"
                                  class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    <input type="text" name="search" placeholder="Tìm kiếm danh mục"
                                           value="{{ request('search') }}"
                                           class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <select name="sort_by" class="form-select">
                                        <option value="asc" {{ request('sort_by') == 'asc' ? 'selected' : '' }}>A-Z
                                        </option>
                                        <option value="desc" {{ request('sort_by') == 'desc' ? 'selected' : '' }}>Z-A
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                </div>
                            </form>


                            <div class="table-responsive category-table mt-4">
                                <div>
                                    <table class="table all-package theme-table" id="table_id">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Hình ảnh</th>
                                            <th>Tên danh mục</th>
                                            <th>Mô tả</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($categories as $cate )
                                            <tr>
                                                <td>{{$cate->id}}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $cate->image) }}"
                                                         alt="Hình ảnh danh mục" width="50">
                                                </td>
                                                <td>{{$cate->name}}</td>
                                                <td>{{$cate->description}}</td>
                                                @canany(['categories_update', 'categories_delete'])
                                                    <td>
                                                        <ul>

                                                            @can('categories_update')
                                                                <li>
                                                                    <a href="{{route('categories.edit',$cate)}}">
                                                                        <i class="ri-pencil-line"></i>
                                                                    </a>
                                                                </li>
                                                            @endcan

                                                            @can('categories_delete')
                                                                <li>
                                                                    <button type="button"
                                                                            class="btn p-0 border-0 delete-btn"
                                                                            data-url="{{ route('categories.destroy', $cate) }}">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                </li>
                                                            @endcan
                                                        </ul>
                                                    </td>
                                                @endcanany
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div>
                                            Xem {{ $categories->count() }} của {{ $categories->total() }} danh mục
                                        </div>
                                        <div>
                                            {{ $categories->appends(request()->all())->links() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmModal"
         tabindex="-1" aria-labelledby="deleteConfirmLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="deleteConfirmLabel">Xác nhận
                        xóa</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa danh mục này
                    không?
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">Hủy
                    </button>
                    <!-- Form xóa với action được cập nhật động -->
                    <form id="deleteForm" action=""
                          method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger">Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let actionUrl = this.getAttribute("data-url");
                    document.getElementById("deleteForm").action = actionUrl;
                    let modal = new bootstrap.Modal(document.getElementById("deleteConfirmModal"));
                    modal.show();
                });
            });
        });
    </script>
@endpush
