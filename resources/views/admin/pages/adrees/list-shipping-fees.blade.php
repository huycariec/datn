@extends("admin.app")

@section('content')
<section class="shipping-fees-list-section section-b-space mt-5 content-area">
    <div class="container-fluid-lg w-100">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm rounded">
                    <div class="card-body">


                        <h3 class="mb-4 fw-bold text-center mt-5">Danh sách phí vận chuyển</h3>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Tỉnh/Thành</th>
                                        <th style="width: 20%;">Quận/Huyện</th>
                                        <th style="width: 20%;">Phường/Xã</th>
                                        <th style="width: 15%;">Giá tiền</th>
                                        <th style="width: 20%;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shippingFees as $shippingFee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $shippingFee->province->name }}</td>
                                        <td>{{ $shippingFee->district->name }}</td>
                                        <td>{{ $shippingFee->ward->name }}</td>
                                        <td>{{ number_format($shippingFee->fee, 0, ',', '.') }} VND</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <!-- Nút chỉnh sửa -->
                                                <a href="{{ route('admin.editAddressForm', $shippingFee->id) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3 d-flex align-items-center gap-1">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>

                                                <!-- Nút xoá -->
                                                <form action="{{ route('admin.deleteAddress', $shippingFee->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xoá phí vận chuyển này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3 d-flex align-items-center gap-1">
                                                        <i class="fas fa-trash-alt"></i> Xoá
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $shippingFees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    background-color: #f8f9fa;
    z-index: 1000;
}

.content-area {
    margin-left: 250px;
    padding: 100px 20px 20px; /* 100px để tránh đè lên bởi header cố định */
    width: calc(100% - 250px);
}
.table th,
.table td {
    vertical-align: middle;
    word-wrap: break-word;
    white-space: normal;
}

.shipping-fees-list-section {
    margin-top: 20px;
}
.shipping-title {
    margin-top: 60px; /* hoặc 80px tuỳ bạn */
    text-align: center;
    font-weight: bold;
}
</style>
@endpush

@push('scripts')
<!-- Font Awesome nếu chưa có -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
