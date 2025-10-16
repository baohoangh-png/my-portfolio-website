@extends('layout.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>

        {{-- Thông tin khách hàng --}}
        <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ccc;">
            <h4>Thông tin khách hàng</h4>
            <p><strong>Họ tên:</strong> {{ $order->customer->fullname }}</p>
            <p><strong>SĐT:</strong> {{ $order->customer->tel }}</p>
        </div>

        {{-- Thông tin đơn hàng --}}
        <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ccc;">
            <h4>Thông tin đơn hàng</h4>
            <p><strong>Mã đơn:</strong> {{ $order->id }}</p>
            <p><strong>Ngày tạo:</strong> {{ $order->created_at }}</p>
            <p><strong>Tổng sản phẩm:</strong> {{ $order->items->count() }}</p>
        </div>

        {{-- Danh sách sản phẩm trong đơn hàng --}}
        <div>
            <h4>Sản phẩm trong đơn hàng</h4>
            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID sản phẩm</th>
                        <th>Tên sản phẩm</th> {{-- nếu bạn có quan hệ với bảng products --}}
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                @php $total = 0; @endphp
                <tbody>
                    @foreach ($order->items as $item)
                        @php
                            $lineTotal = $item->price * $item->quantity;
                            $total += $lineTotal;
                        @endphp
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ optional($item->product)->proname ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($lineTotal, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4" align="right"><strong>Tổng tiền:</strong></td>
                        <td><strong>{{ number_format($total, 0, ',', '.') }} đ</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


@endsection
