<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Validamos existencia del usuario y su relación con el rol administrador
        if (!$user || !method_exists($user, 'roles') || !$user->roles()->where('nombre', 'administrador')->exists()) {
            return response()->json(['error' => 'Acceso no autorizado. Solo administradores.'], 403);
        }

        return $next($request);
    }
}


