@extends("admin.app")
@section("css")
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
@endsection
@section("content")
            <!-- Container-fluid starts-->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-table">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                        <div class="title-header option-title">
                                            <h5>Danh sách sản phẩm</h5>
                                        </div>
                                        @canany(['products_list', 'products_create'])
                                            @can('products_create')
                                            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i> Thêm Mới Sản Phẩm
                                            </a>
                                            @endcan
                                        @endcanany
                                    </div>
                                    <div class="mb-4">
                                        <form method="GET" action="{{ route('admin.product.index') }}">
                                            <div class="row g-2">
                                                <div class="col-md-2">
                                                    <input type="text" name="id" class="form-control" placeholder="ID Sản phẩm" value="{{ request('id') }}">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="text" name="name" class="form-control" placeholder="Tên Sản phẩm" value="{{ request('name') }}">
                                                </div>

                                                <div class="col-md-2">
                                                    <select name="category_id" class="form-select">
                                                        <option value="">Tất cả danh mục</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <select name="is_active" class="form-select">
                                                        <option value="">Tất cả trạng thái</option>
                                                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Hiển thị</option>
                                                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Ẩn</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="number" name="min_price" class="form-control" placeholder="Giá tối thiểu" value="{{ request('min_price') }}" min="0">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa" value="{{ request('max_price') }}" min="0">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="number" name="min_quantity" class="form-control" placeholder="SL tối thiểu" value="{{ request('min_quantity') }}" min="0">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="number" name="max_quantity" class="form-control" placeholder="SL tối đa" value="{{ request('max_quantity') }}" min="0">
                                                </div>

                                                <div class="col-md-2 d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="fas fa-search me-1"></i> Lọc
                                                    </button>
                                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary w-100">
                                                        Reset
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card mt-4">
                                        <div class="table-responsive">
                                            <table class="table all-package theme-table table-product" id="table_id">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Ảnh Sản Phẩm</th>
                                                        <th>Tên Sản Phẩm</th>
                                                        <th>Danh Mục</th>
                                                        <th>Số Lượng</th>
                                                        <th>Giá</th>
                                                        <th>Trạng Thái</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$product->id}}</td>
                                                        <td>
                                                            <div class="table-image">
                                                                @foreach ($product->images as $image)
                                                                    @if(empty($image->product_variant_id))
                                                                        <img src="{{ Storage::url($image->url) }}" alt="Hình ảnh sản phẩm" width="100">
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <td>{{$product->name}}</td>
                                                        <td>{{ strip_tags($product->category->name) }}</td>
                                                        <td>{{ number_format($product->total_quantity) }}</td>
                                                        <td class="td-price">{{ number_format($product->price, 0, ',', '.') }}</td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" class="toggle-status" data-id="{{ $product->id }}" {{ $product->is_active ? 'checked' : '' }}>
                                                                <span class="slider"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                @canany(['products_update', 'products_delete','products_detail'])
                                                                    @can('products_detail')
                                                                        <li>
                                                                            <a href="{{route('admin.variant.index',$product->id)}}">
                                                                                <i class="ri-eye-line"></i>
                                                                            </a>
                                                                        </li>
                                                                    @endcan
                                                                
                                                                    @can('products_update')

                                                                        <li>
                                                                            <a href="{{route('admin.product.edit',$product->id)}}">
                                                                                <i class="ri-pencil-line"></i>
                                                                            </a>
                                                                        </li>
                                                                    @endcan
                                                                    @can('products_delete')
                                                                        <li>
                                                                            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn tắt sản phẩm này không?')">
                                                                                @csrf
                                                                                @method('POST')
                                                                                <button type="submit" class="btn btn-link p-0 border-0 text-danger">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                                            </form>
                                                                        </li> 

                                                                @endcan
                                                                @endcanany

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
                <!-- Container-fluid Ends-->
            </div>
@endsection
@section('js-custom')
<script>
    const toggleStatusUrl = "{{ route('admin.toggleStatus', ['id' => 'temp_id']) }}";

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.toggle-status').forEach(item => {
            item.addEventListener('change', function () {
                let productId = this.dataset.id;
                let isActive = this.checked ? 1 : 0;

                let url = toggleStatusUrl.replace('temp_id', productId);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ is_active: isActive })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: 'Cập nhật trạng thái thành công!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại!',
                            text: 'Có lỗi xảy ra!',
                        });
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Không thể kết nối server!',
                    });
                });
            });
        });
    });
</script>

@endsection
