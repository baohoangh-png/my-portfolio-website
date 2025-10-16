@extends('layout.admin')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container mt-4">
    <h2>Đổi mật khẩu</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('ad.changepass') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Mật khẩu mới</label>
            <input type="password" name="new_password" class="form-control" required>
            @error('new_password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
    </form>
</div>
@endsection
