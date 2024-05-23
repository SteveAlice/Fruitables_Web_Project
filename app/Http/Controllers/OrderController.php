<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('status', '!=', 'pending')->get();
        return view('admin.orders-index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $order = Order::findOrFail($id);
        $carts = $order->carts;
        if ($carts->isEmpty()) {
            $shipping = 0;
        } else {
            $shipping = $carts->first()->order->shipping;
        }

        return view('clients.order-detail', compact('carts', 'shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order)
    {    
        if (! $order->update(['status' => 'shipping'])) {
            return redirect()->route('admin.orders.index')->with('notice', 'Order Updated failure!!');
        }
        $notification = new Notification();
        $notification->user_id = $order->user_id;
        $notification->message = 'You order '. $order->id .' are shipping now.';
        $notification->order = $order->id;
        $notification->read = false; 
        $notification->save();
        return redirect()->route('admin.orders.index')->with('notice', 'Order Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function notify(Request $request){
        Notification::where('user_id', \Auth::user()->id)->update(['read' => true]);
        return redirect()->back();
    }
}
