@extends('layout.client_cart')
@section('content')
    @php
        // get giỏ hàng từ session
        $cart = Session::get('cart', []);
        $total = 0;
    @endphp
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <h3>Vui lòng điền thông tin</h3>
            {{-- call component --}}
            <x-alert></x-alert>
            <form action="{{ route('cartsave') }}" method="POST" class="shadow-lg w-50 p-3">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="f-fullname" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="f-fullname" name="fullname" value="{{ old('fullname') }}">
                </div>
                <div class="mb-3 mt-3">
                    <label for="f-tel" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="f-tel" name="tel" value="{{ old('tel') }}">
                </div>
                <div class="mb-3 mt-3">
                    <label for="f-address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="f-address" name="address" value="{{ old('address') }}">
                </div>
                <div class="mb-3 mt-3">
                    <label for="f-description" class="form-label">Ghi chú cho đơn hàng</label>
                    <input type="text" class="form-control" id="f-description" name="description"
                        value="{{ old('description') }}">
                </div>
                <button type="submit" class="btn btn-primary">Đặt hàng</button>
            </form>
            <hr>
            <table class="table table-bordered table-striped">
                <thead>
                    <td>STT</td>
                    <td>Sản phẩm</td>
                    <td>Số lượng</td>
                    <td>Giá </td>
                    <td>Thành tiền</td>
                    <td></td>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        @php
                            $total += $item['price'] * $item['quantity'];
                        @endphp
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            {{-- do $cart là kiểu mảng nên để get dữ liệu sử dụng ['key'] --}}
                            <td>{{ $item['proname'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price']) }}</td>
                            <td>{{ number_format($item['price'] * $item['quantity']) }}</td>
                            <td><a href="{{ route('cartdel', ['id' => $item['productid']]) }}">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">Tổng tiền</td>
                        <td>{{ number_format($total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
