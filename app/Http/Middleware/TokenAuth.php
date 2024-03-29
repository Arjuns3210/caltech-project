<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Session;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $return_array = array();
        try {
            $token = $request->header('access-token');
            $device_id = $request->header('device-id');
            $data = JWTAuth::setToken($token)->getPayload();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            errorMessage(__('auth.token_expired'), $return_array);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            errorMessage(__('auth.authentication_failed'), $return_array);
            return response()->json($return_array, 200);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            errorMessage(__('auth.authentication_failed'), $return_array);
            return response()->json($return_array, 200);
        }
        Session::flash('tokenData', $token);
        Session::flash('userDeviceData', $device_id);
        return $next($request);
    }
}
