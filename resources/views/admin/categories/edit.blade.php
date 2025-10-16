@extends('layout.admin')

@section('title', 'Loại sản phẩm - Cập nhật')

@section('content')
    <div class="container mt-5">
        <h3>Cập nhật loại sản phẩm </h3>
        <x-alert></x-alert>
        <div class="card shadow-sm mt-3" style="max-width: 500px;">
            <div class="card-body">
                <form method="POST" action="{{ route('cate.update', $category->cateid) }}">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $item)
                                {{ $item }} <br>
                            @endforeach
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="f-catename" class="form-label">Tên loại sản phẩm</label>
                        <input type="text" name="catename" class="form-control m-2" id="f-catename"
                            value="{{ old('catename', $category->catename) }}">
                        <label for="f-des" class="form-label">Mô tả</label>
                        <textarea name="description" id="f-des" class="form-control m-2">{{ old('description', $category->description) }}</textarea>

                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('cate.index') }}" class="btn btn-success">←</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
