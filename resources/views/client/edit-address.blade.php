@extends('app')

@section('content')
    <section class="edit-address-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <a href="{{ route('client.profile') }}">Trở lại</a>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Chỉnh sửa địa chỉ</h3>
                            <form action="{{ route('client.updateAddress', $address->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-floating mb-3">
                                    <select name="province_id" class="form-select" id="province" required>
                                        <option value="">Chọn Tỉnh/Thành</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $province->id == $address->province_id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="province">Tỉnh/Thành</label>
                                    @error('province_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="district_id" class="form-select" id="district" required>
                                        <option value="">Chọn Quận/Huyện</option>
                                    </select>
                                    <label for="district">Quận/Huyện</label>
                                    @error('district_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="ward_id" class="form-select" id="ward" required>
                                        <option value="">Chọn Phường/Xã</option>
                                    </select>
                                    <label for="ward">Phường/Xã</label>
                                    @error('ward_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="address_detail" class="form-control" id="address_detail" value="{{ old('address_detail', $address->address_detail) }}" required>
                                    <label for="address_detail">Địa chỉ chi tiết</label>
                                    @error('address_detail')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Cập nhật địa chỉ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            const provinceId = '{{ $address->province_id ?? '' }}';
            const districtId = '{{ $address->district_id ?? '' }}';
            const wardId = '{{ $address->ward_id ?? '' }}';


            function loadDistricts(provinceId) {
                if (!provinceId) {
                    $('#district').html('<option value="">Chọn Quận/Huyện</option>');
                    $('#ward').html('<option value="">Chọn Phường/Xã</option>');
                    return;
                }

                $.ajax({
                    url: '/get-districts/' + provinceId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let options = '<option value="">Chọn Quận/Huyện</option>';
                        $.each(data, function(index, district) {
                            const selected = district.id == districtId ? 'selected' : '';
                            options += `<option value="${district.id}" ${selected}>${district.name}</option>`;
                        });
                        $('#district').html(options);

                        if (districtId) {
                            loadWards(districtId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading districts:', xhr.status, error);
                        $('#district').html('<option value="">Lỗi tải Quận/Huyện</option>');
                    }
                });
            }

            function loadWards(districtId) {
                if (!districtId) {
                    $('#ward').html('<option value="">Chọn Phường/Xã</option>');
                    return;
                }

                $.ajax({
                    url: '/get-wards/' + districtId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let options = '<option value="">Chọn Phường/Xã</option>';
                        $.each(data, function(index, ward) {
                            const selected = ward.id == wardId ? 'selected' : '';
                            options += `<option value="${ward.id}" ${selected}>${ward.name}</option>`;
                        });
                        $('#ward').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading wards:', xhr.status, error);
                        $('#ward').html('<option value="">Lỗi tải Phường/Xã</option>');
                    }
                });
            }

            $('#province').on('change', function() {
                const newProvinceId = $(this).val();
                loadDistricts(newProvinceId);
            });

            $('#district').on('change', function() {
                const newDistrictId = $(this).val();
                loadWards(newDistrictId);
            });

            if (provinceId) {
                loadDistricts(provinceId);
            } else {
                console.error('No provinceId provided');
            }
        });
    </script>
@endsection
