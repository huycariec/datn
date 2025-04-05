@extends("admin.app")
@section("content")
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        <!-- Page Body Start -->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Ends-->

            <!-- Container-fluid starts-->
            <div class="page-body">
                <!-- All User Table Start -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table">
                                <div class="card-body">
                                    <div class="title-header option-title">
                                                {{-- Thông báo  --}}
                                        @if (session('message'))
                                            <div class="alert alert-info">
                                                {{ session('message') }}
                                            </div>
                                        @endif
                                        <h5>Tất Cả Thuộc Tính Sản Phẩm</h5>
                                        <form class="d-inline-flex">
                                            <a href="add-new-category.html" class="align-items-center btn btn-theme d-flex">
                                                <i data-feather="plus-square"></i>Thêm mới thuộc tính
                                            </a>
                                        </form>
                                    </div>

                                    <div class="table-responsive category-table">
                                        
                                        @if (isset($attributes) && !empty($attributes))

                                        <table class="table all-package theme-table" id="table_id">
                                            <thead>
                                                <tr>
                                                    <th>Tên thuộc tính</th>
                                                    <th>Giá trị thuộc tính </th>
                                                    <th>Tùy chỉnh</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($attributes as $key => $values) 
                                                <tr>
                                                    <!-- Hiển thị tên thuộc tính (key) -->
                                                    <td>{{ $key }}</td> 
                                            
                                                    <!-- Hiển thị danh sách giá trị của thuộc tính -->
                                                    <td>
                                                        @foreach($values as $value)
                                                            {{ $value }}{{ !$loop->last ? ', ' : '' }}
                                                        @endforeach
                                                    </td>
                                            
                                                    <!-- Hành động (sửa, xóa) -->
                                                    <td>
                                                        <ul>
                                                            <li>
                                                                <a href="{{route('admin.attribute.edit',$key)}}">
                                                                    <i class="ri-pencil-line"></i>
                                                                </a>
                                                            </li>
                                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#deleteModal" data-key="{{ $key }}">
                                                                <i class="ri-delete-bin-line text-danger"></i>
                                                            </a>
                                                         
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <div class="alert alert-warning">Chưa có thuộc tính nào được thêm</div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- All User Table Ends-->
            </div>
            <!-- Container-fluid end -->
        </div>
        <!-- Page Body End -->

        <!-- Modal Start -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title" id="staticBackdropLabel">Logging Out</h5>
                        <p>Are you sure you want to log out?</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="button-box">
                            <button type="button" class="btn btn--no" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn  btn--yes btn-primary">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End -->
    </div>

    <!-- Delete Modal Box Start -->
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Xác nhận xóa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa thuộc tính <b id="attribute-name"></b> không?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <div class="modal fade theme-modal remove-coupon" id="exampleModalToggle2" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel12">Done!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box text-center">
                        <div class="wrapper">
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                            </svg>
                        </div>
                        <h4 class="text-content">Đã được xóa.</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-custom')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var deleteModal = document.getElementById("deleteModal");
        deleteModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget; // Nút bấm mở modal
            var key = button.getAttribute("data-key"); // Lấy key từ data-key
            var form = document.getElementById("delete-form");

            form.action = "/admin-attributes-destroy/" + key; // Gán action cho form
            document.getElementById("attribute-name").innerText = key; // Hiển thị key trong modal
        });
    });
</script>
@endsection