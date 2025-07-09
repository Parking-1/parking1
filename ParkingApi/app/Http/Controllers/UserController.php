<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify')->except([
            'register',
            'authenticate',
            'GetIfExistsEmail'
        ]);
    }


    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
            // Enviar token como cookie HTTP-only
            return response()->json(['message' => 'Autenticado correctamente'])
            ->withCookie(cookie('token', $token, 60, '/', 'parking.local', false, true, false, 'Strict'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
    }

   public function getAuthenticatedUser(Request $request): JsonResponse
{
    $token = $request->cookie('token');

    if (!$token) {
        return response()->json(['error' => 'Token no encontrado'], 401);
    }

    try {
        $user = JWTAuth::setToken($token)->authenticate();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['user' => $user], 200);
    } catch (TokenExpiredException $e) {
        return response()->json(['error' => 'Token expirado'], $e->getStatusCode());
    } catch (TokenInvalidException $e) {
        return response()->json(['error' => 'Token inválido'], $e->getStatusCode());
    } catch (JWTException $e) {
        return response()->json(['error' => 'Token ausente o inválido'], $e->getStatusCode());
    }
}


    public function logOut(): JsonResponse
    {
        try {
            JWTAuth::parseToken()->invalidate(true);
            return response()->json(['message' => 'Sesión cerrada'])
        ->withCookie(cookie()->forget('token'));

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => true, 'message' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => true, 'message' => 'Token inválido'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => true, 'message' => 'Token no válido'], 500);
        }
    }

 public function register(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'id_cargo' => 'required|integer',
        'rol'      => 'required|string|in:empleado,administrador'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    try {
        DB::beginTransaction();
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => \Hash::make($request->get('password')),
            'id_cargo' => $request->get('id_cargo'),
       ]);

       // 2. Buscar el rol por nombre
        $rol = Rol::where('nombre', $request->rol)->firstOrFail();

        // 3. Asignar el rol al usuario (muchos a muchos)
        $user->roles()->attach($rol->id);

        DB::commit();

        $token = \JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return response()->json(['error' => 'Rol no válido o no encontrado'], 404);
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'Error al registrar el usuario',
            'message' => $e->getMessage(),
        ], 500);
    }
}



    public function GetIfExistsEmail(Request $request): JsonResponse
    {
        try {
            $exists = User::where('email', $request->email)->exists();
            return response()->json(['exists' => $exists], $exists ? 200 : 404);
        } catch (Exception $e) {
            return response()->json(['exists' => false, 'error' => 'Error de servidor'], 500);
        }
    }
}

