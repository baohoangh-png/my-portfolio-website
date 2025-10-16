<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>

    {{-- CSS của bạn --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    {{-- Bootstrap 5 (nếu chưa có thì thêm) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-card {
            max-width: 550px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.7s ease;
        }

        .register-card h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.65rem;
        }

        .form-select {
            border-radius: 8px;
            padding: 0.65rem;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #5b0ecc, #1c66e4);
        }

        .text-danger {
            font-size: 0.875rem;
        }

        .link-login {
            display: block;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .link-login a {
            color: #2575fc;
            text-decoration: none;
        }

        .link-login a:hover {
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
    <div class="register-card">
        <form action="{{ route('ad.store') }}" method="POST">
            @csrf
            <h2>📝 Đăng ký tài khoản</h2>

            <x-alert />

            <div class="mb-3">
                <label for="fullname" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}"
                    placeholder="Nhập họ tên">
                @error('fullname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username"
                    placeholder="Nhập tên đăng nhập" value="{{ old('username') }}">
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Nhập lại mật khẩu">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Vai trò</label>
                <select class="form-select" id="role" name="role">
                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Nhân viên</option>
                    <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>Khách hàng</option>
                </select>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>

            <div class="link-login">
                <a href="{{ route('ad.login') }}">Đã có tài khoản? Đăng nhập</a>
            </div>
        </form>
    </div>
</body>

</html>
