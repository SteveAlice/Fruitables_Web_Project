<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $data = [
            'pageTitle' => 'Add Product',
            'categories' => Category::orderBy('category_name', 'asc')->get()
        ];
        return view('back.pages.seller.add-product', $data);
    }

    public function getProductCategory(Request $request)
    {
        $category_id = $request->category_id;

        // Tìm danh mục cha dựa trên category_id
        $category = Category::findOrFail($category_id);

        // Lấy tất cả các danh mục con của danh mục cha
        $subcategories = SubCategory::where('category_id', $category_id)
                                    ->where('is_child_of', 0) // Chỉ lấy các danh mục không phải là con
                                    ->orderBy('subcategory_name', 'asc')
                                    ->with('children') // Tải sẵn các danh mục con
                                    ->get();

        // Xây dựng HTML cho danh sách tùy chọn
        $html = '';
        foreach ($subcategories as $subcategory) {
            $html .= '<option value="' . $subcategory->id . '">' . $subcategory->subcategory_name . '</option>';

            // Nếu danh mục con có
            if (count($subcategory->children) > 0) {
                foreach ($subcategory->children as $child) {
                    $html .= '<option value="' . $child->id . '">--' . $child->subcategory_name . '</option>';
                }
            }
        }

        // Trả về JSON response chứa HTML
        return response()->json(['status' => 1, 'data' => $html]);
    }
}
