<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đặt lại mật khẩu</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-3 ">
        <form action="{{ route('ad.reset', $user->id) }}" method="POST"
            class="mx-auto shadow-lg p-4 w-50 bg-light rounded">
            @csrf
            <h2 class="mb-4 text-center">Đặt lại mật khẩu</h2>
            <p class="text-center text-muted">Tài khoản: <strong>{{ $user->email }}</strong></p>

            {{-- Hiển thị lỗi nếu có --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="mb-3">
                <label for="new_password">Mật khẩu mới</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
                @error('new_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                    class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Cập nhật mật khẩu</button>

            <div class="text-end mt-2">
                <a href="{{ route('ad.login') }}">Quay lại đăng nhập</a>
            </div>
        </form>
    </div>
</body>

</html>
