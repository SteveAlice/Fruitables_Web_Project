<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    // Hiển thị form tạo mới category
    public function create()
    {
        //
    }

    // Lưu category mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        //
    }

    // Hiển thị thông tin chi tiết của một category
    public function show($id)
    {
        //
    }

    // Hiển thị form chỉnh sửa category
    public function edit($id)
    {
        //
    }

    // Cập nhật thông tin category trong cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        //
    }

    // Xóa một category khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        //
    }
}
