<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles  // Nhận nhiều vai trò dưới dạng tham số
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            // Sử dụng redirect()->route('ad.login') để đảm bảo tên route đúng
            return redirect()->route('ad.login');
        }

        // 2. Lấy vai trò của người dùng hiện tại
        $userRole = Auth::user()->role;

        // Chuyển đổi các vai trò được truyền vào middleware từ string sang integer
        // (vì trong routes/web.php bạn truyền "role:1" hoặc "role:2")
        $numericRoles = array_map('intval', $roles);

        // 3. Kiểm tra xem vai trò của người dùng có trong danh sách các vai trò được phép không
        if (!in_array($userRole, $numericRoles)) {
            // Nếu người dùng không có vai trò hợp lệ, xử lý lỗi
            // Chuyển hướng về trang chủ hoặc hiển thị lỗi 403
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
            // Hoặc bạn có thể sử dụng:
            // abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Nếu tất cả kiểm tra đều thành công, cho phép yêu cầu tiếp tục
        return $next($request);
    }
}
