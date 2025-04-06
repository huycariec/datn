@extends("admin.app")

@section("content")
<div class="container mt-5">
    <h2 class="mb-4">Chỉnh sửa Biến thể Sản phẩm</h2>

    <form id="update-variant-form" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        {{-- ID Variant --}}
        <input type="hidden" id="variant_id" value="{{ $variant->id }}">

        <h3 class="mb-4 text-primary fw-bold">Cập nhật Biến thể Sản phẩm</h3>

        {{-- Ảnh Biến Thể --}}
        <div class="mb-4">
            <h5 class="fw-bold mb-3">Ảnh Biến Thể:</h5>
            <div class="row g-2">
                @foreach ($variant->images as $image)
                    <div class="col-auto">
                        <div class="border rounded overflow-hidden" style="width: 120px; height: 120px;">
                            <img src="{{ Storage::url($image->url) }}" class="img-fluid h-100 w-100 object-fit-cover">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ID Sản phẩm --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">ID Sản phẩm</label>
            <input type="text" class="form-control" value="{{ $variant->id }}" readonly>
        </div>

        {{-- Thuộc tính Biến Thể --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Thuộc tính Biến Thể:</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($attributes as $attr)
                    <div class="form-control d-inline-flex align-items-center gap-1" style="width: auto;">
                        {{ $attr['attribute_name'] }}: {{ $attr['attribute_value'] }}
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Giá --}}
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="text" id="price" class="form-control" value="{{ number_format($variant->price, 0, ',', '.') }}">


        </div>

        {{-- Số lượng --}}
        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="text" id="quantity" class="form-control" value="{{ $variant->stock }}">
        </div>

        <button type="button" onclick="updateVariant()" class="btn btn-success">Cập nhật</button>
    </form>

</div>
@endsection

@section('js-custom')
{{-- Toastr CDN --}}
<script>
    function updateVariant() {
        let id = $('#variant_id').val();
        let price = $('#price').val().trim();
        let quantity = $('#quantity').val().trim();

        if (price === '' || quantity === '') {
            Swal.fire('Lỗi!', 'Vui lòng nhập đầy đủ thông tin!', 'error');
            return;
        }

        if (isNaN(price) || price < 0) {
            Swal.fire('Lỗi!', 'Giá phải là số và >= 0', 'error');
            return;
        }

        if (isNaN(quantity) || quantity < 0) {
            Swal.fire('Lỗi!', 'Số lượng phải là số và >= 0', 'error');
            return;
        }

        $.ajax({
            url: '{{ route("variant.update", "") }}/' + id,

            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                price: price,
                quantity: quantity
            },
            beforeSend: function () {
                Swal.fire({
                    title: 'Đang xử lý...',
                    html: 'Vui lòng chờ trong giây lát!',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function (res) {
                Swal.fire({
                    icon: res.status === 'success' ? 'success' : 'error',
                    title: res.status === 'success' ? 'Thành công!' : 'Lỗi!',
                    text: res.message,
                    showConfirmButton: true,
                }).then(() => {
                    if (res.status === 'success') {
                        location.reload();
                    }
                });
            },
            error: function (xhr) {
                let message = 'Có lỗi xảy ra, vui lòng thử lại!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire('Lỗi!', message, 'error');
            }
        });
    }
</script>

@endsection
