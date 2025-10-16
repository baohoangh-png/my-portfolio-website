<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>


    </style>
</head>



<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

        <a class="navbar-brand ps-3" href="index.html">My Admin</a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>

        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href={{ route('ad.changepass.form') }}>Đổi mật khẩu</a></li>
                    <li>
                        <form action="{{ route('ad.logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">Đăng xuất</button>
                        </form>
                    </li>
                    <li><a class="dropdown-item" href={{ route('layout.client') }}>Quay lại trang bán hàng</a></li>

                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a class="nav-link" href="{{ route('cate.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Loại sản phẩm
                        </a>


                        <a class="nav-link collapsed" href="{{ route('brand.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tag"></i></div>
                            Thương hiệu
                        </a>



                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-bag"></i></div>
                            Sản phẩm
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('pro.index') }}">Danh sách</a>

                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="{{ route('ad.customers.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Khách hàng
                        </a>
                        <a class="nav-link collapsed" href="{{ route('ad.orders.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Đơn hàng
                        </a>

                        <hr class="sidebar-divider">

                        <a class="nav-link" href="{{ route('users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                            Người dùng
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ Auth::check() ? Auth::user()->fullname : 'Guest' }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <script>
        fetch('/admin/data')
            .then(res => res.json())
            .then(data => {
                let html = '<ul>';
                data.forEach(user => {
                    html += `<li>${user.fullname} - ${user.email}</li>`;
                });
                html += '</ul>';
                document.getElementById('result').innerHTML = html;
            })
            .catch(err => {
                console.error('Lỗi khi fetch:', err);
                document.getElementById('result').innerText = 'Không thể lấy dữ liệu.';
            });
    </script>

</body>

</html>
