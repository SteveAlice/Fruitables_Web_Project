<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {

        $carts = \Auth::user()->carts();

        if ($carts->isEmpty()) {
            $shipping = 0;
        } else {
            $shipping = $carts->first()->order->shipping;
        }
        return view("/clients/cart", compact("carts", "shipping"));
    }
    public function create($id)
    {

        $currentOrder = \Auth::user()->orders->where('status', 'pending')->first();
        if (!$currentOrder) {
            $currentOrder = new Order();
            $currentOrder->user_id = \Auth::id();
            $currentOrder->total_amount = 0;
            $currentOrder->order_date = now();
            $currentOrder->shipping = 3.0;
            $currentOrder->save();
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
    public function update(Request $request, Cart $cart)
    {
        $change = $request->quality;
        $currentOrder = \Auth::user()->orders->where('status', 'pending')->first();

        // if (true) {

        //     $cartItem->update(['quantity' => $cartItem->quantity + 1]);
        // } else {
        //     $cartItem->update(['quantity' => $cartItem->quantity - 1]);
        // }

        return redirect()->route('user.cart.index');
    }

    public function delete($id)
    {
        \Auth::user()->carts()->where('id', $id)->first()->delete();
        return redirect()->route('user.cart.index');
    }
}
