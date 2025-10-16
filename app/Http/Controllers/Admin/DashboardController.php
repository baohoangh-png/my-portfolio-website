<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


class DashboardController extends Controller{
    public function index(){
        return view("admin.dashboard");
    }
    public function getData()
{
    $users = \App\Models\User::all(); // hoặc bất kỳ dữ liệu nào bạn muốn
    return response()->json($users);
}
    
}
