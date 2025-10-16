@extends('layout.admin')

@section('title', 'Loại sản phẩm')

@section('content')
    <div class="container mt-4">
        <h3>Danh sách loại sản phẩm </h3>

        <a class="btn btn-primary mb-3" href="{{ route('cate.create') }}">+ Thêm</a>
        <x-alert></x-alert>
        <div id="list">
            @include('admin.categories.list')
        </div>

    </div>

    <x-modal></x-modal>
    <x-ajax-pagination></x-ajax-pagination>
@endsection
