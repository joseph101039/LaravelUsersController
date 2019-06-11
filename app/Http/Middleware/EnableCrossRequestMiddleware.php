<?php

namespace App\Http\Middleware;
use Closure;
class EnableCrossRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        $allow_origin = [
            'http://localhost:8080',
        ];

        if (in_array($origin, $allow_origin)) {
            $response->header('Access-Control-Allow-Origin', $origin);

            //Access-Control-Allow-Headers: Indicates the allowed request headers for cross-origin requests
            $response->header('Access-Control-Allow-Headers', 'X-Requested-With, Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN, Cache-Control, access_token');
            $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
			$response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS', 'DELETE');
            $response->header('Access-Control-Allow-Credentials', 'true');

            //Per the spec requirements Vary: Origin doesn’t affect the behavior of the CORS-preflight cache.
            //Access-Control-Max-Age: Defines the expiration time of the result of the cached preflight request
            $response->header("Access-Control-Max-Age", "10");
            $response->header('Vary', 'Accept-Encoding, Origin, Access-Control-Request-Method, Access-Control-Request-Header');
        }
        return $response;
    }
}
