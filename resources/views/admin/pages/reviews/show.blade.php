@extends("admin.app")

@section("content")
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-8 m-auto">
                        <div class="card">
                            <div class="card-body" data-select2-id="select2-data-32-f94z">
                                <div class="card-header-2">
                                    <h5>Chi tiết đánh giá</h5>
                                </div>

                                <div class="theme-form theme-form-2 mega-form">
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Khách hàng</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" value=" {{$review->user->name}}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Sản phẩm</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" value=" {{$review->product?->name}}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Sản phẩm biến thể</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" value=" {{$review->productVariant?->sku}}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Đánh giá</label>
                                        <div class="col-sm-9">
                                            {!! $review->image ? '<img src="' . \Illuminate\Support\Facades\Storage::url($review->image) . '" style="width: 70px; height: 100px" alt="Ảnh review">' : '' !!}
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-3 mb-0">Nội dung</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" value=" {{$review->content}}" disabled>
                                        </div>
                                    </div>


                                    <div class="text-end">
                                        <a href="{{route('reviews.index')}}">
                                        <button class="btn btn-primary" type="submit">Quay lại</button>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
