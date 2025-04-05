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
                                        <input id="product_name" name="product_name" class="form-control" type="text" placeholder="Tên sản phẩm"></div>
                                    @error('product_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Giá sản phẩm</label>
                                    <div class="col-sm-9">
                                        <input id="product_price" name="product_price" class="form-control prcie" type="number" placeholder="Giá sản phẩm"></div>
                                    @error('product_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Giá cũ sản phẩm</label>
                                    <div class="col-sm-9">
                                        <input id="product_price_old" name="product_price_old" class="form-control prcie" type="number" placeholder="Giá cũ sản phẩm"></div>
                                    @error('price_old')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Mô tả ngắn sản phẩm</label>
                                    <div class="col-sm-9">
                                        <textarea id="short_description" name="short_description" class="form-control" placeholder="Mô tả ngắn sản phẩm"></textarea>
                                        @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4 row">
                                    <label class="form-label-title col-sm-3 mb-0">Mô tả chi tiết</label>
                                    <div class="col-sm-9">
                                        <textarea id="description" name="description" class="form-control"></textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                                <div class="mb-4 row align-items-center">
                                    <label class="col-sm-3 col-form-label form-label-title">Danh mục sản phẩm</label>
                                    <div class="col-sm-9">
                                        <select class="js-example-basic-single w-100" name="category_id">
                                            <option disabled selected>Menu Danh mục</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
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
                    <div class="card" >
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
                    <div class="card" id="attributeSection">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Tạo thuộc tính biến thể sản phẩm</h5>
                            </div>
                                <div class="mb-4 row align-items-center">
                                    <label class="form-label-title col-sm-3 mb-0">Tên thuộc tính</label>
                                    <div class="col-sm-9">
                                        <input name="attribute_name" class="form-control" type="text"
                                            placeholder="Tên thuộc tính">
                                    </div>
                                </div>

                                <div class="mb-4 row align-items-start">
                                    <label class="col-sm-3 col-form-label form-label-title">Giá trị thuộc tính</label>
                                    <div class="col-sm-9">
                                    
                                            <div class="col-sm-9">
                                                <input name="attribute_value" class="form-control" type="text"
                                                    placeholder="Giá trị thuộc tính được cách nhau |">
                                            </div>
                                        
                                    </div>
                                </div>
                                <button type="submit" class="btn ms-auto theme-bg-color text-white" id="addAttributeBtn">
                                    Thêm mới thuộc tính
                                </button>
                        </div>
                    </div>
                    <div class="card" id="attributeTableSection" style="display: none;">
                        <div class="title-header option-title">
                            <h5>Tất Cả Thuộc Tính Sản Phẩm</h5>
                        </div>
                    
                        <div class="table-responsive category-table">
                            <table class="table all-package theme-table" id="table_id">
                                <thead>
                                    <tr>
                                        <th>Tên thuộc tính</th>
                                        <th>Giá trị thuộc tính</th>
                                        <th>Tùy chỉnh</th>
                                    </tr>
                                </thead>
                                <tbody id="attributeTableBody">
                                    <!-- Dữ liệu sẽ được thêm vào đây bằng JS -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Nút tự động tạo biến thể -->
                        <button type="submit" class="btn ms-auto theme-bg-color text-white" id="generateVariantsBtn">Tự động tạo biến thể sản phẩm</button>
                    </div>

                    <div class="card" id="productInventoryCard" style="display: none;">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Biến thể sản phẩm</h5>
                            </div>
                            <div id="variantContainer">
                                <!-- Biến thể sẽ được thêm vào đây bằng JS -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end mt-3">
                        <button type="submit" id="submit" class="btn btn-success">Lưu sản phẩm</button>
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
    let attributes = {}; // Lưu thuộc tính đã tạo
    const simpleProductRadio = document.querySelector("#simpleProduct");
    const variableProductRadio = document.querySelector("#variableProduct");
    const attributeSection = document.querySelector("#attributeSection");
    const attributeTableSection = document.querySelector("#attributeTableSection");
    const productInventoryCard = document.querySelector("#productInventoryCard");
    const attributeNameInput = document.querySelector("input[name='attribute_name']");
    const attributeValueInput = document.querySelector("input[name='attribute_value']");
    const addAttributeBtn = document.querySelector("#addAttributeBtn");
    const attributeTableBody = document.querySelector("#attributeTableBody");
    const generateVariantsBtn = document.querySelector("#generateVariantsBtn");
    const variantContainer = document.querySelector("#variantContainer");
    const submit = document.querySelector('#submit');
    let editingAttribute = null;

    // Ẩn/hiện các phần liên quan đến biến thể
    function toggleSections() {
        if (variableProductRadio.checked) {
            attributeSection.style.display = "block";
            attributeTableSection.style.display = "block";
            productInventoryCard.style.display = "block";
        } else {
            attributeSection.style.display = "none";
            attributeTableSection.style.display = "none";
            productInventoryCard.style.display = "none";
        }
    }

    simpleProductRadio.addEventListener("change", toggleSections);
    variableProductRadio.addEventListener("change", toggleSections);
    toggleSections(); // Thiết lập trạng thái ban đầu

    // Thêm hoặc cập nhật thuộc tính
    addAttributeBtn.addEventListener("click", function (event) {
        event.preventDefault();
        const name = attributeNameInput.value.trim();
        
        // Lọc bỏ giá trị rỗng sau dấu |
        const values = attributeValueInput.value
            .split("|")
            .map(v => v.trim())
            .filter(v => v !== ""); // Loại bỏ giá trị rỗng

        const uniqueValues = [...new Set(values)];

        if (!name || uniqueValues.length === 0) {
            alert("Vui lòng nhập tên thuộc tính và giá trị hợp lệ!");
            return;
        }

        // Kiểm tra giá trị không được trùng lặp
        if (uniqueValues.length !== values.length) {
            alert("Các giá trị thuộc tính không được trùng nhau!");
            return false;
        }

        let isEditing = editingAttribute !== null;

        if (isEditing) {
            // Cập nhật thuộc tính đang chỉnh sửa
            delete attributes[editingAttribute];
            editingAttribute = null;
        } else if (attributes[name]) {
            alert("Thuộc tính này đã tồn tại!");
            return;
        }

        attributes[name] = uniqueValues;
        attributeNameInput.value = "";
        attributeValueInput.value = "";

        // Reset nút về "Thêm Thuộc Tính" sau khi sửa xong
        addAttributeBtn.textContent = "Thêm Thuộc Tính";

        renderAttributeTable();

        // Chỉ khi sửa mới gọi hàm tạo biến thể
        if (isEditing) {
            generateVariantsBtn.click();
        }
    });




    // Hiển thị danh sách thuộc tính
    function renderAttributeTable() {
        attributeTableBody.innerHTML = "";
        Object.keys(attributes).forEach(name => {
            const values = attributes[name].join(", ");
            const row = `<tr>
                <td>${name}</td>
                <td>${values}</td>
                <td>
                    <ul>
                        <li>
                            <button type="button" id="edit-attribute-${name}" class="btn-edit-attribute" data-name="${name}">
                                <i class="ri-pencil-line"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" id="delete-attribute-${name}" class="btn-delete-attribute" data-key="${name}">
                                <i class="ri-delete-bin-line text-danger"></i>
                            </button>
                        </li>
                    </ul>
                </td>
            </tr>`;
            attributeTableBody.innerHTML += row;
        });
        attributeTableSection.style.display = "block";
    }

    // Xóa thuộc tính
    attributeTableBody.addEventListener("click", function (event) {
        if (event.target.closest(".btn-delete-attribute")) {
            event.preventDefault();
            const name = event.target.closest(".btn-delete-attribute").dataset.key;
            if (confirm("Bạn có chắc muốn xóa thuộc tính này không?")) {
                delete attributes[name];
                renderAttributeTable();
                generateVariantsBtn.click(); // Gọi hàm tạo biến thể tự động
            }
        }
    });


    // Chỉnh sửa thuộc tính
    attributeTableBody.addEventListener("click", function (event) {
        if (event.target.closest(".btn-edit-attribute")) {
            event.preventDefault();
            const name = event.target.closest(".btn-edit-attribute").dataset.name;
            attributeNameInput.value = name;
            attributeValueInput.value = attributes[name].join("|");
            editingAttribute = name;
            generateVariantsBtn.click(); // Gọi hàm tạo biến thể tự động
        }
    });


    // Sinh biến thể tự động
    generateVariantsBtn.addEventListener("click", function (event) {
        event.preventDefault(); // Ngăn chặn form submit
        variantContainer.innerHTML = "";
        const variants = generateCombinations(attributes);

        variants.forEach((variant, index) => {
            let variantHTML = `<div class="variant-item border p-3 mb-2 rounded">
                <div class="d-flex gap-3 mb-2">
                    <!-- Số thứ tự -->
                    <div class="col-12">
                        <label class="form-label">Biến thể #${index + 1}</label>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-2">`;

            Object.keys(variant).forEach(attr => {
                variantHTML += `
                    <div class="col-4">
                        <label for="variant-${index}-${attr}" class="form-label">${attr}</label>
                        <input type="text" class="form-control" id="variant-${index}-${attr}" name="variants[${index}][attributes][${attr}]" value="${variant[attr]}" readonly>
                    </div>
                `;
            });

            variantHTML += `
                </div>
                <div class="d-flex gap-3 mb-2 flex-wrap">
                    <div class="col-3">
                        <label for="price-${index}" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price-${index}" name="variants[${index}][pricing][price]" placeholder="Giá">
                    </div>
                    <div class="col-3">
                        <label for="old-price-${index}" class="form-label">Giá cũ</label>
                        <input type="number" class="form-control" id="old-price-${index}" name="variants[${index}][pricing][price_old]" placeholder="Giá cũ">
                    </div>
                    <div class="col-3">
                        <label for="stock-${index}" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="stock-${index}" name="variants[${index}][pricing][stock]" placeholder="Số lượng">
                    </div>
                    <div class="col-3">
                        <label for="image-${index}" class="form-label">Ảnh</label>
                        <input type="file" class="form-control" id="image-${index}" name="variants[${index}][pricing][image]">
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm btn-remove-variant">Xóa</button>
            </div>`;

            variantContainer.innerHTML += variantHTML;
        });
    });



    // Xóa biến thể
    variantContainer.addEventListener("click", function (event) {
        if (event.target.classList.contains("btn-remove-variant")) {
            if (confirm("Bạn có chắc muốn xóa thuộc tính này không?")) {
            event.target.closest(".variant-item").remove();
            }
        }
    });

    // Hàm tạo kết hợp thuộc tính (bỏ qua giá trị rỗng)
    function generateCombinations(attrs) {
        const keys = Object.keys(attrs);
        if (keys.length === 0) return [];

        return keys.reduce((acc, key) => {
            const validValues = attrs[key].filter(value => value.trim() !== ""); // Lọc bỏ giá trị rỗng
            if (validValues.length === 0) return acc; // Nếu không có giá trị hợp lệ, bỏ qua

            const temp = [];
            acc.forEach(existing => {
                validValues.forEach(value => {
                    temp.push({ ...existing, [key]: value });
                });
            });
            return temp;
        }, [{}]);
    }


    function validateForm() {
        let isValid = true;

        // Lấy các input
        const productNameInput = document.querySelector('#product_name');
        const productPriceInput = document.querySelector('#product_price');
        const shortDescInput = document.querySelector('#short_description');
        const descInput = document.querySelector('#description');
        const categorySelect = document.querySelector('select[name="category_id"]');

        // Nếu dùng TinyMCE, cập nhật nội dung vào textarea
        if (typeof tinymce !== "undefined") {
            tinymce.triggerSave(); // Lưu nội dung từ TinyMCE vào textarea
            descInput.value = tinymce.get("description")?.getContent().trim() || "";
        }

        console.log("Mô tả ngắn:", shortDescInput.value.trim());
        console.log("Mô tả chi tiết sau khi cập nhật:", descInput.value);

        // Tạo hoặc tìm phần hiển thị lỗi
        function getErrorElement(input) {
            let errorElement = input.nextElementSibling;
            if (!errorElement || !errorElement.classList.contains("error-message")) {
                errorElement = document.createElement("div");
                errorElement.classList.add("error-message", "text-danger");
                input.after(errorElement);
            }
            return errorElement;
        }

        let productNameError = getErrorElement(productNameInput);
        let productPriceError = getErrorElement(productPriceInput);
        let shortDescError = getErrorElement(shortDescInput);
        let descError = getErrorElement(descInput);
        let categoryError = getErrorElement(categorySelect);

        // Regex kiểm tra tên sản phẩm
        const nameRegex = /^[a-zA-Z0-9\sÀ-ỹ]+$/;

        // Kiểm tra tên sản phẩm
        if (!productNameInput.value.trim()) {
            isValid = false;
            productNameInput.classList.add("is-invalid");
            productNameError.innerHTML = "Tên sản phẩm không được để trống!";
        } else if (!nameRegex.test(productNameInput.value.trim())) {
            isValid = false;
            productNameInput.classList.add("is-invalid");
            productNameError.innerHTML = "Tên sản phẩm chỉ được chứa chữ, số và khoảng trắng!";
        } else {
            productNameInput.classList.remove("is-invalid");
            productNameError.innerHTML = "";
        }

        // Kiểm tra giá sản phẩm
        const price = parseFloat(productPriceInput.value);
        if (isNaN(price) || price <= 0) {
            isValid = false;
            productPriceInput.classList.add("is-invalid");
            productPriceError.innerHTML = "Giá sản phẩm phải lớn hơn 0!";
        } else {
            productPriceInput.classList.remove("is-invalid");
            productPriceError.innerHTML = "";
        }

        // Kiểm tra mô tả ngắn
        if (!shortDescInput.value.trim()) {
            isValid = false;
            shortDescInput.classList.add("is-invalid");
            shortDescError.innerHTML = "Mô tả ngắn không được để trống!";
        } else if (shortDescInput.value.trim().length < 10) {
            isValid = false;
            shortDescInput.classList.add("is-invalid");
            shortDescError.innerHTML = "Mô tả ngắn phải có ít nhất 10 ký tự!";
        } else {
            shortDescInput.classList.remove("is-invalid");
            shortDescError.innerHTML = "";
        }

        // Kiểm tra mô tả chi tiết
        if (!descInput.value.trim()) {
            isValid = false;
            descInput.classList.add("is-invalid");
            descError.innerHTML = "Mô tả chi tiết không được để trống!";
        } else {
            descInput.classList.remove("is-invalid");
            descError.innerHTML = "";
        }

        // Kiểm tra danh mục sản phẩm
        if (!categorySelect.value) {
            isValid = false;
            categorySelect.classList.add("is-invalid");
            categoryError.innerHTML = "Vui lòng chọn danh mục sản phẩm!";
        } else {
            categorySelect.classList.remove("is-invalid");
            categoryError.innerHTML = "";
        }

        return isValid;
    }





    // kiểm tra trước khi submit form
    function validateVariants() {
            let isValid = true;
            const variantItems = document.querySelectorAll(".variant-item");

            variantItems.forEach((variant, index) => {
            const priceInput = variant.querySelector(`input[name="variants[${index}][pricing][price]"]`);
            const stockInput = variant.querySelector(`input[name="variants[${index}][pricing][stock]"]`);
            const imageInput = variant.querySelector(`input[name="variants[${index}][pricing][image]"]`);

            // Tạo hoặc tìm phần hiển thị lỗi
            let priceError = priceInput.nextElementSibling;
            let stockError = stockInput.nextElementSibling;
            let imageError = imageInput.nextElementSibling;

            if (!priceError || !priceError.classList.contains("error-message")) {
                priceError = document.createElement("div");
                priceError.classList.add("error-message", "text-danger");
                priceInput.after(priceError);
            }

            if (!stockError || !stockError.classList.contains("error-message")) {
                stockError = document.createElement("div");
                stockError.classList.add("error-message", "text-danger");
                stockInput.after(stockError);
            }

            if (!imageError || !imageError.classList.contains("error-message")) {
                imageError = document.createElement("div");
                imageError.classList.add("error-message", "text-danger");
                imageInput.after(imageError);
            }

            let price = parseFloat(priceInput.value);
            let stock = parseInt(stockInput.value);
            let imageFile = imageInput.files[0];

            // Kiểm tra giá
            if (isNaN(price) || price <= 0) {
                isValid = false;
                priceInput.classList.add("is-invalid");
                priceError.innerHTML = "Giá phải lớn hơn 0!";
            } else {
                priceInput.classList.remove("is-invalid");
                priceError.innerHTML = "";
            }

            // Kiểm tra số lượng
            if (isNaN(stock) || stock < 1) {
                isValid = false;
                stockInput.classList.add("is-invalid");
                stockError.innerHTML = "Số lượng phải là số nguyên dương!";
            } else {
                stockInput.classList.remove("is-invalid");
                stockError.innerHTML = "";
            }

            // Kiểm tra file ảnh
            if (imageFile) {
                const allowedExtensions = ["image/jpeg", "image/png", "image/jpg"];
                if (!allowedExtensions.includes(imageFile.type)) {
                    isValid = false;
                    imageInput.classList.add("is-invalid");
                    imageError.innerHTML = "Ảnh phải có định dạng .jpg, .jpeg, .png!";
                } else {
                    imageInput.classList.remove("is-invalid");
                    imageError.innerHTML = "";
                }
            } else {
                imageError.innerHTML = ""; // Không bắt buộc có ảnh, nên không báo lỗi
            }
            });

        return isValid;
    }

    // Gọi hàm validate trước khi submit form
    submit.addEventListener("click", function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Ngăn không cho submit nếu có lỗi
        }
    });
});
</script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link charmap print preview anchor',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        menubar: false
    });
</script>
@endsection

