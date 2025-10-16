<!-- Thanh danh mục ngang dưới banner -->
<div class="bg-warning border-top py-2 shadow-sm">
    <div class="container">
        <ul class="nav justify-content-center flex-wrap">
            @foreach ($categories as $cate)
                <li class="nav-item text-center mx-2">

                    @php
                        $imagePath = 'storage/categories/' . $cate->image;
                    @endphp

                    <a class="nav-link fw-bold text-dark px-3 d-flex flex-column align-items-center"
                        href="{{ route('category', ['id' => $cate->cateid]) }}">

                        {{-- Ảnh danh mục --}}
                        @if (!empty($cate->image) && file_exists(public_path($imagePath)))
                            <img src="{{ asset($imagePath) }}" alt="{{ $cate->catename }}"
                                style="width: 40px; height: 40px; object-fit: contain;" class="mb-1">
                        @else
                            <img src="{{ asset('storage/categories/default.jpg') }}" alt="Ảnh mặc định"
                                style="width: 40px; height: 40px; object-fit: contain;" class="mb-1">
                        @endif

                        {{-- Tên danh mục --}}
                        {{ $cate->catename }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
