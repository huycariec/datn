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
                                    <div class="title-header option-title d-sm-flex d-block">
                                        <h5>Danh Sách Sản Phẩm</h5>
                                        <div class="right-options">
                                            <ul>
                                                <li>
                                                    <a href="{{route('admin.product.create')}}" class="btn btn-solid" href="add-new-product.html">Thêm Mới Sản Phẩm</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
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
                                                                <li>
                                                                    <a href="{{route('admin.variant.index',$product->id)}}">
                                                                        <i class="ri-eye-line"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="{{route('admin.product.edit',$product->id)}}">
                                                                        <i class="ri-pencil-line"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn tắt sản phẩm này không?')">
                                                                        @csrf
                                                                        @method('POST') 
                                                                        <button type="submit" class="btn btn-link p-0 border-0 text-danger">
                                                                            <i class="ri-delete-bin-line"></i>
                                                                        </button>
                                                                    </form>
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
                <!-- Container-fluid Ends-->
            </div>
@endsection
@section('js-custom')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.toggle-status').forEach(item => {
        item.addEventListener('change', function () {
            let productId = this.dataset.id;
            let isActive = this.checked ? 1 : 0;

            fetch(`/admin/products/${productId}/toggle-status`, {
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
                    alert('Cập nhật trạng thái thành công!');
                    console.log('Cập nhật thành công');
                } else {
                    console.error('Có lỗi xảy ra');
                }
            })
            .catch(error => console.error('Lỗi:', error));
        });
    });
});


</script>

@endsection