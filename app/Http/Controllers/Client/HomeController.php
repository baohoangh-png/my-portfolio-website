<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Thay thế limit(64)->get() bằng paginate(12)
        // Lấy 12 sản phẩm mỗi trang. Bạn có thể điều chỉnh số 12 này.
        // orderByDesc("id") vẫn được giữ nguyên để sắp xếp sản phẩm mới nhất trước.
        $listpro = Product::orderByDesc("id")->paginate(12);

        return view("client.index", ["listpro" => $listpro]);
    }

    // Nếu bạn có tính năng tìm kiếm và muốn phân trang cho nó, bạn có thể thêm như sau:
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $listpro = Product::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%') // Có thể thêm các trường tìm kiếm khác
            ->orderByDesc("id")
            ->paginate(12); // Áp dụng phân trang cho kết quả tìm kiếm

        return view('client.search_results', ['listpro' => $listpro, 'keyword' => $keyword]);
    }
}
