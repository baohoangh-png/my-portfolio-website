<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductController extends Controller
{
    public function index($perpage = 5)
    {
        $list = Product::with(['category', 'brand'])
            ->select('id', 'proname as productname', 'price', 'cateid', 'brandid', 'description') // ✅ Bỏ 'fileName'
             ->orderBy('id', 'asc')
            ->paginate($perpage);

        return view('admin.products.index', compact('list', 'perpage'));
    }

    public function create()
    {
        $categories = Category::orderBy('catename')->get();
        $brands = Brand::orderBy('brandname')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

 public function store(ProductRequest $request)
{
    $fileName = null;

    if ($request->hasFile('fileName')) {
        $file = $request->file('fileName');
        $fileName = Str::slug($request->proname) . '-' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('products', $fileName, 'public');
    }

    try {
        Product::create([
            'proname' => $request->proname,
            'price' => $request->price,
            'cateid' => $request->cateid,
            'brandid' => $request->brandid,
            'description' => $request->description,
            'fileName' => $fileName, // lưu tên file ảnh
        ]);
        $message = 'Thêm thành công';
    } catch (Throwable $th) {
        $message = 'Thêm thất bại - Lỗi: ' . $th->getMessage();
    }

    return redirect()->route('pro.create')->withInput()->with('message', $message);
}



    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('catename')->get();
        $brands = Brand::orderBy('brandname')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }
public function update(ProductRequest $request, $id)
{
    $product = Product::findOrFail($id);
    $fileName = $product->fileName; // Mặc định giữ ảnh cũ nếu không upload ảnh mới

    if ($request->hasFile('fileName')) { // Sửa tên ở đây thành 'fileName'
        $file = $request->file('fileName');

        // Nếu có ảnh cũ, xóa ảnh cũ đi
        if ($fileName && Storage::disk('public')->exists('products/' . $fileName)) {
            Storage::disk('public')->delete('products/' . $fileName);
        }

        // Tạo tên file mới
        $fileName = Str::slug($request->proname) . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Lưu file vào storage/app/public/products
        $file->storeAs('products', $fileName, 'public');
    }

    $message = null;
    try {
        $product->update([
            'proname' => $request->proname,
            'price' => $request->price,
            'cateid' => $request->cateid,
            'brandid' => $request->brandid,
            'description' => $request->description,
            'fileName' => $fileName, // Luôn cập nhật tên file, giữ ảnh cũ nếu không upload ảnh mới
        ]);

        $message = 'Cập nhật thành công';
    } catch (Throwable $th) {
        $message = 'Cập nhật thất bại - Lỗi: ' . $th->getMessage();
    }

    return redirect()->route('pro.edit', $id)->withInput()->with('message', $message);
}

    public function delete($id)
    {
        $message = null;
        try {
            $product = Product::findOrFail($id);

            // ✅ Nếu có ảnh, xóa file
            if ($product->fileName && Storage::disk('public')->exists('products/' . $product->fileName)) {
                Storage::disk('public')->delete('products/' . $product->fileName);
            }

            $product->delete();
            $message = 'Xóa thành công';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('pro.index')->with('message', $message);
    }
}
