<?php

namespace App\Http\Middleware\Client;

use Closure;

class ClientAuthMiddleware
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
        if(session('client_id') == null){
            return redirect(url('client/login'));
        }
        return $next($request);
    }
}
