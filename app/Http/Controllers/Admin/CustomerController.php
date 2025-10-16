<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all(); // chỉ lấy thông tin khách hàng

        return view('admin.customers.index', compact('customers'));
    }
}
