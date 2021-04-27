<?php

namespace App\Http\Middleware\Custom;

use Closure;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ContactModuleAuth
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
        $user = Auth::user();

        $module = Module::where(['module_name'=>'contact_module', 'role_id'=>$user->role->id])->first();

        // if route is authorised, then next, else redirect to home with a notification
        return $next($request);
    }
}
