@extends('layout.client_profile')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4 text-primary">Thông tin cá nhân</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
            @csrf

            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $user->fullname) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
            </div>

            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>
@endsection
