@extends('app')

@section('content')
  <!-- Breadcrumb Section Start -->
  <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>Yêu thích</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Danh sách yêu thích</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
                    <section class="wishlist-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-3 g-2">
            @if($wishlist->isEmpty())
                <div class="col-12 text-center">
                    <img src="https://harshcreation.com/images/emptywishlist.jpg" alt="Danh sách yêu thích trống" class="img-fluid mb-3" style="max-width: 200px;">
                    <h4>Chưa có sản phẩm nào trong danh sách yêu thích.</h4>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3 px-4 py-2 fw-bold shadow-lg rounded-pill">
    Quay lại mua sắm
</a>
                </div>
            @else
                @foreach ($wishlist as $item)
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-6 product-box-contain">
                        <div class="product-box-3 h-100">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="{{ route('product.detail', $item->product->id) }}">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid blur-up lazyloaded" alt="{{ $item->product->name }}">
                                    </a>
                                    <div class="product-header-top">
                                        <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn wishlist-button close_button">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">{{ $item->product->category->name ?? 'Danh mục khác' }}</span>
                                    <a href="{{ route('product.detail', $item->product->id) }}">
                                        <h5 class="name">{{ $item->product->name }}</h5>
                                    </a>
                                    <h6 class="unit mt-1">{{ $item->product->unit ?? '1 item' }}</h6>
                                    <h5 class="price">
                                        <span class="theme-color">{{ number_format($item->product->price, 0, ',', '.') }} VNĐ</span>
                                        @if($item->product->old_price)
                                            <del>{{ number_format($item->product->old_price, 0, ',', '.') }} VNĐ</del>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@endsection