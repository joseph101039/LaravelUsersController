<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
            ->header('Content-type: application/json')
            ->header("Content-Type:text/html; charset=utf-8")
            ->header("Access-Control-Allow-Credentials: false")  // 相對應 axios 的設定，若有使用cookie、session則要開啟, 否則瀏覽器不會將response返回
            ->header("Access-Control-Allow-Origin: *")  // 指定可允許訪問的URL
            ->header("Access-Control-Allow-Methods: POST, GET, OPTIONS") // 允許客戶端可使用的方式
            ->header("Access-Control-Allow-Headers: X-PINGOTHER, Content-Type, X-Requested-With"); // 服務器允許請求中攜帶字段

//        return $next($request);
    }
}
