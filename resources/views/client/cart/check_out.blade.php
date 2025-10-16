<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán đơn hàng</title>
    <!-- Sử dụng Tailwind CSS hoặc file CSS của bạn -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* Align items to the top */
            min-height: 100vh;
            padding-top: 50px;
            /* Add some padding to the top */
        }

        .checkout-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .summary-card,
        .payment-options-card {
            text-align: left;
            margin-bottom: 25px;
        }

        .summary-card p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
            display: flex;
            justify-content: space-between;
        }

        .summary-card p strong {
            color: #333;
        }

        .summary-card span {
            font-weight: 600;
            color: #222;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .payment-option:hover {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .payment-option.selected {
            border-color: #007bff;
            background-color: #e6f2ff;
        }

        .payment-option input[type="radio"] {
            margin-right: 12px;
            transform: scale(1.2);
        }

        .payment-option label {
            flex-grow: 1;
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }

        .payment-option .icon {
            margin-left: auto;
            width: 30px;
            height: 30px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .icon.momo {
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/f/fe/MoMo_Logo.png');
            /* Thay bằng đường dẫn ảnh MoMo của bạn */
        }

        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            width: 100%;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="checkout-container">
        <h1>Thanh toán đơn hàng</h1>

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="summary-card bg-white p-6 rounded-lg shadow-sm mb-6 border border-gray-200">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Tóm tắt đơn hàng</h2>
            <p>
                <strong>Mã đơn hàng:</strong>
                <span id="orderIdDisplay">{{ $order->id ?? 'N/A' }}</span>
            </p>
            <p>
                <strong>Tổng tiền:</strong>
                <span id="totalAmountDisplay">{{ number_format($order->total_amount ?? 0, 0, ',', '.') }} VNĐ</span>
            </p>
            {{-- Bạn có thể hiển thị danh sách sản phẩm nếu $order->items có dữ liệu --}}
            {{--
            @if(isset($order->items) && count($order->items) > 0)
                <h3 class="text-lg font-medium mt-4 mb-2">Chi tiết sản phẩm:</h3>
                <ul class="list-disc pl-5">
                    @foreach($order->items as $item)
                        <li>{{ $item->productName }} x {{ $item->quantity }} - {{ number_format($item->subtotal, 0, ',', '.') }} VNĐ</li>
            @endforeach
            </ul>
            @endif
            --}}
        </div>

        <div class="payment-options-card bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Chọn phương thức thanh toán</h2>

            <form id="paymentForm" action="{{ route('checkout.complete') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id ?? '' }}">

                <div class="payment-option @if(old('payment_method', 'COD') == 'COD') selected @endif" data-method="COD">
                    <input type="radio" id="cod" name="payment_method" value="COD" @if(old('payment_method', 'COD' )=='COD' ) checked @endif>
                    <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>

                <div class="payment-option @if(old('payment_method') == 'BANK_TRANSFER') selected @endif" data-method="BANK_TRANSFER">
                    <input type="radio" id="bankTransfer" name="payment_method" value="BANK_TRANSFER" @if(old('payment_method')=='BANK_TRANSFER' ) checked @endif>
                    <label for="bankTransfer">Chuyển khoản ngân hàng</label>
                </div>

                <div class="payment-option @if(old('payment_method') == 'MOMO') selected @endif" data-method="MOMO">
                    <input type="radio" id="momo" name="payment_method" value="MOMO" @if(old('payment_method')=='MOMO' ) checked @endif>
                    <label for="momo">Thanh toán qua MoMo</label>
                    <div class="icon momo"></div>
                </div>

                <!-- Thêm các phương thức thanh toán khác nếu cần -->

                <button type="submit" class="btn-primary" id="completePaymentButton">Hoàn tất thanh toán</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option');
            const radioButtons = document.querySelectorAll('input[name="payment_method"]');

            // Set initial selected state based on checked radio
            radioButtons.forEach(radio => {
                if (radio.checked) {
                    radio.closest('.payment-option').classList.add('selected');
                }
            });

            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to the clicked option
                    this.classList.add('selected');

                    // Check the radio button inside the clicked option
                    this.querySelector('input[type="radio"]').checked = true;
                });
            });
        });
    </script>
</body>

</html>