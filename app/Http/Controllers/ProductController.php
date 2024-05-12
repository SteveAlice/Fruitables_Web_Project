<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        $products = Product::all();
        $categories = Category::all();
        return view("/clients/home",compact("products", "categories"));
    }
    public function showDetail($id){
        $product = Product::find($id);
        $categoryName = Category::find($product->category_id)->name;
        return view("/clients/shop-detail",compact("product", "categoryName"));
    }
    public function search(Request $request)
   {
    $categories = Category::all();
    $searchKeyword = $request->input('searchKeyword');
    $products = Product::where('name', 'like', '%'.$searchKeyword.'%')->get();
   
    return view("/clients/home", compact("products","categories"));
   }
}
