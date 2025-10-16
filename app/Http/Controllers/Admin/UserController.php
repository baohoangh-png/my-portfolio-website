<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách người dùng
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Hiển thị form tạo user mới
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu nhập
        $request->validate([
            'username' => 'required|unique:users,username',
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|integer',
        ]);

        // Tạo user mới
        $user = new User();
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Tạo người dùng thành công.');
    }

    public function edit($id)
    {
        // Hiển thị form chỉnh sửa user
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu nhập
        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|integer',
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->role = $request->role;

        // Nếu có đổi mật khẩu
        if ($request->password) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    public function destroy($id)
    {
        // Xóa user
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công.');
    }

    // Phần login, logout, đổi mật khẩu, quên mật khẩu giữ nguyên của bạn

    public function login()
    {
        return view('admin.users.login');
    }

    public function loginpost(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('ad.login')->with('message', 'Email không tồn tại')->withInput();
        }
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return redirect()->route('ad.login')->with('message', 'Mật khẩu không đúng')->withInput();
        }
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);
        return redirect()->intended(route('ad.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('message', 'Đăng xuất thành công');
    }

    public function changepass(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng.');
        }

        $user->password = Hash::make($request->new_password);
        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công.');
    }

    public function showChangePassForm()
    {
        return view('admin.users.changepass');
    }

    public function forgotpassform()
    {
        return view('admin.users.forgotpassform');
    }

    public function forgotpass(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('ad.forgotpass')
                ->with('message', 'Email không tồn tại trong hệ thống.')
                ->withInput();
        }

        $passrandom = Str::random(10);
        $passencrypte = Hash::make($passrandom);
        User::where('email', $request->email)->update(['password' => $passencrypte]);

        $html = "<h2>Mật khẩu mới của bạn là: $passrandom. Vui lòng đổi mật khẩu sau khi nhận được mật khẩu mới</h2>";
        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)->subject('Đặt lại mật khẩu');
        });

        return redirect()->route('ad.forgotpass')
            ->with('message', 'Mật khẩu mới đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư đến.');
    }
}
