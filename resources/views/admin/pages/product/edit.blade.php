@extends("admin.app")
@section("css")
<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }

</style>
@endsection
@section("content")
<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-8 m-auto">
                    <form action="{{ route('admin.product.update', $product->id) }}" class="theme-form theme-form-2 mega-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Sử dụng PUT để cập nhật -->

                        <!-- Thông tin sản phẩm -->
                        <div class="card">
                            <div class="card-body mt-5 mb-5">
                                <div class="card-header-2">
                                    <h5>Thông tin sản phẩm</h5>
                                </div>

                                <!-- Tên sản phẩm -->
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Tên sản phẩm</label>
                                    <div class="col-sm-9">
                                        <input name="product_name" class="form-control" type="text" placeholder="Tên sản phẩm" value="{{ old('product_name', $product->name) }}" required>
                                    </div>
                                </div>

                                <!-- Mô tả ngắn sản phẩm -->
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Mô tả ngắn sản phẩm</label>
                                    <div class="col-sm-9">
                                        <textarea id="short_description" name="short_description" class="form-control" placeholder="Mô tả ngắn sản phẩm">{{ old('short_description', $product->short_description) }}</textarea>
                                    </div>
                                </div>

                                <!-- Mô tả chi tiết -->
                                <div class="mb-4 row">
                                    <label class="form-label-title col-sm-3 mb-0">Mô tả chi tiết</label>
                                    <div class="col-sm-9">
                                        <textarea id="description" name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>

                                <!-- Danh mục sản phẩm -->
                                <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label form-label-title">Danh mục sản phẩm</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single w-100" name="category_id" required>
                                            <option disabled>Chọn danh mục</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category->id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Thương hiệu sản phẩm -->
                                {{-- <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label form-label-title">Thương hiệu</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single w-100" name="brand_id" required>
                                            <option disabled>Chọn thương hiệu</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('brand_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <!-- Đơn vị khối lượng -->
                                <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label form-label-title">Đơn vị khối lượng</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single w-100" name="weight_unit" required>
                                            <option disabled>Chọn đơn vị</option>
                                            <option value="kg" {{ old('weight_unit', $product->weight_unit) == 'kg' ? 'selected' : '' }}>Kilogram</option>
                                            <option value="pcs" {{ old('weight_unit', $product->weight_unit) == 'pcs' ? 'selected' : '' }}>Pieces</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ảnh sản phẩm -->
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header-2">
                                    <h5>Ảnh sản phẩm</h5>
                                </div>
                                <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label form-label-title">Ảnh</label>
                                    <div class="col-sm-9">
                                        <input name="product_image[]" class="form-control form-choose" type="file" id="formFile" multiple>
                                    </div>
                                    @error('product_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="row">
                                    @foreach($product->images as $image)
                                        <div class="col-sm-2">
                                            <img src="{{ Storage::url($image->url) }}" class="img-thumbnail" alt="Ảnh sản phẩm">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Lưu sản phẩm -->
                        <div id="form-error-summary" class="alert alert-danger d-none" role="alert">
                            <ul class="mb-0" id="error-list"></ul>
                        </div>
                        
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 
@endsection
@section('js-custom')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        form.addEventListener("submit", function(e) {
            // Xóa hết các lỗi cũ (nếu có)
            document.querySelectorAll(".client-error").forEach(el => el.remove());
            
            // Lấy trường "Tên sản phẩm"
            const productName = document.querySelector('input[name="product_name"]');
            
            // Kiểm tra nếu trường trống
            if (!productName.value.trim()) {
                // Ngăn form submit
                e.preventDefault();
                
                // Tạo phần tử hiển thị lỗi
                const errorEl = document.createElement("div");
                errorEl.className = "text-danger client-error mt-1";
                errorEl.innerText = "Tên sản phẩm không được để trống.";
                
                // Chèn lỗi ngay dưới input, bên trong thẻ chứa (div.col-sm-9)
                productName.parentNode.appendChild(errorEl);
                
                // Đưa focus vào input lỗi
                productName.focus();
            }
        });
    });
    </script>
    
    <!-- JavaScript -->
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'advlist autolink lists link charmap print preview anchor',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
            menubar: false
        });
    </script>

@endsection

