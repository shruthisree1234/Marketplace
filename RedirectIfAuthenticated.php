<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if($guard === 'admin'){
                    return redirect()->route('admin.dashboard');
                }elseif ($guard === 'super_admin') {
                    return redirect()->route('super_admin.dashboard');
                }elseif ($guard === 'business_owner') {
                    return redirect()->route('business_owner.dashboard');
                }else {
                    return redirect()->route('student.dashboard');
                    //return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}