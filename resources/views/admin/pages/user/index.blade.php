@extends("admin.app")

@section("content")
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="tab-content mt-3" id="userTabContent">
                    @if(empty($users))
                        <h3>Có lỗi sảy ra</h3>
                    @else
                        <div class="tab-pane fade show active" id="admin-list" role="tabpanel">
                            <div class="card card-table">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5>Danh sách <span class="text-danger">{{ $role == 'admin' ? 'quản trị viên' : 'người dùng' }}</span></h5>
                                    </div>
                                    <div>
                                        <div class="d-inline-flex">
                                            @can('users_create')
                                            <a href="{{ route('users.create') }}"
                                               class="align-items-center btn btn-theme d-flex">
                                                <i data-feather="plus-square"></i> Thêm mới
                                            </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-product">
                                        <table class="table all-package theme-table">
                                            <thead>
                                            <tr>
                                                <th>Ảnh đại diện</th>
                                                <th>Tên người dùng</th>
                                                <th>Email/Số điện thoại</th>
                                                <th>Tuổi/Giới tính</th>
                                                <th>Đăng nhập lần cuối</th>
                                                @can('users_update')
                                                    <th>Thao tác</th>
                                                @endcan
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="table-image">
                                                            <img src="{{ isset($user->profile) && isset($user->profile->avatar) && file_exists(storage_path($user->profile->avatar)) ? \Illuminate\Support\Facades\Storage::url($user->profile->avatar) : "/assets/images/logo/logoadmin.jfif" }}" class="img-fluid" alt="">
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email . '/' . isset($user->profile) && isset($user->profile->phone) ? $user->profile->phone : '' }}</td>
                                                    <td>{{ isset($user->profile->dob) ? \Carbon\Carbon::now()->diffInYears($user->profile->dob) . '/' : ""}} {{ isset($user->profile) && isset($user->profile->gender) == '0' ? 'Nam' : 'Nữ' }}</td>
                                                    <td class="text-center">
                                                        {{ isset($user->profile) && isset($user->profile->last_login_at) ? $user->last_login_at->diffForHumans() : "" }}
                                                    </td>
                                                    @can('users_update')
                                                        <td class="text-center">
                                                            <li class="list-inline-item">
                                                                <a href="{{ route('roles.edit', $user->id) }}">
                                                                    <i class="ri-pencil-line"></i>
                                                                </a>
                                                            </li>
                                                        </td>
                                                    @endcan
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                let form = this.closest('.delete-form');

                Swal.fire({
                    title: 'Bạn có chắc muốn xóa?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
