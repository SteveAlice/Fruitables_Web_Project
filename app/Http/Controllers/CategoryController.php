<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories-index', compact('categories'));
    }

    // Hiển thị form tạo mới category
    public function create()
    {
        return view('admin.categories-create');
    }

    // Lưu category mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:155|unique:categories',
        ]);
        $cat = new Category();
        $cat->name = $request->name;
        
        if (! $cat->save()) {
            return redirect()->route('admin.categories.index')->with('notice', 'Category added failure!!');
        }
        return redirect()->route('admin.categories.index')->with('notice', 'Category added successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:155|unique:categories,name,'. $category->name,
        ]);

        $data = $request->only('name');
        
        if (! $category->update($data)) {
            return redirect()->route('admin.categories.index')->with('notice', 'Category Updated failure!!');
        }
        return redirect()->route('admin.categories.index')->with('notice', 'Category Updated successfully!');
    }
    public function destroy(Category $category)
    {
        if ($category->products->count() > 0) {
            return redirect()->route('admin.categories.index')->with('notice', "Category deletion failure cuz this $category->name has ". $category->products->count() .' product' );
        }
 
        if (! $category->delete()) {
            return redirect()->route('admin.categories.index')->with('notice', 'Category deletion failure!');
        }

        return redirect()->route('admin.categories.index')->with('notice', 'Category removed successfully!');
    }
}
