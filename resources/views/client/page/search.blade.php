@extends('app')
@section('css')
<style>
    .hover-shadow:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-3px);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>

@endsection
@section('content')
<div class="container">
    <h5 class="text-center mb-4">
        Kết quả tìm kiếm cho từ khóa: <strong class="text-primary">{{ $keyword }}</strong>
    </h5>

    @if($products->count())
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm transition-all hover-shadow position-relative rounded-4 overflow-hidden">

                    <div class="ratio ratio-4x3">
                        <img src="{{ optional($product->images->first())->url ? Storage::url($product->images->first()->url) : asset('images/no-image.png') }}"
                            class="card-img-top p-2"
                            alt="{{ $product->name }}"
                            style="object-fit: contain;">
                    </div>

                    <div class="card-body text-center d-flex flex-column justify-content-between">

                        {{-- Tên sản phẩm nổi bật --}}
                        <h5 class="card-title fw-bold mb-2 text-truncate" style="min-height: 40px;">
                            {{ $product->name }}
                        </h5>

                        {{-- Mô tả ngắn --}}
                        <p class="text-muted small mb-2" style="min-height: 35px;">
                            {{ \Illuminate\Support\Str::limit(strip_tags($product->short_description), 50) }}
                        </p>

                        {{-- Giá nổi bật --}}
                        <p class="mb-2">
                            <span class="text-danger fw-bold fs-5 me-2">
                                {{ number_format($product->price, 0, ',', '.') }} đ
                            </span>
                            @if($product->price_old)
                                <span class="text-muted text-decoration-line-through small">
                                    {{ number_format($product->price_old, 0, ',', '.') }} đ
                                </span>
                            @endif
                        </p>

                        {{-- Danh mục in rõ ràng --}}
                        @if($product->category)
                            <p class="small text-muted mb-2">
                                <i class="fa fa-folder-open me-1"></i> Danh mục: {{ $product->category->name }}
                            </p>
                        @endif

                        {{-- Nút xem chi tiết --}}
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary w-100">
                                Xem chi tiết
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
@else
    <p class="text-center text-muted">Không tìm thấy sản phẩm phù hợp.</p>
@endif



</div>



@endsection