<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\IsEmpty;

class CartController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            $carts = \Auth::user()->carts();
        } else {
            $carts = session("carts");
        }
        if (! $carts->isEmpty()) {
            $shipping = $carts->first()->order->shipping;
        } else {
            $shipping = 0;
        }
        return view("/clients/cart", compact("carts", "shipping"));
    }
    public function add($id)
    {
        return redirect()->route('cart.show', ['id' => $id]);
    }
    public function delete($id)
    {
        \Auth::user()->carts()->where('id', $id)->first()->delete();
        return redirect()->route('user.cart.index');
    }
}
