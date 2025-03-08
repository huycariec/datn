@extends("admin.app")
@section("content")
<div class="page-body">
    <!-- New Product Add Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-xxl-8 col-lg-10 m-auto">
                        <div class="card">
                            <div class="card-body">
                                {{-- Thông báo  --}}
                                @if (session('message'))
                                    <div class="alert alert-info">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                <div class="card-header-2">
                                    <h5>Tạo thuộc tính biến thể sản phẩm</h5>
                                </div>
                                

                                <form class="theme-form theme-form-2 mega-form" method="POST" action="{{route('admin.attribute.store')}}">
                                    @csrf
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
                                    <button type="submit" class="btn ms-auto theme-bg-color text-white">Thêm mới thuộc tính</button>
                                </form>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Product Add End -->
</div>
@endsection