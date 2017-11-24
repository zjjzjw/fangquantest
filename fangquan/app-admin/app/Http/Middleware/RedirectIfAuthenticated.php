<?php

namespace App\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {

            if ($request->ajax()) {
                //如果是ajax,不限制
                $errors = array(
                    '1' => ['权限不足'],
                );
                return response($errors, 401);
            } else {
                return redirect('/login');
            }
        }
        return $next($request);
    }
}
