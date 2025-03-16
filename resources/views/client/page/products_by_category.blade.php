@extends('app')

@section('content')
    <div class="container">
        <h2>Sản phẩm trong danh mục: {{ $category->name }}</h2>

        @if ($products->isEmpty())
            <p>Không có sản phẩm nào trong danh mục này.</p>
        @else
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text"><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                                <p class="card-text"><strong>Lượt xem:</strong> {{ $product->view }}</p>
                                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <a href="{{ route('home') }}" class="btn btn-secondary">Quay lại trang chủ</a>
    </div>
@endsection