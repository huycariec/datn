@extends('app')

@section('content')
    @isset($data)
        {!! $data->content !!}
    @else
        <h1 class="text-center">coming soon</h1>
    @endisset
@endsection
