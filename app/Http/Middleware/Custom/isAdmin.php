<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Support\Facades\Auth;

class isAdmin
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
        if(Auth::user() && Auth::user()->role_id != '1'){
            $notification = array(
                'message' => 'You are not allowed to access this page!',
                'alert-type' => 'error'
            );
            return redirect(url('home'))->with($notification);
        }else{
            return $next($request);
        }
    }
}
