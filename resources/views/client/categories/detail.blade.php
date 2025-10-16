@extends('layout.client_categories')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2>Sản phẩm trong danh mục: {{ $category->catename }}</h2>

            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @forelse ($category->products as $item)
                    <div class="col mb-3">
                        <div class="card h-100">
                            @php
                                $imagePath = 'storage/products/h' . $item->id . '.jpg';
                            @endphp

                            @if (file_exists(public_path($imagePath)))
                                <img class="card-img-top" src="{{ asset($imagePath) }}" alt="{{ $item->proname }}" />
                            @else
                                <img class="card-img-top" src="{{ asset('storage/products/default.jpg') }}"
                                    alt="Ảnh mặc định" />
                            @endif
                            <div class="card-body p-2">
                                <div class="text-center">
                                    <h4 class="fw-bolder">{{ $item->proname }}</h4>
                                    <span class="text-danger">{{ number_format($item->price) }}đ</span>
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center d-flex justify-content-center">
                                    <a class="btn btn-primary mt-auto"
                                        href="{{ route('client.products.detail', $item->id) }}">Xem</a>
                                    <form action="{{ route('cartadd', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="submit" class="btn btn-outline-dark mt-auto" value="Đặt hàng">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
