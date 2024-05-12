<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            $carts = \Auth::user()->carts();
        } else {
            $carts = session("carts");
        }
        return view("/clients/cart", compact("carts"));
    }
    public function add($id)
    {
        return redirect()->route('cart.show', ['id' => $id]);
    }
    public function delete($id)
    {

    }
}
