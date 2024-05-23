<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $orderId = $request->route('id');
        $order = Order::findOrFail($orderId);

        // Kiểm tra quyền truy cập
        if ($request->user()->role === 'admin' || $order->user_id === $request->user()->id) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
