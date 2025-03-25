@extends('app')

@section('content')
    <section class="profile-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Hồ sơ</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">Địa chỉ</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabContent">
                        <!-- Tab Hồ sơ -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Avatar -->
                                        <div class="col-md-3 text-center">
                                            <form action="{{ route('client.updateAvatar') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="avatar-wrapper mb-3">
                                                    <img id="avatarPreview" src="{{ Auth::user()->profile?->avatar ? asset('storage/' . Auth::user()->profile->avatar) : '/assets/images/user_placeholder_image.jpg' }}" alt="Avatar" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                                    <input type="file" class="form-control d-none" name="avatar" id="avatarInput" accept="image/*">
                                                    <label for="avatarInput" class="btn btn-outline-primary btn-sm mt-2">Chọn ảnh</label>
                                                </div>
                                                <button type="submit" class="btn btn-success btn-sm">Cập nhật ảnh</button>
                                            </form>
                                        </div>

                                        <!-- Thông tin hồ sơ -->
                                        <div class="col-md-9">
                                            <h4 class="mb-3">Thông tin hồ sơ</h4>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif
                                            <div class="profile-info">
                                                <p><strong>Tên:</strong> {{ $user->name ?? 'Chưa cập nhật' }}</p>
                                                <p><strong>Email:</strong> {{ $user->email ?? 'Chưa cập nhật' }}</p>
                                                <p><strong>Giới tính:</strong> {{ $profile->gender == 1 ? 'Nam' : ($profile->gender == 0 ? 'Nữ' : 'Chưa cập nhật') }}</p>
                                                <p><strong>Ngày sinh:</strong> {{ $profile->dob ?? 'Chưa cập nhật' }}</p>
                                                <p><strong>Số điện thoại:</strong> {{ $profile->phone ?? 'Chưa cập nhật' }}</p>
                                            </div>
                                            <a href="{{ route('client.editProfile') }}" class="btn btn-primary">Chỉnh sửa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Địa chỉ -->
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4>Danh sách địa chỉ</h4>
                                        <a href="{{ route('client.addAddressForm') }}" class="btn btn-primary">Thêm địa chỉ</a>
                                    </div>
                                    <div class="list-group">
                                        @forelse($addresses as $key => $address)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="mb-1"><strong>Địa chỉ {{ $key + 1 }}:</strong></p>
                                                        <p class="mb-0">{{ $address->address_detail ?? '' }}, {{ $address->ward->name ?? '' }}, {{ $address->district->name ?? '' }}, {{ $address->province->name ?? '' }}</p>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('client.editAddress', $address->id) }}" class="btn btn-sm btn-primary">Chỉnh sửa</a>
                                                        <form action="{{ route('client.deleteAddress', $address->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">Xóa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="list-group-item">Chưa có địa chỉ nào.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Script cho avatar preview -->
    <script>
        document.getElementById("avatarInput").addEventListener("change", function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById("avatarPreview");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
