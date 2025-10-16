@extends('layout.admin')

@section('title', 'Danh sách khách hàng')

@section('content')
    <h2>Danh sách khách hàng</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Số đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->fullname }}</td>
                    <td>{{ $customer->tel }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->orders()->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
