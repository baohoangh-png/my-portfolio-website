<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductClientController extends Controller
{
    // Hiển thị chi tiết sản phẩm
    public function detail($id)
    {
        $product = DB::table('products')
            ->join('categories', 'products.cateid', '=', 'categories.cateid')
            ->select('products.*', 'categories.catename', 'categories.cateid')
            ->where('products.id', $id)
            ->first();

        if (!$product) {
            abort(404);
        }

        $promotions = DB::table('promotions')
            ->where('category_id', $product->cateid)
            ->get();
        return view('client.products.detail', compact('product', 'promotions'));
    }
    // Tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('proname', 'like', '%' . $keyword . '%')->get();

        return view('client.products.search', compact('products', 'keyword'));
    }

    // Hiển thị tất cả sản phẩm (optional)
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->paginate(12);
        return view('client.products.index', compact('products'));
    }
}
