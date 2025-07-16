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

        if (!$token) {
            return response()->json(['error' => 'Token no encontrado'], 401);
        }

        try {
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 401);
            }

            auth()->setUser($user); // <- Esto es clave
        } catch (Exception $e) {
            return response()->json(['error' => 'Token inválido o expirado'], 401);
        }

        return $next($request);
    }
}


