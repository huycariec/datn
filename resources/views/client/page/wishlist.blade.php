@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


@extends('app')

@section('content')
<!-- Breadcrumb Section -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Danh sách yêu thích</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Yêu thích</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Breadcrumb Section -->

<!-- Wishlist Section -->
<section class="wishlist-section">
    <div class="container-fluid-lg">
        <div class="row">
            @if($wishlist->isEmpty())
                <div class="col-12 text-center">
                    <img src="https://nhuachaua.com/images/gio-hang-trong.jpg" alt="" ><h4>Chưa có sản phẩm nào trong danh sách yêu thích.</h4>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Quay lại mua sắm</a>
                </div>
            @else
                @foreach ($wishlist as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-card">
                            <a href="{{ route('product.detail', $item->product->id) }}">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid" alt="{{ $item->product->name }}">
                            </a>
                            <div class="product-info">
                                <h4>{{ $item->product->name }}</h4>
                                <p>Giá: {{ number_format($item->product->price, 0, ',', '.') }} VNĐ</p>
                                
                                <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="wishlist-btn">
        <i class="fas fa-heart text-danger"></i> Xóa khỏi yêu thích
    </button>
</form>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Wishlist Section -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".wishlist-btn").forEach((button) => {
            button.addEventListener("click", function () {
                let productId = this.getAttribute("data-product-id");
                let card = this.closest(".product-card");

                fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ product_id: productId }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "removed") {
                        card.remove(); // Xóa sản phẩm khỏi danh sách
                    }
                });
            });
        });
    });
</script>

@endsection
