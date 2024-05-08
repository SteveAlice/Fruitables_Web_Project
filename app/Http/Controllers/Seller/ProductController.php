<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request){
        $data = [
            'pageTitle' => 'Add Product',
            'categories' => Category::orderBy('category_name','asc')->get()
        ];
        return view('back.pages.seller.add-product', $data);
    }
}
