@extends('layout.admin')

@section('title', 'Thương hiệu - Cập nhật')

@section('content')
    <div class="container mt-5">
        <h3>Cập nhật thương hiệu</h3>
        <x-alert></x-alert>
        <div class="card shadow-sm mt-3" style="max-width: 500px;">
            <div class="card-body">
                <form method="POST" action="{{ route('brand.update', $brand->id) }}">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $item)
                                {{ $item }} <br>
                            @endforeach
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="f-brandname" class="form-label">Tên thương hiệu</label>
                        <input type="text" name="brandname" class="form-control m-2" id="f-brandname"
                            value="{{ old('brandname', $brand->brandname) }}">
                        <textarea name="description" id="f-des" class="form-control m-2">{{ old('description', $brand->description) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('brand.index') }}" class="btn btn-success">←</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
