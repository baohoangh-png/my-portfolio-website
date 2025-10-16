<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(to right, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background: #ffffffcc;
            backdrop-filter: blur(8px);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #5a67d8, #6b46c1);
        }

        .form-check-label {
            user-select: none;
        }

        .extra-links {
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .extra-links a {
            color: #5a67d8;
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <form action="{{ route('ad.loginpost') }}" method="POST">
            @csrf
            <h2>🔐 Đăng nhập hệ thống</h2>

            {{-- Thông báo lỗi --}}
            <x-alert></x-alert>

            <div class="mb-3">
                <label for="f-username" class="form-label">Email</label>
                <input type="text" class="form-control" id="f-username" placeholder="Nhập email" name="email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="f-password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="f-password" placeholder="Nhập mật khẩu" name="password">
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" class="btn btn-primary w-100" id="loginBtn">
                <span id="btnText">Đăng nhập</span>
                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
            </button>

            @if (session('message'))
                <div class="text-danger mt-2 text-center">{{ session('message') }}</div>
            @endif

            <div class="extra-links">
                <a href="{{ route('ad.create') }}">Đăng ký tài khoản</a>
                <a href="{{ route('ad.forgotpass') }}">Quên mật khẩu</a>
            </div>
        </form>
    </div>
    <script>
        const btn = document.getElementById('loginBtn');
        btn.addEventListener('click', () => {
            document.getElementById('btnText').classList.add('d-none');
            document.getElementById('btnSpinner').classList.remove('d-none');
        });
    </script>
</body>

</html>
