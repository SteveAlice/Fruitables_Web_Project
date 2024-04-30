<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function catSubcatList(Request $request){
        $data = [
            'pageTitle' => 'Category & Subcategory management',
        ];
        return view('back.pages.admin.cat-subcats-list', $data);
    }
}
