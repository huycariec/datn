@extends("admin.app")

@section('content')
<section class="shipping-fees-edit-section content-area">
    <div class="container-fluid-lg w-100 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="mb-4 fw-bold text-center text-primary">✏️ Chỉnh sửa phí vận chuyển</h3>

                        <form action="{{ route('admin.updateAddress', $shippingFee->id) }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <!-- Tỉnh/Thành -->
                                <div class="col-md-4">
                                    <label for="province" class="form-label fw-semibold">Tỉnh/Thành</label>
                                    <select name="province_id" id="province" class="form-select @error('province_id') is-invalid @enderror" required>
                                        <option value="">Chọn Tỉnh/Thành</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" @selected($shippingFee->province_id == $province->id)>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quận/Huyện -->
                                <div class="col-md-4">
                                    <label for="district" class="form-label fw-semibold">Quận/Huyện</label>
                                    <select name="district_id" id="district" class="form-select @error('district_id') is-invalid @enderror" required>
                                        <option value="">Chọn Quận/Huyện</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" @selected($shippingFee->district_id == $district->id)>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phường/Xã -->
                                <div class="col-md-4">
                                    <label for="ward" class="form-label fw-semibold">Phường/Xã</label>
                                    <select name="ward_id" id="ward" class="form-select @error('ward_id') is-invalid @enderror" required>
                                        <option value="">Chọn Phường/Xã</option>
                                        @foreach($wards as $ward)
                                            <option value="{{ $ward->id }}" @selected($shippingFee->ward_id == $ward->id)>
                                                {{ $ward->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ward_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phí vận chuyển -->
                                <div class="col-md-12">
                                    <label for="fee" class="form-label fw-semibold">Giá tiền vận chuyển (VNĐ)</label>
                                    <input type="number" name="fee" id="fee" class="form-control @error('fee') is-invalid @enderror" value="{{ old('fee', $shippingFee->fee) }}" required>
                                    @error('fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold">
                                    💾 Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
/* Tránh bị sidebar đè */
.content-area {
    margin-left: 250px;
    padding: 30px;
    background-color: #f8f9fc;
    min-height: 100vh;
}

/* Bo góc card */
.card {
    border-radius: 16px;
}

/* Form label đậm hơn */
.form-label {
    font-size: 15px;
}

/* Input đẹp */
.form-control,
.form-select {
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 15px;
}
</style>

{{-- AJAX dynamic dropdown --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceId = document.getElementById('province').value;
    const districtId = document.getElementById('district').value;

    // Load districts
    if (provinceId) {
        fetch(`/api/get-districts/${provinceId}`)
            .then(res => res.json())
            .then(data => {
                const districtSelect = document.getElementById('district');
                districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                data.forEach(d => {
                    districtSelect.innerHTML += `<option value="${d.id}" ${districtId == d.id ? 'selected' : ''}>${d.name}</option>`;
                });

                document.getElementById('ward').innerHTML = '<option value="">Chọn Phường/Xã</option>';
            });
    }

    // Load wards
    if (districtId) {
        fetch(`/api/get-wards/${districtId}`)
            .then(res => res.json())
            .then(data => {
                const wardSelect = document.getElementById('ward');
                wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                data.forEach(w => {
                    wardSelect.innerHTML += `<option value="${w.id}" ${w.id == {{ $shippingFee->ward_id }} ? 'selected' : ''}>${w.name}</option>`;
                });
            });
    }

    // Tỉnh change
    document.getElementById('province').addEventListener('change', function () {
        fetch(`/api/get-districts/${this.value}`)
            .then(res => res.json())
            .then(data => {
                let district = document.getElementById('district');
                district.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                data.forEach(d => district.innerHTML += `<option value="${d.id}">${d.name}</option>`);
                document.getElementById('ward').innerHTML = '<option value="">Chọn Phường/Xã</option>';
            });
    });

    // Quận change
    document.getElementById('district').addEventListener('change', function () {
        fetch(`/api/get-wards/${this.value}`)
            .then(res => res.json())
            .then(data => {
                let ward = document.getElementById('ward');
                ward.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                data.forEach(w => ward.innerHTML += `<option value="${w.id}">${w.name}</option>`);
            });
    });
});
</script>
