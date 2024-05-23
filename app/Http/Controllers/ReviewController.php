<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:255',
            'rating' => 'required|min:0|max:5',
        ]);
        $rev = new Review();
        $rev->product_id = $request->product_id;
        $rev->user_id = \Auth::user()->id;
        $rev->content = $request->content;
        $rev->rating = $request->rating;
        $rev->created_at = Carbon::now();
        $rev->save();

        return redirect()->back();
    }
}
