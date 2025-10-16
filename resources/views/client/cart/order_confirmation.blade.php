<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .confirmation-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #28a745;
            /* Green for success */
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
        }

        .order-id-display {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .btn-home {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            text-decoration: none;
        }

        .btn-home:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="confirmation-container">
        <h1>🎉 Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi.</p>
        <p>Mã đơn hàng của bạn là:</p>
        <div class="order-id-display">{{ $orderId ?? 'N/A' }}</div>

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <p class="mt-8">Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng và hướng dẫn thanh toán chi tiết.</p>
        <a href="{{ route('homepage') }}" class="btn-home mt-6 inline-block">Tiếp tục mua sắm</a>
    </div>
</body>

</html>