@section('content')
    <section class="add-address-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <a href="{{ route('client.profile') }}">Trở lại</a>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Thêm địa chỉ mới</h3>
                            <form action="{{ route('client.addAddress') }}" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <select name="province_id" class="form-select @error('province_id') is-invalid @enderror" id="province" required>
                                        <option value="" selected>Chọn Tỉnh/Thành</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="province">Tỉnh/Thành</label>
                                    @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="district_id" class="form-select @error('district_id') is-invalid @enderror" id="district" required>
                                        <option value="" selected>Chọn Quận/Huyện</option>
                                    </select>
                                    <label for="district">Quận/Huyện</label>
                                    @error('district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="ward_id" class="form-select @error('ward_id') is-invalid @enderror" id="ward" required>
                                        <option value="" selected>Chọn Phường/Xã</option>
                                    </select>
                                    <label for="ward">Phường/Xã</label>
                                    @error('ward_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="address_detail" class="form-control @error('address_detail') is-invalid @enderror" value="{{ old('address_detail', '') }}" required>
                                    <label for="address_detail">Địa chỉ chi tiết</label>
                                    @error('address_detail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Thêm địa chỉ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const provinceId = '{{ old('province_id', $address->province_id ?? '') }}';
            const districtId = '{{ old('district_id', $address->district_id ?? '') }}';
            const wardId = '{{ old('ward_id', $address->ward_id ?? '') }}';

            // Tải quận khi chọn tỉnh
            $('#province').change(function() {
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        url: '/get-districts/' + provinceId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#district').empty();
                            $('#district').append('<option value="">Chọn Quận/Huyện</option>');
                            $.each(data, function(key, value) {
                                const selected = value.id == districtId ? 'selected' : '';
                                $('#district').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                            });
                            $('#ward').empty();
                            $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                            if (districtId) {
                                loadWards(districtId);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading districts:', xhr.status, error);
                        }
                    });
                } else {
                    $('#district').empty();
                    $('#district').append('<option value="">Chọn Quận/Huyện</option>');
                    $('#ward').empty();
                    $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                }
            });

            // Tải phường khi chọn quận
            $('#district').change(function() {
                var districtId = $(this).val();
                if (districtId) {
                    loadWards(districtId);
                } else {
                    $('#ward').empty();
                    $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                }
            });

            function loadWards(districtId) {
                $.ajax({
                    url: '/get-wards/' + districtId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#ward').empty();
                        $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                        $.each(data, function(key, value) {
                            const selected = value.id == wardId ? 'selected' : '';
                            $('#ward').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading wards:', xhr.status, error);
                    }
                });
            }

            // Tự động chọn tỉnh, quận, phường
            if (provinceId) {
                $('#province').val(provinceId).change();
            }
            if (districtId) {
                $('#district').val(districtId).change();
            }
            if (wardId) {
                $('#ward').val(wardId);
            }
        });
    </script>
@endsection
<style>
    /* Điều chỉnh khoảng cách cho content */
.content-area {
    margin-left: 250px; /* Chiều rộng của sidebar */
    padding: 20px;
    width: calc(100% - 250px); /* Đảm bảo nội dung không bị che khuất */
}

/* Điều chỉnh cho các dropdown trong form */
.add-address-section .form-floating {
    margin-bottom: 1.5rem;
}

/* Sửa kích thước bảng và dropdown để chúng vừa với màn hình */
.form-select {
    width: 100%;
    padding: 0.75rem;
    font-size: 1rem;
    border-radius: 0.375rem;
}

/* Đảm bảo các dropdown không bị che khuất */
.select2-container--default .select2-selection--single {
    height: 38px !important;
}

</style>
