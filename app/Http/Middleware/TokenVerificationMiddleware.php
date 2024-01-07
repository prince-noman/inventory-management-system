<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $token = $request->header('token');
        $token = $request->cookie('token');
        $result = JWTToken::verifyToken($token);
        if($result == 'Invalid Token'){
            // return response()->json([
            //     'status' => 'fail',
            //     'message' => 'Invalid Token'
            // ], 401);
            return redirect('/userLogin');
        }else{
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userId);
            return $next($request);
        }
    }
}