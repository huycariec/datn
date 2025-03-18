@extends("admin.app")
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title d-flex justify-content-between align-items-center">
                                <h5>Danh sách vai trò</h5>
                                <a href="{{ route('roles.create') }}" class="btn btn-theme d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    Thêm vai trò
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="table_id" class="table role-table theme-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th>Tên vai trò</th>
                                        <th>Ngày tạo</th>
                                        <th>Tùy chọn</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($roles as $index => $role)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->created_at->diffForHumans() }}</td>
                                            <td>
                                                <ul class="list-inline m-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('roles.edit', $role->id) }}">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                    @if($role->name !== 'super admin' && $role->name !== 'admin')
                                                        <li class="list-inline-item">
                                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none text-danger" data-bs-original-title="" title="">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
