<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart($id)
    {
       return redirect()->route('cart.show',['id' => $id]);
    }
}
