@extends('app')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row">
                        <!-- Cột bên trái: Form cập nhật hồ sơ -->
                        <div class="col-md-6">
                            <div class="log-in-box">
                                <div class="log-in-title">
                                    <h3>Chào mừng bạn tới LINGOAN</h3>
                                    <h4>Quản lý hồ sơ</h4>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <form action="{{ route('client.updateProfile') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name', $user->name ?? '') }}" required>
                                        <label for="name">Tên</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" value="{{ $user->email ?? '' }}"
                                            disabled>
                                        <label for="email">Email</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                            name="avatar" id="avatarInput" accept="image/*">
                                        <label for="avatar">Avatar</label>
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <img id="avatarPreview" src="{{ asset('storage/' . ($profile->avatar ?? '')) }}"
                                            alt="Avatar Preview"
                                            style="display: {{ $profile && $profile->avatar ? 'block' : 'none' }}; max-width: 150px; border-radius: 10px;">
                                    </div>



                                    <div class="mb-3">
                                        <label>Giới tính</label><br>
                                        <input type="radio" name="gender" value="1" id="male"
                                            {{ old('gender', $profile->gender ?? '') == 1 ? 'checked' : '' }}>
                                        <label for="male">Nam</label>

                                        <input type="radio" name="gender" value="0" id="female"
                                            {{ old('gender', $profile->gender ?? '') == 0 ? 'checked' : '' }}>
                                        <label for="female">Nữ</label>

                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                            name="dob" value="{{ old('dob', $profile->dob ?? '') }}">
                                        <label for="dob">Ngày sinh</label>
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{ old('phone', $profile->phone ?? '') }}">
                                        <label for="phone">Số điện thoại</label>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn bg-success text-white btn-primary w-100 mb-4">Cập nhật
                                        hồ sơ</button>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="log-in-box">
                                <h4>Danh sách địa chỉ của bạn</h4>
                                <div class="list-group">
                                    @forelse($addresses as $key => $address)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p><strong>Địa chỉ {{ $key + 1 }}</strong></p>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-primary"
                                                        onclick="toggleEditForm({{ $key }})">Cập nhật</button>
                                                    <form action="{{ route('client.deleteAddress', $address->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                                                            title="Xóa">
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Form cập nhật địa chỉ -->
                                            <form id="edit-form-{{ $key }}" class="edit-address-form"
                                                style="display: none;"
                                                action="{{ route('client.updateAddress', $address->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="province_name"
                                                        class="form-control @error('province_name') is-invalid @enderror"
                                                        value="{{ old('province_name', $address->province->name ?? '') }}"
                                                        required>
                                                    <label for="province_name">Tỉnh/Thành</label>
                                                    @error('province_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="district_name"
                                                        class="form-control @error('district_name') is-invalid @enderror"
                                                        value="{{ old('district_name', $address->district->name ?? '') }}"
                                                        required>
                                                    <label for="district_name">Quận/Huyện</label>
                                                    @error('district_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="ward_name"
                                                        class="form-control @error('ward_name') is-invalid @enderror"
                                                        value="{{ old('ward_name', $address->ward->name ?? '') }}"
                                                        required>
                                                    <label for="ward_name">Phường/Xã</label>
                                                    @error('ward_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="address"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        value="{{ old('address', $address->address_detail ?? '') }}"
                                                        required>
                                                    <label for="address">Địa chỉ chi tiết</label>
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-success w-50">Lưu</button>
                                                    <button type="button" class="btn btn-secondary w-50"
                                                        onclick="toggleEditForm({{ $key }})">Hủy</button>
                                                </div>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="list-group-item">Chưa có địa chỉ nào.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="log-in-box mt-4">
                                <h4>Thêm địa chỉ mới</h4>
                                <form action="{{ route('client.addAddress') }}" method="POST">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <select name="province_name"
                                            class="form-select @error('province_name') is-invalid @enderror"
                                            id="province" required>
                                            <option value="" selected>Chọn Tỉnh/Thành</option>
                                        </select>
                                        <label for="province">Tỉnh/Thành</label>
                                        @error('province_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select name="district_name"
                                            class="form-select @error('district_name') is-invalid @enderror"
                                            id="district" required>
                                            <option value="" selected>Chọn Quận/Huyện</option>
                                        </select>
                                        <label for="district">Quận/Huyện</label>
                                        @error('district_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select name="ward_name"
                                            class="form-select @error('ward_name') is-invalid @enderror" id="ward"
                                            required>
                                            <option value="" selected>Chọn Phường/Xã</option>
                                        </select>
                                        <label for="ward">Phường/Xã</label>
                                        @error('ward_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', '') }}" required>
                                        <label for="address">Địa chỉ chi tiết</label>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn bg-primary text-white btn-primary w-100">Thêm địa
                                        chỉ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Các script giữ nguyên -->
    <script>
        document.getElementById("avatarInput").addEventListener("change", function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById("avatarPreview");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });

        document.querySelectorAll('input[name="gender"]').forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                document.querySelectorAll('input[name="gender"]').forEach((box) => {
                    if (box !== this) box.checked = false;
                });
            });
        });
    </script>

    <script>
        function toggleEditForm(index) {
            let form = document.getElementById(`edit-form-${index}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const provinceSelect = document.getElementById("province");
            const districtSelect = document.getElementById("district");
            const wardSelect = document.getElementById("ward");

            function loadProvinces() {
                fetch("https://provinces.open-api.vn/api/p/")
                    .then(response => response.json())
                    .then(data => {
                        provinceSelect.innerHTML = '<option value="" selected>Chọn Tỉnh/Thành</option>';
                        data.forEach(province => {
                            provinceSelect.innerHTML +=
                                `<option value="${province.name}">${province.name}</option>`;
                        });
                    });
            }

            function loadDistricts(provinceName) {
                fetch(`https://provinces.open-api.vn/api/p/`)
                    .then(response => response.json())
                    .then(data => {
                        const province = data.find(p => p.name === provinceName);
                        if (province) {
                            fetch(`https://provinces.open-api.vn/api/p/${province.code}?depth=2`)
                                .then(response => response.json())
                                .then(data => {
                                    districtSelect.innerHTML =
                                        '<option value="" selected>Chọn Quận/Huyện</option>';
                                    wardSelect.innerHTML =
                                        '<option value="" selected>Chọn Phường/Xã</option>';
                                    data.districts.forEach(district => {
                                        districtSelect.innerHTML +=
                                            `<option value="${district.name}">${district.name}</option>`;
                                    });
                                });
                        }
                    });
            }

            function loadWards(districtName) {
                fetch(`https://provinces.open-api.vn/api/d/`)
                    .then(response => response.json())
                    .then(data => {
                        const district = data.find(d => d.name === districtName);
                        if (district) {
                            fetch(`https://provinces.open-api.vn/api/d/${district.code}?depth=2`)
                                .then(response => response.json())
                                .then(data => {
                                    wardSelect.innerHTML =
                                        '<option value="" selected>Chọn Phường/Xã</option>';
                                    data.wards.forEach(ward => {
                                        wardSelect.innerHTML +=
                                            `<option value="${ward.name}">${ward.name}</option>`;
                                    });
                                });
                        }
                    });
            }

            loadProvinces();

            provinceSelect.addEventListener("change", function() {
                const provinceName = this.value;
                if (provinceName) {
                    loadDistricts(provinceName);
                } else {
                    districtSelect.innerHTML = '<option value="" selected>Chọn Quận/Huyện</option>';
                    wardSelect.innerHTML = '<option value="" selected>Chọn Phường/Xã</option>';
                }
            });

            districtSelect.addEventListener("change", function() {
                const districtName = this.value;
                if (districtName) {
                    loadWards(districtName);
                } else {
                    wardSelect.innerHTML = '<option value="" selected>Chọn Phường/Xã</option>';
                }
            });
        });
    </script>
@endsection
