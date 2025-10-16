<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>

    {{-- CSS mặc định của bạn --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    {{-- Bootstrap (nếu cần) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS tùy chỉnh --}}
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .forgot-card {
            width: 100%;
            max-width: 450px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.6s ease;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 0.75rem;
            background: linear-gradient(to right, #1c92d2, #f2fcfe);
            color: #000;
            font-weight: 600;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #1c92d2, #a0d8ef);
        }

        .text-danger {
            font-size: 0.875rem;
        }

        .back-link {
            margin-top: 1rem;
            text-align: right;
            font-size: 0.9rem;
        }

        .back-link a {
            color: #1c92d2;
            text-decoration: none;
        }

        .back-link a:hover {
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
    <div class="forgot-card">
        <form action="{{ route('ad.forgotpasspost') }}" method="POST">
            @csrf
            <h2>🔐 Quên mật khẩu</h2>

            <x-alert></x-alert>

            {{-- Hiển thị thông báo lỗi --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    placeholder="Nhập email đã đăng ký" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Tiếp tục</button>

            <div class="back-link">
                <a href="{{ route('ad.login') }}">← Quay lại đăng nhập</a>
            </div>
        </form>
    </div>
</body>

</html>
