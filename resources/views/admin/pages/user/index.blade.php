@extends("admin.app")

@section("content")
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <!-- MENU CHUYỂN ĐỔI DANH SÁCH -->
                <ul class="nav nav-tabs" id="userTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="admin-tab" data-bs-toggle="tab" href="#admin-list" role="tab">Danh sách Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#user-list" role="tab">Danh sách Người Dùng</a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="userTabContent">
                    <!-- DANH SÁCH ADMIN -->
                    <div class="tab-pane fade show active" id="admin-list" role="tabpanel">
                        <div class="card card-table">
                            <div class="card-header">
                                <h5>Danh sách Admin</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-product">
                                    <table class="table all-package theme-table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Vai Trò</th>
                                                <th>Last Login</th> <!-- Thêm cột này -->
                                                
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($admins as $admin)
                                                <tr>
                                                    <td>
                                                        <div class="table-image">
                                                            <img src="/assets/images/logo/logoadmin.jfif" class="img-fluid" alt="">
                                                        </div>
                                                    </td>
                                                    <td>{{ $admin->name }}</td>
                                                    <td>{{ $admin->email }}</td>
                                                    <td>{{ $admin->role }}</td>
                                                    <td>
                                                        @if ($admin->isOnline())
                                                            <span class="badge bg-success">Đang hoạt động</span>
                                                        @elseif ($admin->last_login_at)
                                                            <span class="badge bg-secondary">
                                                                Đăng nhập {{ $admin->last_login_at->diffForHumans() }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DANH SÁCH USER -->
                    <div class="tab-pane fade" id="user-list" role="tabpanel">
                        <div class="card card-table">
                            <div class="card-header">
                                <h5>Danh sách Người Dùng</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-product">
                                    <table class="table all-package theme-table ">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Vai Trò</th>
                                                <th>Last Login</th> <!-- Thêm cột này -->
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="table-image">
                                                            <img src="/assets/images/logo/user.png" class="img-fluid" alt="">
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role }}</td>
                                                    <td>
                                                        @if ($user->isOnline())
                                                            <span class="badge bg-success">Đang hoạt động</span>
                                                        @elseif ($user->last_login_at)
                                                            <span class="badge bg-success">
                                                                Đăng nhập {{ $user->last_login_at->diffForHumans() }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    
                                                    
 
                                                    <td>
                                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="delete-form" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger delete-button">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> 
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
