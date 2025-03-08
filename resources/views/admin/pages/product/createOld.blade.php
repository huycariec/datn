@extends("admin.app")
@section("content")
<div class="container-fluid  mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-8 m-auto">
                <form action="{{route('admin.product.store')}}" class="theme-form theme-form-2 mega-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card" >
                        <div class="card-body mt-5 mb-5">
                            <div class="card-header-2">
                                <h5>Thông tin sản phẩm</h5>
                            </div>
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Tên sản phẩm</label>
                                    <div class="col-sm-9">
                                        <input name="product_name" class="form-control" type="text" placeholder="Tên sản phẩm"></div>
                                        @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                </div>
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Mô tả ngắn sản phẩm</label>
                                    <div class="col-sm-9">
                                        <input name="description" class="form-control" type="text" placeholder="Mô tả ngắn sản phẩm">
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="mb-4 row align-items-center">
                                    <label
                                        class="col-sm-3 col-form-label form-label-title">Danh mục sản phẩm</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single w-100" name="state">
                                            <option disabled>Menu Danh mục</option>
                                            <option>Electronics</option>
                                            <option>TV & Appliances</option>
                                            <option>Home & Furniture</option>
                                            <option>Another</option>
                                            <option>Baby & Kids</option>
                                            <option>Health, Beauty & Perfumes</option>
                                            <option>Uncategorized</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4 row align-items-center">
                                    <label
                                        class="col-sm-3 col-form-label form-label-title">Thương hiệu</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single w-100">
                                            <option disabled>Menu Thương hiệu</option>
                                            <option value="puma">Puma</option>
                                            <option value="hrx">HRX</option>
                                            <option value="roadster">Roadster</option>
                                            <option value="zara">Zara</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label form-label-title">Đơn vị khối lượng</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single w-100">
                                            <option disabled>Unit Menu</option>
                                            <option>Kilogram</option>
                                            <option>Pieces</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Ảnh sản phẩm</h5>
                            </div>
                                <div class="mb-4 row align-items-center">
                                    <label
                                        class="col-sm-3 col-form-label form-label-title">Images</label>
                                    <div class="col-sm-9">
                                        <input name="product_image" class="form-control form-choose" type="file" id="formFile" multiple>
                                    </div>
                                    @error('product_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Chọn loại sản phẩm</h5>
                            </div>
                    
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_type" id="simpleProduct" value="simple" checked>
                                <label class="form-check-label" for="simpleProduct">
                                    Sản phẩm đơn
                                </label>
                            </div>
                    
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_type" id="variableProduct" value="variable">
                                <label class="form-check-label" for="variableProduct">
                                    Sản phẩm biến thể
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Inventory (Ẩn mặc định) -->
                    <div class="card" id="productInventoryCard" style="display: none;">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Biến thể sản phẩm</h5>
                            </div>

                            @if (isset($attributes) && !empty($attributes))
                                <div id="variantContainer">
                                    @foreach($combinations as $index => $combination)
                                        <div class="form-group d-flex flex-wrap align-items-center gap-3 variant-item border p-3 mb-2">
                                            <!-- Nhóm 1: Các thuộc tính (màu sắc, size, ...) -->
                                            <div class="d-flex flex-wrap gap-3">
                                                @foreach($combination as $key => $value)
                                                    <div>
                                                        <label class="d-block">{{ ucfirst($key) }}</label>
                                                        <input type="text" class="form-control variant-input" name="variants[{{ $index }}][attributes][{{ $key }}]" value="{{ $value }}">
                                                        
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Nhóm 2: Giá, Số lượng và Ảnh -->
                                            <div class="d-flex flex-wrap gap-3 border p-3 rounded">
                                                <div>
                                                    <label class="d-block">Giá</label>
                                                    <input type="number" class="form-control variant-price" name="variants[{{ $index }}][pricing][price]" step="0.01" min="0" placeholder="Nhập giá">
                                                    @error('price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="d-block">Số lượng</label>
                                                    <input type="number" class="form-control variant-quantity" name="variants[{{ $index }}][pricing][stock]" min="0" placeholder="Nhập số lượng">
                                                    @error('variants.*.pricing.stock')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="d-block">Ảnh</label>
                                                    <input type="file" class="form-control variant-image" name="variants[{{ $index }}][pricing][image]">
                                                    @error('variants.*.pricing.image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Nút Xóa -->
                                            <button type="button" class="btn btn-danger btn-remove-variant">Xóa</button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <a href="{{ route('admin.attribute.create') }}" class="btn btn-primary">Thêm thuộc tính cho sản phẩm</a>
                            @endif
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
                    </div>
                    
                </form>
                </div>
            </div>
        </div>
    </div>
</div>   
@endsection
@section('js-custom')
<!-- JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const simpleProduct = document.getElementById("simpleProduct");
        const variableProduct = document.getElementById("variableProduct");
        const productInventoryCard = document.getElementById("productInventoryCard");
        const form = document.querySelector("form");
        const variantContainer = document.getElementById("variantContainer");

        // Ẩn hoặc hiển thị phần biến thể khi chọn loại sản phẩm
        function toggleVariantSection() {
            if (variableProduct.checked) {
                productInventoryCard.style.display = "block";
                enableVariantInputs(true); // Bật lại input nếu chọn sản phẩm biến thể
            } else {
                productInventoryCard.style.display = "none";
                enableVariantInputs(false); // Vô hiệu hóa input nếu chọn sản phẩm đơn
            }
        }

        // Hàm bật/tắt các input của biến thể
        function enableVariantInputs(enable) {
            document.querySelectorAll("#variantContainer input, #variantContainer select").forEach(input => {
                input.disabled = !enable;
            });
        }

        // Khi submit form, nếu là sản phẩm đơn thì loại bỏ dữ liệu biến thể
        form.addEventListener("submit", function () {
            if (simpleProduct.checked) {
                document.querySelectorAll(".variant-item").forEach(variant => variant.remove()); // Xóa tất cả biến thể
            }
        });

        // Lắng nghe sự kiện thay đổi loại sản phẩm
        simpleProduct.addEventListener("change", toggleVariantSection);
        variableProduct.addEventListener("change", toggleVariantSection);

        // Xử lý nút Xóa biến thể
        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("btn-remove-variant")) {
                event.target.closest(".variant-item").remove();
            }
        });

        // Khởi tạo hiển thị đúng khi tải trang
        toggleVariantSection();
    });
</script>

@endsection

