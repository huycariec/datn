@extends("admin.app")
<style>
    /* Căn giữa switch button trong bảng */
    .table td {
        vertical-align: middle; /* Căn giữa theo chiều dọc */
        text-align: center; /* Căn giữa theo chiều ngang */
    }

    /* Đảm bảo switch button không bị lệch */
    .switch {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Căn giữa thanh trượt */
    .switch input {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .slider {
        position: relative;
        display: inline-block;
        width: 45px;
        height: 24px;
        background-color: #ccc;
        border-radius: 34px;
        transition: 0.4s;
    }

    .slider:before {
        content: "";
        position: absolute;
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    /* Khi bật switch */
    input:checked + .slider {
        background-color: #28a745;
    }

    input:checked + .slider:before {
        transform: translateX(20px);
    }


</style>
@section("content")
<!-- Container-fluid starts-->
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        @if (session('success'))
                            <div id="alert-message" class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3" role="alert">
                                {{ session('success') }}
                            </div>

                            <script>
                                setTimeout(() => {
                                    let alertBox = document.getElementById('alert-message');
                                    if (alertBox) {
                                        alertBox.style.transition = "opacity 1s";
                                        alertBox.style.opacity = "0";
                                        setTimeout(() => alertBox.remove(), 1000);
                                    }
                                }, 5000);
                            </script>
                        @endif
                        <div class="mt-5 mb-5">
                            <h3 class="fw-bold text-center text-primary mb-4 display-4">Chi Tiết Sản Phẩm</h3>
                            <hr>
                            <div class="row">
                                <!-- Ảnh sản phẩm -->
                                <div class="col-md-5">
                                    @if($product->images->count() > 1)
                                        <!-- Carousel nếu có nhiều ảnh -->
                                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($product->images as $key => $image)
                                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                        <img src="{{ Storage::url($image->url) }}" class="d-block w-100 rounded" alt="Ảnh sản phẩm">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        </div>
                                    @else
                                        <!-- Nếu chỉ có 1 ảnh -->
                                        <img src="{{ Storage::url($product->images->first()->url ?? 'https://via.placeholder.com/400') }}" 
                                             class="img-fluid rounded w-100" alt="Ảnh sản phẩm">
                                    @endif
                                </div>
                        
                                <!-- Thông tin sản phẩm -->
                                <div class="col-md-7">
                                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
                        
                                    <p class="text-danger fs-4 fw-bold mb-3">
                                        {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                    </p>
                        
                                    <!-- Mô tả ngắn -->
                                    <div class="border p-3 rounded mb-3 shadow-sm">
                                        <p class="text-muted mb-2"><strong>Mô tả ngắn:</strong></p>
                                        <p>{!! $product->short_description !!}</p>
                                    </div>
                        
                                    <!-- Danh mục sản phẩm -->
                                    <div class="mb-3">
                                        <p class="text-muted"><strong>Danh mục:</strong> {{ $product->category->name ?? 'Chưa có danh mục' }}</p>
                                    </div>
                        
                                    <!-- Trạng thái sản phẩm -->
                                    <div class="mb-3">
                                        <p class="text-muted"><strong>Trạng thái:</strong> 
                                            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->is_active ? 'Đang bán' : 'Tắt bán' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Mô tả chi tiết -->
                            <div class="mt-4">
                                <h4 class="fw-bold">Mô tả chi tiết</h4>
                                <div class="border p-4 bg-white shadow-sm rounded">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Danh sách biến thể sản phẩm -->
                        <div class="title-header option-title d-sm-flex justify-content-between align-items-center mt-4">
                            <h5>Danh Sách Biến Thể Sản Phẩm: {{$product->name}}</h5>
                            <div class="right-options">
                                <button id="toggleVariantForm" class="btn btn-primary">Thêm Mới Biến Thể</button>
                            </div>
                        </div>
                        <hr>

                        
                        <div id="variantContainer" class="d-none">
                                <div class="form-group d-flex flex-wrap align-items-center gap-3 variant-item border p-3 mb-2">
                                    <!-- Nhóm 1: Các thuộc tính (màu sắc, size, ...) -->
                                        <form id="variant-form" action="{{ route('admin.variant.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="product_id" id="" value="{{$product->id}}">
                                            @php
                                                $attributeNames = collect();
                                            @endphp
                                        
                                            @foreach($product->variants as $variant)
                                                @foreach ($variant->variantAttributes as $variantAttribute)
                                                    @php
                                                        $attribute = optional($variantAttribute->attributeValue->attribute);
                                                        $attributeId = $attribute->id ?? null;
                                                        $attributeName = $attribute->name ?? null;
                                                    @endphp
                                        
                                                    @if ($attributeId && !$attributeNames->contains($attributeId))
                                                        <div class="variant-group">
                                                            <label class="d-block">{{ $attributeName }}</label>
                                                            <input type="text" class="form-control variant-input" name="variants[attributes][{{ $attributeId }}]" required>
                                                        </div>
                                                        @php
                                                            $attributeNames->push($attributeId);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        <div>
                                            <label class="d-block">Giá</label>
                                            <input type="number" class="form-control variant-price" name="variants[price]" step="0.01" min="0" placeholder="Nhập giá">
                                            <span class="text-danger" id="error_price"></span>
                                        </div>

                                        <div>
                                            <label class="d-block">Số lượng</label>
                                            <input type="number" class="form-control variant-quantity" name="variants[stock]" min="0" placeholder="Nhập số lượng">
                                            @error('variants.*.pricing.stock')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="d-block">Ảnh</label>
                                            <input type="file" class="form-control variant-image" name="variants[image]">
                                            @error('variants.*.pricing.image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Thêm mới biến thể</button>

                                </div>
                            </div>
                            </form>
                        <div>
                            <div class="table-responsive">
                                <table class="table all-package theme-table table-product" id="table_id">
                                    <thead>
                                        <tr>
                                            <th>Ảnh</th>
                                            <th>ID Sản Phẩm</th>
                                            <th>SKU</th>
                                            <th>
                                                @php
                                                    $attributeNames = collect();
                                                @endphp                                          
                                                @foreach($product->variants as $variant)
                                                    @foreach ($variant->variantAttributes as $variantAttribute)
                                                        @php
                                                            $attributeName = optional($variantAttribute->attributeValue->attribute)->name;
                                                        @endphp
                                            
                                                        @if ($attributeName && !$attributeNames->contains($attributeName))
                                                            {{ $attributeName }}
                                                            @php
                                                                $attributeNames->push($attributeName);
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endforeach                                                           
                                            </th>
                                            <th>Giá biến thể sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Trạng thái</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->variants as $variant)
                                        <tr>           
                                            <td>
                                                @if ($variant->images->isNotEmpty())
                                                    @foreach ($variant->images as $image)
                                                        <img src="{{ Storage::url($image->url) }}" alt="Ảnh biến thể {{ $variant->name }}" width="100">
                                                        @endforeach
                                                    @else
                                                        <p>Không có hình ảnh cho biến thể này.</p>
                                                @endif
                                            </td>
                                            <td>{{$product->id}}</td>
                                            <td>{{$variant->sku}}</td>
                                            {{-- <tr class="variant-row"> --}}
                                            <td class="variant-attributes">
                                                 @foreach ($variant->variantAttributes as $variantAttribute)
                                                    {{ $variantAttribute->attributeValue->value }}
                                                @endforeach
                                            </td>
                                            <td class="td-price">{{ number_format($variant->price, 0, ',', '.') }}</td>

                                            <td class="td-price">{{$variant->stock}}</td>
                                            <td>
                                                <label class="switch">
                                                  <input type="checkbox" class="status-toggle" data-id="{{ $variant->id }}" {{ $variant->is_active ? 'checked' : '' }}>
                                                  <span class="slider round"></span>
                                                </label>
                                              </td>
                                              
                                            <td>
                                                <ul>
                                                    {{-- <li>
                                                        <a href="order-detail.html">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li> --}}

                                                    <li>
                                                        <a href="{{ route('product.variant.edit', ['id' => $variant->id]) }}">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                    

                                                    <li>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalToggle">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>  
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js-custom')
<script>

    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById("toggleVariantForm");
        const variantContainer = document.getElementById("variantContainer");

        toggleButton.addEventListener("click", function () {
            // Toggle class d-none để ẩn/hiện
            variantContainer.classList.toggle("d-none");
        });


        // Lấy danh sách biến thể hiện có từ Blade (dữ liệu JSON)
        let existingVariants = @json($product->variants->map(function ($variant) {
            return $variant->variantAttributes->map(fn($attr) => $attr->attributeValue->value)->implode('|');
        }));

        console.log("Existing Variants:", existingVariants); // Debug xem có đúng không

        //  Xử lý sự kiện submit
        const form = document.getElementById("variant-form");

        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Ngăn form submit mặc định

            let isValid = true;
            // Lấy dữ liệu nhập vào từ input
            let selectedAttributes = [];
            document.querySelectorAll(".variant-input").forEach(input => {
                selectedAttributes.push(input.value.trim());
            });

            let newVariant = selectedAttributes.join("|"); // Ví dụ: "X|Hồng"

            // Kiểm tra trùng lặp
            if (existingVariants.includes(newVariant)) {
                alert("❌ Biến thể này đã tồn tại! Vui lòng chọn giá trị khác.");
                isValid=false;
            }

            // Validate giá
            let priceInput = document.querySelector(".variant-price");
            if (priceInput && (!priceInput.value.trim() || parseFloat(priceInput.value) <= 0)) {
                alert("❌ Giá sản phẩm phải lớn hơn 0.");
                // error_price.innerHTML = "Giá sản phẩm phải lớn hơn 0";
                isValid = false;
            }
            // Validate số lượng
            let stockInput = document.querySelector(".variant-quantity");
            if (stockInput && (!stockInput.value.trim() || parseInt(stockInput.value) <= 0)) {
                error_stock.innerHTML = "❌ Số lượng sản phẩm phải lớn hơn 0.";
                isValid = false;
            }

            // Validate ảnh
            let imageInput = document.querySelector(".variant-image");
            if (imageInput && imageInput.files.length > 0) {
                let allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                if (!allowedTypes.includes(imageInput.files[0].type)) {
                    error_image.innerHTML = "❌ Ảnh sản phẩm phải có định dạng JPG, PNG hoặc GIF.";
                    isValid = false;
                }
            }

            if(isValid==true){
                this.submit(); // Không trùng thì submit
            }
        });
    });

</script>
<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            var id = $(this).data('id');
            var isActive = $(this).prop('checked') ? 1 : 0;

            $.ajax({
            url: '/update-status/' + id,  // Địa chỉ URL của route cập nhật trạng thái
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                is_active: isActive
            },
            success: function(response) {
                if (response.success) {
                alert('Trạng thái đã được cập nhật!');
                } else {
                alert('Có lỗi xảy ra!');
                }
            }
            });
        });
    });

</script>
@endsection