<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CategoriesController extends Controller
{
    //Trả về view để hiển thị danh sách các danh mục và danh mục con.
    public function catSubcatList(Request $request)
    {
        $data = [
            'pageTitle' => 'Category & Subcategory management',
        ];
        return view('back.pages.admin.cat-subcats-list', $data);
    }
    // Trả về view cho trang thêm mới danh mục.
    public function addCategory(Request $request)
    {
        $data = [
            'pageTitle' => 'Add Category'
        ];
        return view('back.pages.admin.add-category', $data);
    }
    //Phương thức này được sử dụng để xử lý yêu cầu lưu trữ danh mục mới.
    public function storeCategory(Request $request)
    {
        //Validate form
        $request->validate([
            'category_name' => 'required|min:5|unique:categories,category_name',
            'category_image' => 'required|image|mimes:png,jpg,jpeg,svg',
        ], [
            'category_name.required' => ':Attribute is required',
            'category_name.min' => ':Attribute must contains at least 5 characters',
            'category_name.unique' => 'This :attribute is already exists',
            'category_image.required' => ':Attribute is required',
            'category_image.image' => ':Attribute must be an image',
            'category_image.mimes' => ':Attribute must be in JPG, PNG, or SVG format'
        ]);
        if ($request->hasFile('category_image')) {
            $path = 'images/categories';
            $file = $request->file('category_image');
            $filename = time() . '-' . $file->getClientOriginalName();

            // Create folder if it doesn't exist
            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path));
            }
            //Upload category image
            $upload = $file->move(public_path($path), $filename);

            if ($upload) {
                //Save category into Database
                $category = new Category;
                $category->category_name = $request->category_name;
                $category->category_image = $filename;
                $saved = $category->save();

                if ($saved) { {
                    // // Nếu thành công, chuyển hướng về trang thêm danh mục với thông báo thành công
                    return redirect()->route('admin.manage-categories.add-category')->with('success',
                    '<b>'.ucfirst($request->category_name).'</b> category has been added successfully!');
                    }
                } else {
                    // // Nếu không thành công, chuyển hướng về trang thêm danh mục với thông báo lỗi
                    return redirect()->route('admin.manage-categories.add-category')->with('error', 'Fail to add the category.Try again later');
                }
            } else {
                // // Nếu có lỗi trong quá trình di chuyển ảnh, chuyển hướng về trang thêm danh mục với thông báo lỗi
                return redirect()->route('admin.manage-categories.add-category')->with('fail', 'Something went wrong while uploading category image.');
            }
        }
    }
}
