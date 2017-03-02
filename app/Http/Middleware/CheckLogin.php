<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\StsCode;
class CheckLogin
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
        if ($request->session()->has('userinfo')){
            return $next($request);
        }else{
            return  response()->json(outJson(StsCode::STATUS_ERROR,'未登陆,请登录'));
        }


    }
}
