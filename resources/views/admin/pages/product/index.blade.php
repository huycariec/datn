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
                                        <h5>Products List</h5>
                                        <div class="right-options">
                                            <ul>
                                                <li>
                                                    <a href="javascript:void(0)">import</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)">Export</a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-solid" href="add-new-product.html">Add Product</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table all-package theme-table table-product" id="table_id">
                                                <thead>
                                                    <tr>
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

                                                        <td>{{$product->description}}</td>

                                                        <td>{{$product->name}}</td>

                                                        <td class="td-price">{{$product->price}}</td>

                                                        <td class="status-danger">
                                                            <span>Pending</span>
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

                                                    {{-- <tr>
                                                        <td>
                                                            <div class="table-image">
                                                                <img src="assets/images/product/2.png" class="img-fluid"
                                                                    alt="">
                                                            </div>
                                                        </td>

                                                        <td>Cold Brew Coffee</td>

                                                        <td>Drinks</td>

                                                        <td>10</td>

                                                        <td class="td-price">$95.97</td>

                                                        <td class="status-close">
                                                            <span>Approved</span>
                                                        </td>

                                                        <td>
                                                            <ul>
                                                                <li>
                                                                    <a href="order-detail.html">
                                                                        <i class="ri-eye-line"></i>
                                                                    </a>
                                                                </li>

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
                                                    </tr> --}}




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