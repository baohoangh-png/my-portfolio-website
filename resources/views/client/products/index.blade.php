@extends('layout.client')

@section('content')
    <h2>Tất cả sản phẩm</h2>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">

            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($products as $item)
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
        </div>
    </section>
@endsection
