@extends("admin.app")

@section("content")
    <div class="page-body">

        <!-- New Product Add Start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-8 m-auto">
                            <div class="card">
                                <div class="card-body" data-select2-id="select2-data-32-f94z">
                                    <div class="card-header-2">
                                        <h5>Thông tin mã giảm giá</h5>
                                    </div>

                                    <form class="theme-form theme-form-2 mega-form" action="{{ route("discounts.store") }}" method="post">
                                        @csrf
                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Mã giảm giá</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="code" value="{{old('code')}}" placeholder="Nhập mã giảm giá">
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Giá trị giảm giá</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" step="0.01" value="{{ old('value') }}" name="value" placeholder="Nhập giá trị giảm">
                                                @error('value')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Ngày bắt đầu</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="datetime-local" value="{{old('start_date')}}" name="start_date">
                                                @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Ngày kết thúc</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="datetime-local" value="{{old('end_date')}}" name="end_date">
                                                @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Giá trị đơn hàng tối thiểu</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" name="min_order_amount" value="{{old('min_order_amount')}}" placeholder="Nhập giá trị tối thiểu">
                                                @error('min_order_amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Giá trị giảm trừ tối đa</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" name="max_discount_value" value="{{ old('max_discount_value')}}" placeholder="Nhập giá trị tối đa">
                                                @error('max_discount_value')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Số lượng mã giảm giá</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" name="quantity" value="{{old('quantity')}}" placeholder="Nhập số lượng mã">
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Loại giảm giá</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="type">
                                                    <option {{ old('type') == 'percent' ? 'selected' : "" }} value="percent">Phần trăm</option>
                                                    <option {{ old('type') == 'fixed' ? 'selected' : "" }} value="fixed">Số tiền cố định</option>
                                                </select>
                                                @error('type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="form-label-title col-sm-3 mb-0">Trạng thái</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="status">
                                                    <option {{ old('status') == 'active' ? 'selected' : "" }} value="active">Hoạt động</option>
                                                    <option {{ old('status') == 'inactive' ? 'selected' : "" }} value="inactive">Không hoạt động</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary" type="submit">Lưu</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
