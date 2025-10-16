@extends('layout.client')

@section('content')
    <style>
        /* --- CSS sản phẩm --- */
        .product-detail {
            display: flex;
            gap: 30px;
            font-family: Arial, sans-serif;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .product-images {
            flex: 1 1 300px;
        }

        .product-main-image {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 10px #ddd;
            object-fit: contain;
            max-height: 350px;
        }

        .product-thumbnails {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            overflow-x: auto;
        }

        .product-thumbnails img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        .product-thumbnails img.active,
        .product-thumbnails img:hover {
            border-color: #ff4c3b;
        }

        .product-highlight {
            background-color: #f96d00;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
            margin-top: 20px;
        }

        .product-info {
            flex: 1 1 350px;
        }

        .price {
            font-size: 24px;
            color: #e60012;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-primary {
            background-color: #ff002b;
            color: white;
            border: none;
            padding: 15px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        /* --- Bảo hành hậu mãi --- */
        .warranty-info {
            background-color: #ff6f2f;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 25px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        .warranty-info h5 {
            border-bottom: 2px solid white;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .warranty-info select {
            max-width: 280px;
            border: none;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 14px;
            color: #444;
            margin-bottom: 15px;
        }

        .warranty-details {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .warranty-details ul {
            list-style: disc;
            padding-left: 20px;
            margin: 0;
        }

        .warranty-details li {
            margin-bottom: 6px;
        }

        .warranty-info a {
            color: white;
            text-decoration: underline;
        }

        /* --- Ưu đãi khi mua sản phẩm --- */
        .promotion-box {
            background-color: #fff8e1;
            border: 1px solid #ffe082;
            border-radius: 10px;
            padding: 15px;
            margin-top: 25px;
            font-size: 14px;
            color: #444;
        }

        .promotion-box h5 {
            color: #e65100;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .promotion-box ul {
            list-style: none;
            padding-left: 0;
        }

        .promotion-box li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .promotion-box li i {
            color: #f57c00;
            font-size: 16px;
        }

        /* --- Đánh giá khách hàng --- */
        .customer-review {
            margin-top: 40px;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .review-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .review-summary {
            flex: 1 1 250px;
            background: #2ecc71;
            color: white;
            text-align: center;
            border-radius: 10px;
            padding: 30px 20px;
        }

        .review-summary h5 {
            margin-bottom: 15px;
            font-weight: bold;
        }

        .review-score {
            font-size: 42px;
            font-weight: bold;
            color: #ffeb3b;
            margin-bottom: 5px;
        }

        .review-summary .stars i {
            font-size: 20px;
            color: #ffeb3b;
        }

        .review-summary p {
            margin-top: 10px;
            font-size: 14px;
        }

        .review-form {
            flex: 2 1 400px;
        }

        .review-form .rating-stars i {
            font-size: 26px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s ease;
            margin-right: 4px;
        }

        .review-form .rating-stars i.active {
            color: #ffc107;
        }
    </style>

    <section class="py-5">
        <div class="container">
            <div class="product-detail">
                <!-- Cột trái: Ảnh + bảo hành -->
                <div class="product-images">
                    @php
                        $images = [];
                        for ($i = 1; $i <= 4; $i++) {
                            $path = 'storage/products/h' . $product->id . ($i > 1 ? '-' . $i : '') . '.jpg';
                            if (file_exists(public_path($path))) {
                                $images[] = asset($path);
                            }
                        }
                        if (count($images) == 0) {
                            $images[] = asset('storage/products/default.jpg');
                        }
                    @endphp

                    <img id="mainImage" class="product-main-image" src="{{ $images[0] }}" alt="{{ $product->proname }}" />

                    @if (count($images) > 1)
                        <div class="product-thumbnails">
                            @foreach ($images as $img)
                                <img src="{{ $img }}" onclick="changeImage(this)"
                                    @if ($loop->first) class="active" @endif />
                            @endforeach
                        </div>
                    @endif

                    <!-- Bảo hành nằm ngay dưới ảnh -->
                    <div class="warranty-info">
                        <h5 class="fw-bold mb-3">SỐ 1 VỀ BẢO HÀNH HẬU MÃI</h5>
                        <select id="warrantySelect" class="form-select mb-3" onchange="updateWarranty()">
                            <option value="standard" selected>Bảo hành tiêu chuẩn</option>
                            <option value="vip3">Bảo hành VIP 3 tháng</option>
                            <option value="vip6">Bảo hành VIP 6 tháng</option>
                            <option value="vip12">Bảo hành VIP 12 tháng</option>
                        </select>

                        <div id="warrantyDetails" class="warranty-details">
                            <ul>
                                <li><strong>HOÀN TIỀN 7 NGÀY MIỄN PHÍ</strong> với BẤT KỲ LÝ DO GÌ (điện thoại cũ).</li>
                                <li>Bảo hành toàn diện cả <strong>nguồn và màn hình</strong> trong 6 tháng (máy cũ), 2 tháng
                                    (máy mới).</li>
                                <li>Thay pin iPhone miễn phí trọn đời (có vcare 1-1)</li>
                            </ul>
                        </div>

                        <a href="#">Thông tin bảo hành chi tiết</a>
                    </div>
                </div>

                <!-- Cột phải: Thông tin & hành động -->
                <div class="product-info">
                    <h2 class="fw-bold mb-3">{{ $product->proname }}</h2>
                    <div class="price">{{ number_format($product->price) }}đ</div>

                    <div class="product-highlight">
                        <strong>Mô tả nổi bật:</strong><br>
                        {!! nl2br(e($product->description)) !!}
                    </div>

                    <div class="actions">
                        <form action="{{ route('cartadd', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-shopping-cart"></i> MUA NGAY<br>
                                <small>Giao hàng hoặc xem tại cửa hàng</small>
                            </button>
                        </form>
                    </div>

                    <!-- ƯU ĐÃI KHI MUA SẢN PHẨM -->
                    <div class="promotion-box">
                        <h5><i class="bi bi-gift"></i> ƯU ĐÃI KHI MUA SẢN PHẨM</h5>

                        @if (isset($promotions) && $promotions->count() > 0)
                            <ul>
                                @foreach ($promotions as $promo)
                                    <li>
                                        <i class="bi bi-check-circle-fill text-warning"></i>
                                        <strong>{{ $promo->ten_uudai }}</strong><br>
                                        <small class="text-muted">{{ $promo->mota }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Hiện chưa có ưu đãi cho sản phẩm này.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Đánh giá của khách hàng -->
        <div class="customer-review">
            <h4 class="fw-bold mb-4">ĐÁNH GIÁ CỦA KHÁCH HÀNG</h4>
            <div class="review-container">
                <!-- Cột trái: điểm trung bình -->
                <div class="review-summary">
                    <h5>ĐÁNH GIÁ TRUNG BÌNH</h5>
                    <div class="review-score">0/5</div>
                    <div class="stars">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <p>(0 đánh giá)</p>
                </div>

                <!-- Cột phải: form đánh giá -->
                <div class="review-form">
                    <h6 class="fw-bold">Bạn muốn đánh giá sản phẩm này?</h6>
                    <label class="form-label">Chọn đánh giá của bạn:</label>
                    <div class="rating-stars mb-2">
                        <i class="bi bi-star" data-value="1"></i>
                        <i class="bi bi-star" data-value="2"></i>
                        <i class="bi bi-star" data-value="3"></i>
                        <i class="bi bi-star" data-value="4"></i>
                        <i class="bi bi-star" data-value="5"></i>
                    </div>
                    <textarea class="form-control mb-2" rows="3" placeholder="Hãy giúp chúng tôi đánh giá sản phẩm này!"></textarea>
                    <input type="text" class="form-control mb-2" placeholder="Họ tên (bắt buộc)">
                    <input type="text" class="form-control mb-3" placeholder="Số điện thoại">
                    <button class="btn btn-danger px-4">Gửi</button>
                </div>
            </div>
        </div>

    </section>

    <script>
        function changeImage(img) {
            document.getElementById('mainImage').src = img.src;
            const thumbnails = document.querySelectorAll('.product-thumbnails img');
            thumbnails.forEach(el => el.classList.remove('active'));
            img.classList.add('active');
        }

        function updateWarranty() {
            const select = document.getElementById('warrantySelect');
            const details = document.getElementById('warrantyDetails');

            const content = {
                standard: `
                <ul>
                    <li><strong>HOÀN TIỀN 7 NGÀY MIỄN PHÍ</strong> với BẤT KỲ LÝ DO GÌ (điện thoại cũ).</li>
                    <li>Bảo hành toàn diện cả <strong>nguồn và màn hình</strong> trong 6 tháng (máy cũ), 2 tháng (máy mới).</li>
                    <li>Thay pin iPhone miễn phí trọn đời (có vcare 1-1)</li>
                </ul>
            `,
                vip3: `
                <ul>
                    <li><strong>Bảo hành VIP 3 tháng:</strong> Bao gồm tất cả quyền lợi tiêu chuẩn.</li>
                    <li>Được ưu tiên kiểm tra, xử lý trong vòng <strong>24h</strong>.</li>
                    <li>Miễn phí 1 lần thay pin hoặc phụ kiện trong thời gian bảo hành.</li>
                </ul>
            `,
                vip6: `
                <ul>
                    <li><strong>Bảo hành VIP 6 tháng:</strong> Bao gồm tất cả quyền lợi VIP 3 tháng.</li>
                    <li>Miễn phí 2 lần thay pin hoặc linh kiện nhỏ.</li>
                    <li>Ưu tiên 1 đổi 1 nếu lỗi phát sinh trong 30 ngày đầu.</li>
                </ul>
            `,
                vip12: `
                <ul>
                    <li><strong>Bảo hành VIP 12 tháng:</strong> Quyền lợi cao nhất, toàn diện.</li>
                    <li>Bảo hành toàn phần máy 12 tháng, 1 đổi 1 trong 60 ngày.</li>
                    <li>Giảm 10% cho tất cả lần mua tiếp theo.</li>
                    <li>Hỗ trợ kỹ thuật tận nơi trong bán kính 10km.</li>
                </ul>
            `
            };

            details.innerHTML = content[select.value];
        }
        // Xử lý chọn sao đánh giá (đổi icon rỗng thành icon đầy)
        document.querySelectorAll('.rating-stars i').forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.dataset.value);
                const stars = document.querySelectorAll('.rating-stars i');
                stars.forEach((s, i) => {
                    if (i < value) {
                        s.classList.add('active');
                        s.classList.remove('bi-star');
                        s.classList.add('bi-star-fill');
                    } else {
                        s.classList.remove('active');
                        s.classList.remove('bi-star-fill');
                        s.classList.add('bi-star');
                    }
                });
            });
        });
    </script>
@endsection
