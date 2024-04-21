<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
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
        // Gửi request tiếp theo trong chuỗi middleware và nhận response trả về
        $response = $next($request);

        // Thiết lập các HTTP headers để điều khiển caching của response
        return $response->header('Cache-Control', 'nocache, no-store, max-age=0;must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1998 01:00:00 GMT'); //Header Expires xác định thời điểm hết hạn của response, trong trường hợp này là một thời điểm trong quá khứ (01 Jan 1998) để đảm bảo rằng response sẽ không được lưu trữ trong cache.
    }
}
