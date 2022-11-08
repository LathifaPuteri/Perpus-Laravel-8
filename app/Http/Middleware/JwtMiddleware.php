<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$type)
    {
       // $user = JWTAuth::parseToken()->authenticate();
        //var_dump($user)
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 0,'message' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 0,'message' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 0,'message' => 'Authorization Token not found']);
            }
        }
        if($user && in_array($user->type, $type)){
            return $next($request);
        }else{
            return response()->json(['status' => 0,'message' => 'Invalid Role']);
        }
    }
}