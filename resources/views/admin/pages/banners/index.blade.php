@extends("admin.app")

@section("content")
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>Danh sách banner</h5>
                                @if(count($banners) < 5)
                                    <div class="right-options">
                                        <ul>
                                            <li>
                                                <a class="btn btn-solid" href="{{ route('banners.create') }}">Thêm banner</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="table-responsive">
                                    <div id="table_id_wrapper" class="dataTables_wrapper no-footer">
                                        <form id="table_id_filter" method="GET" class="dataTables_filter row">
                                            <div class="col-md-4 col-sm-12">
                                                <label>Nhập link :
                                                    <input type="search" name="link" value="{{ request('link') ?? '' }}" aria-controls="table_id">
                                                </label>
                                            </div>
                                            <div class="d-flex col-sm-12 col-md-4 gap-2 mt-3 mt-md-0">
                                                <label class="mt-2">Xem</label>
                                                <select name="size" class="form-select">
                                                    <option {{ request('size') == 20 ? 'selected' : '' }} value="20">20</option>
                                                    <option {{ request('size') == 50 ? 'selected' : '' }} value="50">50</option>
                                                    <option {{ request('size') == 100 ? 'selected' : '' }} value="100">100</option>
                                                    <option {{ request('size') == 200 ? 'selected' : '' }} value="200">200</option>
                                                </select>
                                                <label class="mt-2">mục</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 d-flex gap-2 mt-md-0 mt-3">
                                                <button type="submit" class="btn btn-primary">Lọc</button>
                                                <a href="{{ route('banners.index') }}" class="btn btn-warning">Bỏ lọc</a>
                                            </div>
                                        </form>
                                        <table class="table all-package coupon-list-table table-hover theme-table dataTable no-footer"
                                               id="table_id">
                                            <thead>
                                            <tr>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 224.656px;">ID</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 224.656px;">Ảnh</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 224.656px;">Vị trí</th>
{{--                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 224.656px;">Trạng thái</th>--}}
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 224.656px;">Link</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 224.719px;">Hành động</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($banners as $banner)
                                                <tr class="odd">
                                                    <td>{{ $banner->id }}</td>
                                                    <td>
                                                        <img src="{{ Storage::url($banner->image) }}" width="100" alt="Banner">
                                                    </td>
                                                    <td>{{ $banner->position }}</td>
{{--                                                    <td class="menu-status">--}}
{{--                                                        <span class="{{ $banner->status ? 'success' : 'danger' }}">{{ $banner->status ? 'Hoạt động' : 'Không hoạt động' }}</span>--}}
{{--                                                    </td>--}}
                                                    <td>{{ $banner->link }}</td>
                                                    <td>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('banners.edit', $banner) }}">
                                                                    <i class="ri-pencil-line"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" data-id="{{ $banner->id }}" data-bs-toggle="modal"
                                                                   data-bs-target="#deletePopup">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
{{--                                        <div class="d-flex justify-content-end">--}}
{{--                                            {{ $banners->appends(request()->query())->links('pagination::bootstrap-5') }}--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("modal")
    <div class="modal fade" id="deletePopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="deletePopup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="staticBackdropLabel">Xóa banner này?</h5>
                    <p>Hành động này sẽ không thể khôi phục!</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="button-box">
                        <button type="button" class="btn btn--no" data-bs-dismiss="modal">Không</button>
                        <button type="button" class="btn btn--yes btn-primary">Đúng vậy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push("script")
    <script>
        $(document).ready(function () {
            let selectedId = null;
            $('a[data-bs-target="#deletePopup"]').on("click", function () {
                selectedId = $(this).data("id");
            });
            $('.btn--yes').on("click", function () {
                $.ajax({
                    url: `/admin/banners/${selectedId}`,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (response) {
                        $('#deletePopup').modal('hide');
                        $(`a[data-id="${selectedId}"]`).closest("tr").remove();
                        alert("Xóa thành công!");
                    },
                    error: function () {
                        alert("Xóa thất bại, vui lòng thử lại!");
                    }
                })
            })
        })
    </script>
@endpush
