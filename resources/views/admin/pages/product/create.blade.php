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
                                    <label class="form-label-title col-sm-3 mb-0">Mô tả ngắn sản phẩm</label>
                                    <div class="col-sm-9">
                                        <input id="description" name="description" class="form-control" type="text" placeholder="Mô tả ngắn sản phẩm">
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
        const values = attributeValueInput.value.trim().split("|").map(v => v.trim());
        const uniqueValues = [...new Set(values)];
        
        if (!name || values.length === 0 || values[0] === "") {
            alert("Vui lòng nhập tên thuộc tính và giá trị hợp lệ!");
            return;
        }


                // Kiểm tra giá trị không được trùng lặp
        if (uniqueValues.length !== values.length) {
            alert("Các giá trị thuộc tính không được trùng nhau!");
            return false;
        }
        
        if (editingAttribute !== null) {
            // Cập nhật thuộc tính đang chỉnh sửa
            delete attributes[editingAttribute];
            editingAttribute = null;
        } else if (attributes[name]) {
            alert("Thuộc tính này đã tồn tại!");
            return;
        }
        
        attributes[name] = values;
        attributeNameInput.value = "";
        attributeValueInput.value = "";
        renderAttributeTable();
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
        }
    });

    // Sinh biến thể tự động
    generateVariantsBtn.addEventListener("click", function (event) {
        event.preventDefault(); // Ngăn chặn form submit
        variantContainer.innerHTML = "";
        const variants = generateCombinations(attributes);

        
        variants.forEach((variant, index) => {
            let variantHTML = `<div class='variant-item border p-3 mb-2'>
                <div class='d-flex gap-3'>`;
            
            Object.keys(variant).forEach(attr => {
                variantHTML += `<div>
                    <label>${attr}</label>
                    <input type='text' class='form-control' name='variants[${index}][attributes][${attr}]' value='${variant[attr]}' readonly>
                </div>`;
            });
            
            variantHTML += `</div>
                <div class='d-flex gap-3'>
                    <input type='number' class='form-control' name='variants[${index}][pricing][price]' placeholder='Giá'>
                    <input type='number' class='form-control' name='variants[${index}][pricing][stock]' placeholder='Số lượng'>
                    <input type='file' class='form-control' name='variants[${index}][pricing][image]'>
                    <button type='button' class='btn btn-danger btn-remove-variant'>Xóa</button>
                </div>
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

    // Hàm tạo kết hợp thuộc tính
    function generateCombinations(attrs) {
        const keys = Object.keys(attrs);
        if (keys.length === 0) return [];

        return keys.reduce((acc, key) => {
            const temp = [];
            acc.forEach(existing => {
                attrs[key].forEach(value => {
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
        const shortDescInput = document.querySelector('#description');

        // Tạo hoặc tìm phần hiển thị lỗi
        let productNameError = productNameInput.nextElementSibling;
        let productPriceError = productPriceInput.nextElementSibling;
        let shortDescError = shortDescInput.nextElementSibling;

        if (!productNameError || !productNameError.classList.contains("error-message")) {
            productNameError = document.createElement("div");
            productNameError.classList.add("error-message", "text-danger");
            productNameInput.after(productNameError);
        }

        if (!productPriceError || !productPriceError.classList.contains("error-message")) {
            productPriceError = document.createElement("div");
            productPriceError.classList.add("error-message", "text-danger");
            productPriceInput.after(productPriceError);
        }

        if (!shortDescError || !shortDescError.classList.contains("error-message")) {
            shortDescError = document.createElement("div");
            shortDescError.classList.add("error-message", "text-danger");
            shortDescInput.after(shortDescError);
        }

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
            shortDescError.innerHTML = "Mô tả không được để trống!";
        } else if (shortDescInput.value.trim().length < 10) {
            isValid = false;
            shortDescInput.classList.add("is-invalid");
            shortDescError.innerHTML = "Mô tả phải có ít nhất 10 ký tự!";
        } else {
            shortDescInput.classList.remove("is-invalid");
            shortDescError.innerHTML = "";
        }

        // Kiểm tra biến thể
        if (!validateVariants()) {
            isValid = false;
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

@endsection

