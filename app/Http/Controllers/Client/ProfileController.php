<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('client.profile.profile', compact('user'));
    }

    public function update(Request $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only('fullname', 'email', 'phone', 'address'));

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
