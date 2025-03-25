@extends('app')

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
                                    <select name="province_id" class="form-select @error('province_name') is-invalid @enderror" id="province" required>
                                        <option value="" selected>Chọn Tỉnh/Thành</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="province">Tỉnh/Thành</label>
                                    @error('province_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="district_id" class="form-select @error('district_name') is-invalid @enderror" id="district" required>
                                        <option value="" selected>Chọn Quận/Huyện</option>
                                    </select>
                                    <label for="district">Quận/Huyện</label>
                                    @error('district_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="ward_id" class="form-select @error('ward_name') is-invalid @enderror" id="ward" required>
                                        <option value="" selected>Chọn Phường/Xã</option>
                                    </select>
                                    <label for="ward">Phường/Xã</label>
                                    @error('ward_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="address_detail" class="form-control @error('address') is-invalid @enderror" value="{{ old('address_detail', '') }}" required>
                                    <label for="address_detail">Địa chỉ chi tiết</label>
                                    @error('address')
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
                                $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            $('#ward').empty();
                            $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                        }
                    });
                } else {
                    $('#district').empty();
                    $('#district').append('<option value="">Chọn Quận/Huyện</option>');
                    $('#ward').empty();
                    $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                }
            });

            $('#district').change(function() {
                var districtId = $(this).val();
                if (districtId) {
                    $.ajax({
                        url: '/get-wards/' + districtId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#ward').empty();
                            $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                            $.each(data, function(key, value) {
                                $('#ward').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#ward').empty();
                    $('#ward').append('<option value="">Chọn Phường/Xã</option>');
                }
            });
        });
    </script>
@endsection
