<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryClientController extends Controller
{
    // Hiển thị các sản phẩm thuộc danh mục
    public function detail($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('client.categories.detail', compact('category'));
    }
}
