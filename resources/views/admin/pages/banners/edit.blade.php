@extends("admin.app")

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5>Chỉnh sửa banner</h5>
                                <div class="right-options">
                                    <ul>
                                        <li>
                                            <a class="btn btn-solid" href="{{ route('banners.index') }}">Quay lại danh sách</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="image">Ảnh banner</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                        <img src="{{ Storage::url($banner->image) }}" width="100" alt="Current Banner" class="mt-2">
                                        @error('image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="position">Vị trí</label>
                                        <select name="position" id="position" class="form-control @error('position') is-invalid @enderror" required>
                                            <option value="">Chọn vị trí</option>
                                            @foreach ($availablePositions as $position)
                                                <option value="{{ $position }}" {{ $banner->position == $position ? 'selected' : '' }}>{{ $position }}</option>
                                            @endforeach
                                        </select>
                                        @error('position')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

{{--                                    <div class="form-group">--}}
{{--                                        <label for="status">Trạng thái</label>--}}
{{--                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>--}}
{{--                                            <option value="1" {{ $banner->status ? 'selected' : '' }}>Hoạt động</option>--}}
{{--                                            <option value="0" {{ $banner->status ? '' : 'selected' }}>Không hoạt động</option>--}}
{{--                                        </select>--}}
{{--                                        @error('status')--}}
{{--                                        <span class="invalid-feedback">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}

                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ $banner->link }}">
                                        @error('link')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="d-flex mt-2 gap-2">
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                        <a href="{{ route('banners.index') }}" class="btn btn-warning">Hủy</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
