{{-- File: resources/views/client/index.blade.php --}}

@extends('layout.client') {{-- Dòng này sẽ tham chiếu đến layout chính của bạn, đảm bảo file này có tên là 'client.blade.php' và nằm trong thư mục 'resources/views/layout/' --}}

@section('content') {{-- Mở section có tên 'content'. Toàn bộ nội dung bên dưới sẽ được chèn vào vị trí @yield('content') trong layout chính. --}}

{{-- Bắt đầu phần hiển thị sản phẩm và phân trang --}}
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-0">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach ($listpro as $item)
            <div class="col mb-3">
                <div class="card h-100">
                    <!-- Product image-->
                    @php
                    $imagePath = 'storage/products/h' . $item->id . '.jpg';
                    @endphp

                    @if (file_exists(public_path($imagePath)))
                    <img class="card-img-top" src="{{ asset($imagePath) }}" alt="{{ $item->proname }}" />
                    @else
                    <img class="card-img-top" src="{{ asset('storage/products/default.jpg') }}"
                        alt="Ảnh mặc định" />
                    @endif
                    <!-- Product details-->
                    <div class="card-body p-2">
                        <div class="text-center">
                            <!-- Product name-->
                            <h4 class="fw-bolder">{{ $item->proname }}</h4>
                            <!-- Product price-->
                            <span class="text-danger">{{ number_format($item->price) }}đ</span>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center d-flex justify-content-center">
                            <a class="btn btn-primary mt-auto"
                                href="{{ route('client.products.detail', $item->id) }}">Xem</a>
                            <form action="{{ route('cartadd', $item->id) }}" method="POST">
                                @csrf
                                <input type="submit" class="btn btn-outline-dark mt-auto" value="Đặt hàng"></input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- THÊM CÁC LIÊN KẾT PHÂN TRANG VÀO ĐÂY --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $listpro->links() }} {{-- Hiển thị các liên kết phân trang --}}
        </div>
    </div>
</section>
{{-- Kết thúc phần hiển thị sản phẩm và phân trang --}}

@endsection {{-- Đóng section 'content' --}}