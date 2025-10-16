@extends('layout.admin')

@section('title', 'Danh sách người dùng')

@section('content')
    <div class="container mt-4">
        <h2>Danh sách người dùng</h2>

        {{-- Hiển thị thông báo khi đăng ký thành công --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @switch($user->role)
                                @case('admin')
                                    Quản trị
                                @break

                                @case('staff')
                                    Nhân viên
                                @break

                                @case('customer')
                                    Khách hàng
                                @break

                                @default
                                    Không xác định
                            @endswitch
                        </td>
                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Chưa có' }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Không có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
