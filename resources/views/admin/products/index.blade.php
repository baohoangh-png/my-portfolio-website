@extends('layout.admin')

@section('title', 'Sản phẩm')

@section('content')
    <div class="container mt-4">
        <h3>Danh sách sản phẩm </h3>
        <x-alert></x-alert>
        <div>
            <a href="{{ route('pro.create') }}" class="btn btn-primary mb-3">+ Thêm</a>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Loại</th>
                        <th>Thương hiệu</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Ảnh sản phẩm</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->category->catename }}</td>
                            <td>{{ $item->brand->brandname }}</td>
                            <td>{{ $item->productname }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td> @php
                                $imagePath = 'storage/products/h' . $item->id . '.jpg';
                            @endphp

                                @if (file_exists(public_path($imagePath)))
                                    <img class="card-img-top" src="{{ asset($imagePath) }}" alt="{{ $item->proname }}"
                                        style="width: 120px; height: auto;" />
                                @else
                                    <img class="card-img-top" src="{{ asset('storage/products/default.jpg') }}"
                                        alt="Ảnh mặc định" />
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('pro.edit', $item->id) }}" class="btn btn-warning mx-1">sửa</a>
                                    <form action="{{ route('pro.delete', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger mx-1">xóa</button>
                                    </form>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target = "#confirmdelete" data-info="{{ $item->productname }}"
                                        data-action="{{ route('pro.delete', $item->id) }}">
                                        Xóa (modal)
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex">
            <select name="" id="" class="form-control m-2 align-content-center"
                onchange="window.location.href=this.value" style="width:50px">
                <option value="{{ route('pro.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
                <option value="{{ route('pro.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
                <option value="{{ route('pro.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
                <option value="{{ route('pro.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
            </select>
            <label for="" class="align-content-center">Số bản ghi trên trang</label>
            <div class="align-content-center">
                {{ $list->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <x-modal></x-modal>
@endsection
