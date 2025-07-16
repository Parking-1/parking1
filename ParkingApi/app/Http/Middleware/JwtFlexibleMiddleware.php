<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtFlexibleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Intenta obtener el token desde el header Authorization o desde la cookie
        $token = $request->bearerToken() ?? $request->cookie('token');

        if (!$token) {
            return response()->json(['error' => 'Token no encontrado'], 401);
        }

        try {
            JWTAuth::setToken($token)->authenticate();
        } catch (Exception $e) {
            return response()->json(['error' => 'Token inválido o expirado'], 401);
        }

        return $next($request);
    }
}
