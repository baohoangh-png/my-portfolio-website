<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order; // Import model Order

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thanh toán.
     * Lấy thông tin đơn hàng từ session.
     */
    public function showCheckoutForm()
    {
        // Lấy order_id từ session sau khi đơn hàng đã được tạo tạm thời
        $orderId = Session::get('last_order_id');
        $order = null;

        if ($orderId) {
            // Lấy đối tượng Order từ database
            $order = Order::with('items.product')->find($orderId); // Load cả order items và product info
        }

        // Nếu không tìm thấy order hoặc không có orderId trong session
        if (!$order) {
            return redirect()->route('cartshow')->with('error', 'Không tìm thấy thông tin đơn hàng. Vui lòng thử lại.');
        }

        // Tính toán tổng tiền một lần nữa ở đây nếu cần (hoặc lấy từ $order->total_amount nếu có field đó)
        $totalAmount = 0;
        foreach ($order->items as $item) {
            $totalAmount += $item->price * $item->quantity;
        }
        $order->calculated_total_amount = $totalAmount; // Thêm một thuộc tính tạm thời để truyền vào view

        return view('client.cart.check_out', compact('order'));
    }

    /**
     * Xử lý hoàn tất thanh toán.
     */
    public function completePayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|numeric',
            'payment_method' => 'required|string|in:COD,BANK_TRANSFER,MOMO',
        ]);

        $orderId = $request->input('order_id');
        $paymentMethod = $request->input('payment_method');

        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->route('cartshow')->with('error', 'Đơn hàng không tồn tại.');
        }

        // Cập nhật thông tin thanh toán cho đơn hàng
        $order->payment_method = $paymentMethod; // Thêm trường payment_method vào bảng orders
        $order->status = 'pending_payment'; // Ví dụ: 'pending_payment', 'completed', ...
        $order->save();

        // Xóa last_order_id khỏi session sau khi hoàn tất thanh toán
        Session::forget('last_order_id');

        // Điều hướng đến trang xác nhận đơn hàng
        return redirect()->route('order.confirmation', ['orderId' => $order->id])
            ->with('success', 'Đơn hàng của bạn đã được tiếp nhận. Vui lòng hoàn tất thanh toán theo phương thức đã chọn.');
    }
}
