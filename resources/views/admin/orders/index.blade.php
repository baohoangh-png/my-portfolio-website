@extends('layout.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <h2>Danh sách đơn hàng</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID Đơn hàng</th>
                <th>Khách hàng</th>
                <th>Ngày tạo</th>
                <th>Tổng sản phẩm</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }} (ID: {{ $order->customer->id }})</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->items->count() }}</td>
                    <td><a href="{{ route('ad.orders.show', $order->id) }}">Chi tiết</a></td>

                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
