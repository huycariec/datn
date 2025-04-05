@extends("admin.app")

@section("content")

<div class="page-body">
    <!-- All User Table Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="title-header option-title">
                            <h5>Danh sách đánh giá</h5>
                        </div>


                        <div class="table-responsive category-table mt-4">
                            <div>
                                <table class="table all-package theme-table" id="table_id">
                                    <thead>
                                        <tr>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Sản phẩm biến thể</th>
                                            <th>Đánh giá</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>

                                    @foreach ($reviews as $review )
                                    <tbody>
                                        <tr>
                                            <td>{{$review->user->name}}</td>
                                            <td>{{$review->product->name}}</td>
                                            <td>{{$review->productVariant->sku}}</td>
                                            <td>{{$review->rating}}</td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <a href="{{route('reviews.show',$review->id)}}">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>


                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach

                                </table>
                                {{$reviews->links('pagination::bootstrap-4')}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All User Table Ends-->



    @endsection
