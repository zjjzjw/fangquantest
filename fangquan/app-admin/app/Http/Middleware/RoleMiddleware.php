<?php

namespace App\Admin\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class RoleMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $name = $request->route()->getName();
        if (!$request->user()->can($name)) {
            $errors = array(
                '1' => ['权限不足'],
            );
            if ($request->ajax()) {
                return response($errors, 401);
            } else {
                return redirect('/error')->withErrors($errors);
            }
        }
        return $next($request);
    }
}
