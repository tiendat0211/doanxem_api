<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class VerifyJWTToken extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
//
//namespace App\Http\Middleware;
//
//use Closure;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Response;
//use Tymon\JWTAuth\Exceptions\JWTException;
//use  Tymon\JWTAuth\Facades\JWTAuth;
//use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
//
//class VerifyJWTToken extends BaseMiddleware
//{
//    /**
//     * Handle an incoming request.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure  $next
//     * @return mixed
//     */
//    public function handle($request, Closure $next)
//    {
//        try {
//            $user = JWTAuth::toUser($request->input('token'));
//        } catch (JWTException $e) {
//            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
//                return $this->sendError(401, 'Token đã hết hạn');
//            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
//                return $this->sendError(401, 'Token không đúng');
//            }else{
//                return $this->sendError(401, 'Token bị sai');
//            }
//        }
//        return $next($request);
//    }
//
//    private function makeError($code, $message = '', $data = [])
//    {
//        return [
//            'code' => $code,
//            'data' => $data,
//            'message' => $message,
//        ];
//    }
//
//    public function sendError($code, $message = '', $data = [])
//    {
//        return Response::json($this->makeError($code, $message, $data));
//    }
//}
