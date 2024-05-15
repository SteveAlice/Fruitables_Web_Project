<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
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
        if ($carts != null) {
            $shipping = $carts->first()->order->shipping;
        } else {
            $shipping = 0;
        }
        return view("/clients/cart", compact("carts", "shipping"));
    }
    public function create($id)
    {
        if (\Auth::check()) {
            $currentOrder = \Auth::user()->orders->where('status', 'pending')->first();
        } else {
            return redirect()->route('login');
        }
        if (
            $currentOrder->carts->isEmpty()
            || $currentOrder->carts->where('product_id', $id)->first() == null
        ) {
            Cart::create([
                'order_id' => $currentOrder->id,
                'product_id' => $id,
                'quantity' => 1,
            ]);
        } else {
            $cartItem = $currentOrder->carts->where('product_id', $id)->first();
            $cartItem->update(['quantity' => $cartItem->quantity + 1]);
        }

        return redirect()->route('home');
    }
    public function update(Request $request)
    {
        $id = $request->input('id');
        if (\Auth::check()) {
            $currentOrder = \Auth::user()->orders->where('status', 'pending')->first();
        } else {
            return redirect()->route('login');
        }
        $cartItem = $currentOrder->carts->where('product_id', $id)->first();
        if (true) {

            $cartItem->update(['quantity' => $cartItem->quantity + 1]);
        } else {
            $cartItem->update(['quantity' => $cartItem->quantity - 1]);
        }

        return redirect()->route('user.cart.index');
    }

    public function delete($id)
    {
        \Auth::user()->carts()->where('id', $id)->first()->delete();
        return redirect()->route('user.cart.index');
    }
}
