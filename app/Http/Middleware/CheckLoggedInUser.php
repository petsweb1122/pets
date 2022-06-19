<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoggedInUser {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!empty(session()->get('user_data'))) {
            return $next($request);
        } else {
            return redirect()->action('Front\UsersController@getLogin');
        }
    }

}
