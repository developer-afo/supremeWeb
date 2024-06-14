<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerifyJWTToken
{
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status'=>'error','msg' => 'Token is invalid'], Response::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status'=>'error','msg' => 'Token has expired'], Response::HTTP_UNAUTHORIZED);
            } else {
                return response()->json(['status'=>'error','msg' => 'Authorization token not found'], Response::HTTP_UNAUTHORIZED);
            }
        }
        
        return $next($request);
    }
}
