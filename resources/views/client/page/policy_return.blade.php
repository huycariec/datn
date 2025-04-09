@extends('app')

@section('content')
    <div class="container">
        @isset($data)
            <h2 style="font-size: 32px" class="text-center">Chính sách đổi trả</h2>
            {!! $data->content !!}
        @else
            <h1 class="text-center">coming soon</h1>
        @endisset
    </div>
@endsection
