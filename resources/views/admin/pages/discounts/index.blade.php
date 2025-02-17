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
                                        <div id="table_id_filter" class="dataTables_filter row">
                                            <div class="col-md-4 col-sm-12">
                                                <label>Nhập tên :
                                                    <input type="search" class="" placeholder=""  aria-controls="table_id">
                                                </label>
                                            </div>
                                            <div class="d-flex col-sm-12 col-md-4 gap-2 mt-3 mt-md-0">
                                                <label>Hiển thị</label>
                                                    <select name="size" class="form-select">
                                                        <option value="20">20</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                        <option value="200">200</option>
                                                    </select>
                                                <label for="">mục</label>
                                            </div>
                                            <div class="col-md-2 col-sm-12"><button class="btn btn-primary">Lọc</button></div>
                                        </div>
                                        <table
                                            class="table all-package coupon-list-table table-hover theme-table dataTable no-footer"
                                            id="table_id">
                                            <thead>
                                            <tr>
                                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 224.656px;">
                                                            <span class="form-check user-checkbox m-0 p-0">
                                                                <input class="checkbox_animated checkall"
                                                                       type="checkbox" value="">
                                                            </span>
                                                </th>
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
                                                        <td>
                                                    <span class="form-check user-checkbox m-0 p-0">
                                                        <input class="checkbox_animated check-it"
                                                               type="checkbox" value="">
                                                    </span>
                                                        </td>
                                                        <td>{{ $discount->code }}</td>
                                                        <td>{{ $discount->value }} {{$discount->type == 'percent' ? '%' : "vnđ"}}</td>
                                                        <td class="menu-status">
                                                            <span class="{{$discount->status ==='active' ? 'success' : 'danger'}}">{{ $discount->status == 'active' ? 'Hoạt động' : 'Không hoạt động'}}</span>
                                                        </td>
                                                        <td class="theme-color">{{ $discount->type == 'percent' ? 'Phần trăm' : 'Cố định' }}</td>
                                                        <td>
                                                            <ul>
                                                                <li>
                                                                    <a href="javascript:void(0)">
                                                                        <i class="ri-pencil-line"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                       data-bs-target="#exampleModalToggle">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
