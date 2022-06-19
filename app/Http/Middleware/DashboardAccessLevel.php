<?php

namespace App\Http\Middleware;

use Closure;

class DashboardAccessLevel
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$level)
    {
        $userData = json_decode(session()->get('user_data'));
        if (!in_array($userData->role, $level)) {
            return redirect()->action('Admin\OrdersController@getAllOrders');
        }

        return $next($request);
    }
}
