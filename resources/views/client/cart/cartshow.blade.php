@extends('layout.client_cart')
@section('content')
    @php
        $cart = Session::get('cart', []);
        $total = 0;
    @endphp
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <h3>Thông tin giỏ hàng</h3>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <table class="table table-bordered table-striped mb-4">
                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Sản phẩm</td>
                        <td>Số lượng</td>
                        <td>Giá </td>
                        <td>Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        @php
                            $total += $item['price'] * $item['quantity'];
                        @endphp
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item['proname'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price']) }}</td>
                            <td>{{ number_format($item['price'] * $item['quantity']) }}</td>
                            <td><a href="{{ route('cartdel', ['id' => $item['productid']]) }}" class="text-danger">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($cart) > 0)
                        <tr>
                            <td colspan="4"><strong>Tổng tiền</strong></td>
                            <td><strong>{{ number_format($total) }}</strong></td>
                            <td></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Giỏ hàng của bạn đang trống. <a
                                    href="{{ route('client.products.index') }}">Mua sắm ngay!</a></td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if (count($cart) > 0)
                <div class="card p-4 shadow-sm">
                    <h4 class="mb-3">Thông tin giao hàng</h4>
                    <form action="{{ route('cartsave') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                value="{{ old('fullname') }}" required>
                            @error('fullname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tel" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="tel" name="tel"
                                value="{{ old('tel') }}" required>
                            @error('tel')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address') }}" required>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Ghi chú cho đơn hàng (Tùy chọn)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        {{-- Thêm input ẩn để gửi tổng tiền nếu bạn muốn kiểm tra ở backend --}}
                        <input type="hidden" name="total_amount" value="{{ $total }}">

                        <button type="submit" class="btn btn-warning mt-3">Đặt hàng và Thanh toán</button>
                    </form>
                </div>
            @endif
        </div>
    </section>
@endsection
