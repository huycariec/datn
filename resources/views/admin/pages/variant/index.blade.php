@extends("admin.app")
@section("content")
<!-- Container-fluid starts-->
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="title-header option-title d-sm-flex d-block">
                            <h5>Danh Sách Biến Thể Sản Phẩm {{$product->name}}</h5>
                            <div class="right-options">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)">import</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Export</a>
                                    </li>
                                    <li>
                                        <button id="toggleVariantForm" class="btn btn-solid">Add Product</button>
                                        {{-- <button class="btn btn-solid">Add Product</button> --}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="variantContainer" class="d-none">
                                <div class="form-group d-flex flex-wrap align-items-center gap-3 variant-item border p-3 mb-2">
                                    <!-- Nhóm 1: Các thuộc tính (màu sắc, size, ...) -->
                                        <form id="variant-form" action="{{ route('admin.variant.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
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
                                            <td class="td-price">{{$variant->price}}</td>
                                            <td class="td-price">{{$variant->stock}}</td>
                                            <td class="status-danger"><span>Pending</span></td>
                                            <td>
                                                <ul>
                                                    {{-- <li>
                                                        <a href="order-detail.html">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li> --}}

                                                    <li>
                                                        <a href="javascript:void(0)">
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
    // document.addEventListener("DOMContentLoaded", function () {
    //     const toggleButton = document.getElementById("toggleVariantForm");
    //     const variantContainer = document.getElementById("variantContainer");

    //     // Ẩn form khi load trang
    //     if (variantContainer) {
    //         variantContainer.classList.add("d-none");
    //     }

    //     if (toggleButton) {
    //         toggleButton.addEventListener("click", function () {
    //             // Toggle class d-none để ẩn/hiện form
    //             variantContainer.classList.toggle("d-none");
    //         });
    //     }

    //     // Lấy danh sách biến thể hiện có từ Blade (dữ liệu JSON)
    //     let existingVariants = @json($product->variants->map(function ($variant) {
    //         return $variant->variantAttributes->map(function ($attr) {
    //             return $attr->attributeValue->value;
    //         })->implode('|');
    //     }));

    //     console.log("Existing Variants:", existingVariants); // Debug kiểm tra dữ liệu

    //     // Xử lý sự kiện submit form
    //     const form = document.getElementById("variant-form");

    //     if (form) {
    //         form.addEventListener("submit", function (event) {
    //             event.preventDefault(); // Ngăn form submit mặc định

    //             let isValid = true;

    //             // Lấy dữ liệu nhập vào từ input
    //             let selectedAttributes = [];
    //             document.querySelectorAll(".variant-input").forEach(input => {
    //                 selectedAttributes.push(input.value.trim());
    //             });

    //             let newVariant = selectedAttributes.join("|"); // Ví dụ: "X|Hồng"

    //             // Kiểm tra trùng lặp biến thể
    //             if (existingVariants.includes(newVariant)) {
    //                 alert("❌ Biến thể này đã tồn tại! Vui lòng chọn giá trị khác.");
    //                 isValid = false;
    //             }

    //             // Validate giá
    //             let priceInput = document.querySelector(".variant-price");
    //             if (priceInput && (!priceInput.value.trim() || parseFloat(priceInput.value) <= 0)) {
    //                 alert("❌ Giá sản phẩm phải lớn hơn 0.");
    //                 isValid = false;
    //             }

    //             // Validate số lượng
    //             let stockInput = document.querySelector(".variant-quantity");
    //             if (stockInput && (!stockInput.value.trim() || parseInt(stockInput.value) <= 0)) {
    //                 alert("❌ Số lượng sản phẩm phải lớn hơn 0.");
    //                 isValid = false;
    //             }

    //             // Validate ảnh (không bắt buộc nhưng nếu có phải đúng định dạng)
    //             let imageInput = document.querySelector(".variant-image");
    //             if (imageInput && imageInput.files.length > 0) {
    //                 let allowedTypes = ["image/jpeg", "image/png", "image/gif"];
    //                 if (!allowedTypes.includes(imageInput.files[0].type)) {
    //                     alert("❌ Ảnh sản phẩm phải có định dạng JPG, PNG hoặc GIF.");
    //                     isValid = false;
    //                 }
    //             }

    //             // Nếu tất cả hợp lệ thì submit form
    //             if (isValid) {
    //                 form.submit();
    //             }
    //         });
    //     }
    // });

</script>

@endsection