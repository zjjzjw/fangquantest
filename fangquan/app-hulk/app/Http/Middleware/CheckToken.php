<?php

namespace App\Hulk\Http\Middleware;

use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckToken
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
        CheckTokenService::setHeaders($request);
        CheckTokenService::checkToken();

        return $next($request);
    }
}
