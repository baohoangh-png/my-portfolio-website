<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $list = Brand::orderBy('brandname')
            ->paginate(8);

        if ($request->ajax()) {
            return view("admin.brands.list", compact("list"));
        }
        return view("admin.brands.index", compact("list"));
    }

    public function create()
    {
        return view("admin.brands.create");
    }

    public function store(BrandRequest $request)
    {
        $message = null;
        try {
            Brand::create(
                [
                    'brandname' => $request->brandname,
                    'description' => $request->description,
                ]
            );
            $message = 'Thêm thành công';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi' . $th->getMessage();
        }
        return redirect()->route('brand.create')->withInput()->with('message', $message);
    }

    public function edit($id)
    {

        $brand = Brand::where('id', $id)->first();

        return view('admin.brands.edit', compact('brand'));
    }

    public function update($id, BrandRequest $request)
    {
        $message = null;
        try {
            $rowaffect = Brand::where('id', $id)
                ->update(
                    [
                        'brandname' => $request->brandname,
                        'description' => $request->description,
                    ]
                );
            $message = $rowaffect > 0 ? 'Cập nhật thành công' : 'Không có bản ghi nào được cập nhật';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi' . $th->getMessage();
        }

        return redirect()->route('brand.edit', $id)->withInput()->with('message', $message);
    }

    public function delete($id)
    {
        $message = null;
        try {
            $rowaffect = Brand::where('id', $id)->delete();
            $message = $rowaffect > 0 ? 'Xóa thành công' : 'Không có bản ghi nào được xóa';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi' . $th->getMessage();
        }

        return redirect()->route('brand.index')->with('message', $message);
    }
}
