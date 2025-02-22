@extends('admin.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>{{ isset($role) ? 'Chỉnh sửa vai trò' : 'Tạo vai trò' }}</h5>
                            </div>

                            <form method="POST" action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" class="theme-form theme-form-2 mega-form">
                                @csrf
                                @if(isset($role))
                                    @method('PUT')
                                @endif
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-12 mb-0">Tên vai trò <span class="theme-color">*</span></label>
                                    <div class="col-12">
                                        <input class="form-control" type="text" name="name" placeholder="Nhập tên vai trò" value="{{ old('name', $role->name ?? '') }}" required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h4 class="form-label-title">Quyền hạn</h4>
                                </div>

                                <div class="row g-sm-4 g-2">
                                    <div class="col-12">
                                        <div class="row roles-form">
                                            <div class="col-12">
                                                <ul>
                                                    <li>
                                                        <input class="checkbox_animated checkall" type="checkbox" id="selectAll">
                                                        <label class="form-check-label m-0" for="selectAll">Chọn tất cả</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            @foreach ($permission_groups as $groupIndex => $permission_group)
                                                <div class="col-12">
                                                    <ul>
                                                        <li>{{ $permission_group[0]['guard_name'] }} :</li>
                                                        <li>
                                                            <input class="checkbox_animated checkall-group" type="checkbox" data-group="{{ $groupIndex }}" id="group{{ $groupIndex }}">
                                                            <label class="form-check-label m-0" for="group{{ $groupIndex }}">Tất cả</label>
                                                        </li>
                                                        @foreach ($permission_group as $permission)
                                                            <li>
                                                                <input class="checkbox_animated check-it" type="checkbox" name="permissions[]" value="{{ $permission->id }}" data-group="{{ $groupIndex }}" id="perm{{ $permission->id }}" {{ isset($role) && $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                                                <label class="form-check-label m-0" for="perm{{ $permission->id }}">{{ $permission->name }}</label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex float-end gap-2">
                                    <a href="{{ route('roles.index') }}" class="btn btn-danger ms-auto mt-4">Trở lại</a>
                                    <button type="submit" class="btn btn-primary ms-auto mt-4">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            document.querySelectorAll('.check-it, .checkall-group').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.querySelectorAll('.checkall-group').forEach(groupCheckbox => {
            groupCheckbox.addEventListener('change', function () {
                const groupIndex = this.getAttribute('data-group');
                document.querySelectorAll(`.check-it[data-group="${groupIndex}"]`).forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });
    </script>
@endsection
