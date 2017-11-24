<?php namespace App\Hulk\Http\Middleware;

use App\Service\Utils\RestfulApiUtil;
use Closure;

class ApiResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        RestfulApiUtil::commonHeaders($request, $response);
        RestfulApiUtil::jsonResponse($request, $response);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Headers', 'token,content-type');
        $response->header('Access-Control-Allow-Methods', 'POST,PUT,GET,UPDATE,OPTIONS');

        return $response;
    }
}
