<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $list = Category::with(['products'])->orderBy('catename')
            ->paginate(5);
        if ($request->ajax()) {
            return view("admin.categories.list", compact("list"));
        }
        return view("admin.categories.index", compact("list"));
    }

    public function create()
    {
        return view("admin.categories.create");
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'catename' => 'required|min:6|max:100|unique:categories,catename'
            ],
            [
                'catename.required' => ':attribute không được để trống',
                'catename.min' => ':attribute có ít nhất :min ký tự',
                'catename.max' => ':attribute không vượt quá :max ký tự',
                'catename.unique' => ':attribute đã tồn tại trong hệ thống',
            ],
            [
                'catename' => 'Tên loại sản phẩm/danh mục'
            ]
        );
        $message = null;
        try {
            Category::create(
                [
                    'catename' => $request->catename,
                    'description' => $request->description,
                ]
            );
            $message = 'Thêm thành công';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi' . $th->getMessage();
        }
        return redirect()->route('cate.create')->withInput()->with('message', $message);
    }

    public function edit($id)
    {
        $category = Category::where('cateid', $id)->first();

        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, Request $request)
    {
        $id = $request->route('id');
        $request->validate(
            [
                'catename' => 'required|min:6|max:100|unique:categories,catename,' . $id . ',cateid',
            ],
            [
                'catename.required' => ':attribute không được để trống',
                'catename.min' => ':attribute có ít nhất :min ký tự',
                'catename.max' => ':attribute không vượt quá :max ký tự',
                'catename.unique' => ':attribute đã tồn tại trong hệ thống',
            ],
            [
                'catename' => 'Tên loại sản phẩm/danh mục'
            ]
        );
        $message = null;
        try {
            $rowaffect = Category::where('cateid', $id)
                ->update(
                    [
                        'catename' => $request->catename,
                        'description' => $request->description,
                    ]
                );
            $message = $rowaffect > 0 ? 'Cập nhật thành công' : 'Không có bản ghi nào được cập nhật';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi' . $th->getMessage();
        }

        return redirect()->route('cate.edit', $id)->withInput()->with('message', $message);
    }

    public function delete($id)
    {
        $message = null;
        try {
            $rowaffect = Category::where('cateid', $id)->delete();
            $message = $rowaffect > 0 ? 'Xóa thành công' : 'Không có bản ghi nào được xóa';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi' . $th->getMessage();
        }

        return redirect()->route('cate.index')->with('message', $message);
    }
}
