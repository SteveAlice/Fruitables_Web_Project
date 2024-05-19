<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        $categories = Category::all();
        return view("/clients/home", compact("products", "categories"));
    }
    public function adminIndex(){
        $products = Product::all();
        return view('admin.products-index', compact("products"));
    }
    public function create(){
        $categories = Category::orderBy('name', 'ASC')->select('id', 'name')->get();
        return view('admin.products-create', compact("categories"));
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:155|unique:products',
            'category' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:9048',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $product->image = $imageName;
        }
        $product->save();
        return redirect()->route('admin.product.index')->with('notice', 'Product added successfully!');
    }
    public function edit(Product $product){
        $categories = Category::orderBy('name', 'ASC')->select('id', 'name')->get();
        return view('admin.products-edit', compact('categories', 'product'));
    }
    public function destroy(Product $product)
    {

        if (! $product->delete()) {
            return redirect()->route('admin.product.index')->with('notice', 'Product deletion failure!');
        }
        return redirect()->route('admin.product.index')->with('notice', 'Product removed successfully!');
    }
    public function showDetail($id)
    {
        $product = Product::find($id);
        $categoryName = Category::find($product->category_id)->name;
        return view("/clients/shop-detail", compact("product", "categoryName"));
    }
    public function search(Request $request)
    {
        $categories = Category::all();
        $searchKeyword = $request->input('searchKeyword');

        if (!empty($searchKeyword)) {
            $products = Product::where('name', 'like', '%' . $searchKeyword . '%')->get();
        } else {
            $products = Product::all(); 
        }
        return view("/clients/shop", compact("products", "categories"));
    }
}
