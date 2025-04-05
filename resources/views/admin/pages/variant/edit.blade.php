@extends("admin.app")
@section("content")
<div class="container mt-5">
    <h2 class="mb-4">Chỉnh sửa Biến thể Sản phẩm</h2>
    <form action="/update-product-variant/{{ $variant->id }}" method="POST">
        @csrf
        @method('PUT')
    
        <div class="mb-3">
            <label for="product-id" class="form-label">ID Sản phẩm</label>
            <input type="text" class="form-control" id="product-id" name="product_id" value="{{ $variant->id }}" readonly>
        </div>
    
        <!-- Hiển thị các thuộc tính của sản phẩm -->
        <h4>Thuộc tính biến thể:</h4>
        <ul>
            @foreach ($attributes as $item)
                <li><strong>{{ $item['attribute_name'] }}:</strong> {{ $item['attribute_value'] }}</li>
            @endforeach
        </ul>
        
    
        <!-- Các trường thông tin khác của sản phẩm (giá, số lượng, ảnh, v.v.) -->
        <div class="d-flex gap-3 mb-2 flex-wrap">
            <div class="col-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="pricing[price]" value="{{ $variant->price }}" readonly>
            </div>
            <div class="col-3">
                <label for="stock" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="stock" name="pricing[stock]" value="{{ $variant->stock }}" readonly>
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    
</div>

@endsection