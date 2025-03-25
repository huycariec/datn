@extends('app')

@section('content')
    <section class="edit-address-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Chỉnh sửa địa chỉ</h3>
                            <form action="{{ route('client.updateAddress', $address->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-floating mb-3">
                                    <select name="province_name" class="form-select @error('province_name') is-invalid @enderror" id="province" required>
                                        <option value="" selected>Chọn Tỉnh/Thành</option>
                                    </select>
                                    <label for="province">Tỉnh/Thành</label>
                                    @error('province_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="district_name" class="form-select @error('district_name') is-invalid @enderror" id="district" required>
                                        <option value="" selected>Chọn Quận/Huyện</option>
                                    </select>
                                    <label for="district">Quận/Huyện</label>
                                    @error('district_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="ward_name" class="form-select @error('ward_name') is-invalid @enderror" id="ward" required>
                                        <option value="" selected>Chọn Phường/Xã</option>
                                    </select>
                                    <label for="ward">Phường/Xã</label>
                                    @error('ward_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $address->address_detail ?? '') }}" required>
                                    <label for="address">Địa chỉ chi tiết</label>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Lưu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                            const selected = province.name === "{{ $address->province->name ?? '' }}" ? "selected" : "";
                            provinceSelect.innerHTML += `<option value="${province.name}" ${selected}>${province.name}</option>`;
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
                                    districtSelect.innerHTML = '<option value="" selected>Chọn Quận/Huyện</option>';
                                    wardSelect.innerHTML = '<option value="" selected>Chọn Phường/Xã</option>';
                                    data.districts.forEach(district => {
                                        const selected = district.name === "{{ $address->district->name ?? '' }}" ? "selected" : "";
                                        districtSelect.innerHTML += `<option value="${district.name}" ${selected}>${district.name}</option>`;
                                    });
                                    if ("{{ $address->district->name ?? '' }}") {
                                        loadWards("{{ $address->district->name }}");
                                    }
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
                                    wardSelect.innerHTML = '<option value="" selected>Chọn Phường/Xã</option>';
                                    data.wards.forEach(ward => {
                                        const selected = ward.name === "{{ $address->ward->name ?? '' }}" ? "selected" : "";
                                        wardSelect.innerHTML += `<option value="${ward.name}" ${selected}>${ward.name}</option>`;
                                    });
                                });
                        }
                    });
            }

            loadProvinces();
            if ("{{ $address->province->name ?? '' }}") {
                loadDistricts("{{ $address->province->name }}");
            }

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
