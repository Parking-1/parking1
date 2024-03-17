<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Interface\IPdf;
use Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function GetIfExistsEmail(Request $user){
        try{
            $exist = User::where("email", $user->email)->exists();
            if(!$exist) throw new ModelNotFoundException();
            return response($exist, 200);
        }catch(ModelNotFoundException $e){
            return response(false, 404);
        }catch(Exception){
            return response(false, 500);
        }
    }
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['token_expired'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['token_absent'], $e->getStatusCode());
            }
            return response()->json(compact('user'));
    }
    public function logOut() : JsonResponse{
        try {
            // Adds token to blacklist.
            $forever = true;
            JWTAuth::parseToken()->invalidate( $forever );

            return response()->json( [
                'error'   => false,
                'message' => trans( 'auth.logged_out' )
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.expired' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.invalid' )
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.missing' )
            ], 500 );
        }
    }
    public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }
            $rol = Rol::where("nombre", "empleado")->get();
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'id_cargo' => $request['id_cargo']
            ]);
            $user->rol()->sync($rol[0]->id);
            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }
}
