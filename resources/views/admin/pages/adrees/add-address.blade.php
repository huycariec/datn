@extends("admin.app")

@section('content')
<section class="add-address-section section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <a href="">Trở lại</a>
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Thêm</h3>
                        <form action="{{ route('admin.add.addAddressForm') }}" method="POST">
                            @csrf

                            {{-- Tỉnh --}}
                            <div class="form-floating mb-3">
                                <select name="province_id" class="form-select @error('province_id') is-invalid @enderror" id="province" required>
                                    <option value="" selected>Chọn Tỉnh/Thành</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                <label for="province">Tỉnh/Thành</label>
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Quận --}}
                            <div class="form-floating mb-3">
                                <select name="district_id" class="form-select @error('district_id') is-invalid @enderror" id="district" required>
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                                <label for="district">Quận/Huyện</label>
                                @error('district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Xã --}}
                            <div class="form-floating mb-3">
                                <select name="ward_id" class="form-select @error('ward_id') is-invalid @enderror" id="ward" required>
                                    <option value="">Chọn Phường/Xã</option>
                                </select>
                                <label for="ward">Phường/Xã</label>
                                @error('ward_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giá tiền --}}
                            <div class="form-floating mb-3">
                                <input type="number" name="fee" class="form-control @error('fee') is-invalid @enderror" value="{{ old('fee') }}" required>
                                <label for="fee">Giá tiền vận chuyển</label>
                                @error('fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Ajax --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const oldProvince = '{{ old('province_id') }}';
        const oldDistrict = '{{ old('district_id') }}';
        const oldWard = '{{ old('ward_id') }}';

        function fetchDistricts(provinceId, selectedId = null) {
            $.get('/get-districts/' + provinceId, function (data) {
                $('#district').empty().append('<option value="">Chọn Quận/Huyện</option>');
                $.each(data, function (key, value) {
                    let selected = selectedId == value.id ? 'selected' : '';
                    $('#district').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                });
            });
        }

        function fetchWards(districtId, selectedId = null) {
            $.get('/get-wards/' + districtId, function (data) {
                $('#ward').empty().append('<option value="">Chọn Phường/Xã</option>');
                $.each(data, function (key, value) {
                    let selected = selectedId == value.id ? 'selected' : '';
                    $('#ward').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                });
            });
        }

        // Khi chọn tỉnh
        $('#province').change(function () {
            let provinceId = $(this).val();
            if (provinceId) {
                fetchDistricts(provinceId);
                $('#ward').empty().append('<option value="">Chọn Phường/Xã</option>');
            }
        });

        // Khi chọn quận
        $('#district').change(function () {
            let districtId = $(this).val();
            if (districtId) {
                fetchWards(districtId);
            }
        });

        // Nếu có dữ liệu cũ thì tự động load lại sau lỗi
        if (oldProvince) {
            fetchDistricts(oldProvince, oldDistrict);
        }
        if (oldDistrict) {
            fetchWards(oldDistrict, oldWard);
        }
    });
</script>
@endsection
