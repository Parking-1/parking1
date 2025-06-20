<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtCookieMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->cookie('token');
        // Verificar si el token está presente
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

