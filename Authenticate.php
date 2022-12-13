<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if($request->routeIs('admin.*')){
                return route('admin.login');
            }elseif ($request->routeIs('super_admin.*')) {
                return route('super_admin.login');
            }elseif ($request->routeIs('business_owner.*')) {
                return route('business_owner.login');
            }else {
                return route('student.login');
            }
        }
    }
}