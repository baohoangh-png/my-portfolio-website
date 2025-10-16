@extends('layout.admin')

@section('title', 'Sản phẩm - Cập nhật')

@section('content')
    <div class="container mt-4">
        <h2>Cập nhật sản phẩm </h2>

        <x-alert></x-alert>

        <form action="{{ route('pro.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{-- THAY ĐỔI Ở ĐÂY: Đổi $product thành $error (hoặc tên khác) --}}
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <div class="mb-3">
                <label for="proname" class="form-label">Tên sản phẩm</label>
                <input type="text" name="proname" class="form-control" value="{{ old('proname', $product->proname) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}"
                    required step="0.01" min="0">
            </div>

            <div class="mb-3">
                <label for="brandid" class="form-label">Thương hiệu</label>
                <select name="brandid" class="form-select" required>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brandid == $brand->id ? 'selected' : '' }}>
                            {{ $brand->brandname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cateid" class="form-label">Loại sản phẩm</label>
                <select name="cateid" class="form-select" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->cateid }}"
                            {{ $product->cateid == $category->cateid ? 'selected' : '' }}>
                            {{ $category->catename }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="f-des" class="form-label">Mô tả</label>
                <textarea name="description" id="f-des" rows="3" class="form-control"> {{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label for="fileName">Ảnh sản phẩm:</label>
                <input type="file" name="fileName" class="form-control">

                @php
                    $imagePath = 'storage/products/h' . $product->id . '.jpg';
                @endphp

                @if (file_exists(public_path($imagePath)))
                    <img class="card-img-top mt-2" src="{{ asset($imagePath) }}" alt="{{ $product->proname }}"
                        style="max-width: 200px; height: auto;">
                @else
                    <img class="card-img-top mt-2" src="{{ asset('storage/products/default.jpg') }}" alt="Ảnh mặc định"
                        style="max-width: 200px; height: auto;">
                @endif

            </div>


            <a href="{{ route('pro.index') }}" class="btn btn-success">←</a>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
