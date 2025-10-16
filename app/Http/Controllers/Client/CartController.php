<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;


class CartController extends Controller
{
    public function add(Request $req)
    {
        // lấy id từ URL (Xem đường dẫn -> devtool)
        $id = $req->route('id');
        // Lấy product trong db
        $product = Product::where("id", $id)->first();
        // lấy giỏ hàng từ session, nếu chưa tồn tại trả về mảng rỗng
        $cart = Session::get('cart', []);
        // kiểm tra xem giỏ hàng có id sản phẩm chưa
        if (isset($cart[$id])) {
            // nếu tồn tại rồi - tăng số lượng
            $cart[$id]['quantity'] += 1;
        } else {
            // nếu chưa tồn tại - tạo thêm sản phẩm
            $cart[$id] = [
                'productid' => $product->id,
                'proname' => $product->proname,
                'quantity' => 1,
                'price' => $product->price,
            ];
        }
        // lưu lại vào session
        Session::put('cart', $cart);
        // điều hướng về trang trước
        return redirect()->back();
    }

    public function del($id)
    {
        // lấy giỏ hàng từ session, nếu chưa tồn tại trả về mảng rỗng
        $cart = Session::get('cart', []);
        // kiểm tra xem giỏ hàng có id sản phẩm chưa
        if (isset($cart[$id])) {
            // nếu tồn tại rồi - tăng số lượng
            unset($cart[$id]);
        }
        // lưu lại vào session
        Session::put('cart', $cart);
        // điều hướng về trang trước
        return redirect()->back();
    }

    public function save(Request $req)
    {
        // kiểm tra dữ liệu đầu vào dùng validate
        // lấy giỏ hàng từ session,
        $cart = Session::get('cart');
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Không tồn tại giỏ hàng'); // Đổi 'mess' thành 'error' cho nhất quán
        }

        $customer = Customer::where('tel', $req->tel)->first();
        $customerid = null;
        if (empty($customer)) {
            $cusafterinsert = Customer::create(
                [
                    'fullname' => $req->fullname,
                    'tel' => $req->tel,
                    'address' => $req->address
                ]
            );
            $customerid = $cusafterinsert->id;
        } else {
            $customerid = $customer->id;
            // Cập nhật thông tin khách hàng nếu có thay đổi (tùy chọn)
            $customer->update([
                'fullname' => $req->fullname,
                'address' => $req->address
            ]);
        }

        // Tính tổng tiền từ giỏ hàng để lưu vào bảng orders (nếu bảng orders có cột total_amount)
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Lưu vào bảng orders
        $order = Order::create(
            [
                'customerid' => $customerid,
                'description' => $req->description ?? '',
                'total_amount' => $totalAmount, // THÊM DÒNG NÀY nếu bảng orders có cột total_amount
                'status' => 'pending', // Trạng thái ban đầu
                'payment_method' => null, // Sẽ được cập nhật ở trang thanh toán
            ]
        );
        $orderid = $order->id;

        // Lưu vào bảng orderitems
        foreach ($cart as $item) {
            OrderItem::create([
                'orderid' => $orderid,
                'productid' => $item['productid'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
        }

        // Xóa giỏ hàng trong session
        Session::forget('cart');

        // LƯU orderid VÀO SESSION để CheckoutController có thể lấy
        Session::put('last_order_id', $orderid);

        // Điều hướng đến trang thanh toán
        return redirect()->route('checkout.show');
    }
}
