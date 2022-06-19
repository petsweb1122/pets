<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class CheckCustomerOrderVerificationMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $userData = json_decode(session()->get('user_data'));

        // if ( !empty(request()->vendor_id )  && $userData->vendor_id != request()->vendor_id) {
        //     abort('401');
        // }


        return $next($request);
    }
}
