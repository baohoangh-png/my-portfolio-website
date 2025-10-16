<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shop Homepage</title>
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />


</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!"><img src="{{ asset('images/logo.png') }}" alt="Logo của bạn"
                    style="height: 120px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page"
                            href="{{ route('homepage') }}">Trang chủ</a></li>
                    <li class="nav-item d-flex align-items-center ms-3">
                        <span class="text-danger fw-bold">
                            <i class="bi bi-telephone-fill me-1"></i> Hotline: 0375 189 350
                        </span>
                    </li>
                </ul>
                <div class="d-flex me-2">
                    <form action="{{ route('client.products.search') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm..."
                                required>
                            <button class="btn btn-outline-dark" type="submit">Tìm</button>
                        </div>
                    </form>
                </div>

                {{-- START: Thay thế phần Đăng nhập/Đăng xuất --}}
                <div class="d-flex me-2">
                    @auth
                        {{-- Nếu người dùng đã đăng nhập --}}
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownUser"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-fill me-1"></i>
                                {{ Auth::check() ? Auth::user()->fullname : 'Guest' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                                {{-- Thêm các liên kết khác cho user profile, order history nếu cần --}}
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="#">Đơn hàng của tôi</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        {{-- Nếu người dùng chưa đăng nhập --}}
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Đăng nhập
                        </a>
                    @endauth
                </div>
                {{-- END: Thay thế phần Đăng nhập/Đăng xuất --}}

                <div class="d-flex">
                    <a class="btn btn-outline-dark" href="{{ route('cartshow') }}">
                        <i class="bi bi-cart-fill me-1"></i>
                        Giỏ hàng
                        <span class="badge bg-dark text-white ms-1 rounded-pill">
                            {{ count(Session::get('cart', [])) }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="#products"> {{-- Thay #products bằng đường dẫn thực tế của banner này --}}
                        <img src="{{ asset('images/banner-ip17.png') }}" class="d-block w-100" alt="iphone 17"
                            style="height: 400px; object-fit: contain;">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="#products"> {{-- Thay #products bằng đường dẫn thực tế của banner này --}}
                        <img src="{{ asset('images/xiaomi-15t.png') }}" class="d-block w-100" alt="Xiaomi15t"
                            style="height: 400px; object-fit: contain;">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="#products"> {{-- Thay #products bằng đường dẫn thực tế của banner này --}}
                        <img src="{{ asset('images/xiaomi17.png') }}" class="d-block w-100" alt="Xiaomi17"
                            style="height: 400px; object-fit: contain;">
                    </a>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>
    <x-category-menu />
    <!-- Tiêu đề "SẢN PHẨM MỚI" -->

    <!-- Section-->
    <div class="container">
        <div class="container my-2">
            <h2 class="fw-bold text-uppercase mb-0" style="border-left: 5px solid red; padding-left: 10px;">
                Sản phẩm mới
            </h2>
        </div>
        @yield('content')
    </div>
    <!-- Footer-->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">

                <!-- Cột 1: Giới thiệu -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-warning">Nhật Website</h5>
                    <p>
                        Cửa hàng chuyên cung cấp các loại sản phẩm chất lượng cao.
                    </p>
                </div>

                <!-- Cột 2: Liên kết -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-warning">Liên kết</h5>
                    <p><a href="#" class="text-white text-decoration-none">Trang chủ</a></p>
                    <p><a href="#products" class="text-white text-decoration-none">Sản phẩm</a></p>
                    <p><a href="#about" class="text-white text-decoration-none">Giới thiệu</a></p>
                    <p><a href="#contact" class="text-white text-decoration-none">Liên hệ</a></p>
                </div>

                <!-- Cột 3: Hỗ trợ -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-warning">Hỗ trợ</h5>
                    <p><a href="#" class="text-white text-decoration-none">FAQ</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Chính sách bảo hành</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Chính sách đổi trả</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Hỗ trợ khách hàng</a></p>
                </div>

                <!-- Cột 4: Liên hệ -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-warning">Liên hệ</h5>
                    <p><i class="fas fa-home me-3"></i> 123 Đường ABC, TP HCM</p>
                    <p><i class="fas fa-envelope me-3"></i> support@nhatshop.com</p>
                    <p><i class="fas fa-phone me-3"></i> +84 123 456 789</p>
                    <p><i class="fas fa-print me-3"></i> +84 987 654 321</p>
                </div>

            </div>

            <hr class="mb-4">

            <!-- Dòng cuối -->
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p class="text-center text-md-start">
                        © 2025 Bản quyền: <a href="#" class="text-warning text-decoration-none fw-bold">Nhật Bảo
                            Website</a>
                    </p>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="text-center text-md-end">
                        <a href="#" class="btn btn-outline-light btn-floating m-1"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-light btn-floating m-1"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light btn-floating m-1"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light btn-floating m-1"><i
                                class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
