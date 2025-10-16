@extends('layout.admin')

@section('title', 'Sản phẩm - Thêm')

@section('content')
    <div class="container mt-4">
        <h2>Thêm sản phẩm </h2>

        <x-alert></x-alert>

        <form action="{{ route('pro.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $item)
                        {{ $item }} <br>
                    @endforeach
                </div>
            @endif
            <div class="mb-3">
                <label for="f-proname" class="form-label">Tên sản phẩm</label>
                <input type="text" name="proname" class="form-control" id="f-proname" value="{{ old('proname') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="f-price" class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" id="f-price" value="{{ old('price') }}"
                    required step="0.01" min="0">
            </div>

            <div class="mb-3">
                <label for="f-brandid" class="form-label">Thương hiệu</label>
                <select name="brandid" id="f-brandid" class="form-select" required>
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brandid') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->brandname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="f-cateid" class="form-label">Loại sản phẩm</label>
                <select name="cateid" id="f-cateid" class="form-select" required>
                    <option value="">-- Chọn loại sản phẩm --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->cateid }}" {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                            {{ $category->catename }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="f-des" class="form-label">Mô tả</label>
                <textarea name="description" id="f-des" rows="3" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="f-path" class="form-label">Hình ảnh</label>
                <input type="file" name="fileName" id="f-path" class="form-control m-2" accept="image/*">
                @error('fileName')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <a href="{{ route('pro.index') }}" class="btn btn-success">←</a>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
@endsection
