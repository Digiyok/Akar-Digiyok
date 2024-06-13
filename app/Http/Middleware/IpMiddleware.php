<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IpMiddleware
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
        if ($request->ip() != "54.251.80.131") {
            
            if ($request->ip() != "127.0.0.1") return response()->json(["message" => "Authentication Error"], 501); // IP Local
            //  return response()->json(["message" => "Authentication Error"], 501);

        }

        return $next($request);
    }
}
