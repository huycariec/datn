@extends("admin.app")

@section("content")
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>Danh sách</h5>
                                <div class="right-options">
                                    <ul>
                                        <li>
                                            <a class="btn btn-solid" href="{{ route('discounts.create') }}">Thêm mã</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div class="table-responsive">
                                    <div id="table_id_wrapper" class="dataTables_wrapper no-footer">
                                        <form id="table_id_filter" method="GET" class="dataTables_filter row">
                                            <div class="col-md-4 col-sm-12">
                                                <label>Nhập mã :
                                                    <input type="search" name="name" value="{{ $_GET['name'] ?? "" }}" aria-controls="table_id">
                                                </label>
                                            </div>
                                            <div class="d-flex col-sm-12 col-md-4 gap-2 mt-3 mt-md-0">
                                                <label class="mt-2">Xem</label>
                                                    <select name="size" class="form-select">
                                                        <option {{ isset($_GET['size']) && $_GET['size'] == 20 ? "selected" : "" }} value="20">20</option>
                                                        <option {{ isset($_GET['size']) && $_GET['size'] == 50 ? "selected" : "" }} value="50">50</option>
                                                        <option {{ isset($_GET['size']) && $_GET['size'] == 100 ? "selected" : "" }} value="100">100</option>
                                                        <option {{ isset($_GET['size']) && $_GET['size'] == 200 ? "selected" : "" }} value="200">200</option>
                                                    </select>
                                                <label class="mt-2">mục</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12 d-flex gap-2 mt-md-0 mt-3">
                                                <button type="submit" class="btn btn-primary">Lọc</button>
                                                <a href="{{ route("discounts.index") }}" class="btn btn-warning">Bỏ lọc</a>
                                            </div>
                                        </form>
                                        <table
                                            class="table all-package coupon-list-table table-hover theme-table dataTable no-footer"
                                            id="table_id">
                                            <thead>
                                            <tr>
{{--                                                <th class="sorting_disabled" rowspan="1" colspan="1"--}}
{{--                                                    style="width: 224.656px;">--}}
{{--                                                            <span class="form-check user-checkbox m-0 p-0">--}}
{{--                                                                <input class="checkbox_animated checkall"--}}
{{--                                                                       type="checkbox" value="">--}}
{{--                                                            </span>--}}
{{--                                                </th>--}}
                                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 224.656px;">Mã
                                                </th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 224.656px;">Giá trị giảm
                                                </th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 224.656px;">Trạng thái
                                                </th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 224.656px;">Loại mã
                                                </th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 224.719px;">Hành động
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($discounts as $discount)
                                                    <tr class="odd">
{{--                                                        <td>--}}
{{--                                                            <span class="form-check user-checkbox m-0 p-0">--}}
{{--                                                                <input class="checkbox_animated check-it"--}}
{{--                                                                       type="checkbox" value="">--}}
{{--                                                            </span>--}}
{{--                                                        </td>--}}
                                                        <td>{{ $discount->code }}</td>
                                                        <td>{{ $discount->value }} {{$discount->type == 'percent' ? '%' : "vnđ"}}</td>
                                                        <td class="menu-status">
                                                            <span class="{{$discount->status ==='active' ? 'success' : 'danger'}}">{{ $discount->status == 'active' ? 'Hoạt động' : 'Không hoạt động'}}</span>
                                                        </td>
                                                        <td class="theme-color">{{ $discount->type == 'percent' ? 'Phần trăm' : 'Cố định' }}</td>
                                                        <td>
                                                            <ul>
                                                                <li>
                                                                    <a href="{{ route("discounts.show", $discount) }}">
                                                                        <i class="ri-eye-line"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route("discounts.edit", $discount) }}">
                                                                        <i class="ri-pencil-line"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="javascript:void(0)" data-id="{{ $discount->id }}" data-bs-toggle="modal"
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
                                        <div class="d-flex justify-content-between mt-2">
                                            <div>
                                                Xem {{ $discounts->count() }} của {{ $discounts->total() }} danh mục
                                            </div>
                                            <div>
                                                {{ $discounts->appends(request()->all())->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination End -->
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
                    <h5 class="modal-title" id="staticBackdropLabel">Xóa dữ liệu này ?</h5>
                    <p>Hành động này sẽ không thể khôi phục ?</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="button-box">
                        <button type="button" class="btn btn--no" data-bs-dismiss="modal">Không</button>
                        <button type="button" class="btn  btn--yes btn-primary">Đúng vậy</button>
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
                    url: `/admin/discounts/${selectedId}`,
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
