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
</script>

@endsection

