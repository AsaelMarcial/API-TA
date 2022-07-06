<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions;
//use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Support\Facades\Auth;


class UsuarioController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:cuentas',
            'info' => 'string'

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Usuario::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);

        $rules = [

        ];

        $this->validate($request, $rules);

        $cuenta = new Cuenta();
        $cuenta->idUsuario = $user->id;
        $cuenta->idMultimedia= null;
        $cuenta->nombre = $request->input('nombre');
        $cuenta->apellidos = $request->input('apellidos');
        $cuenta->email = $request->input('email');
        $cuenta->info = $request->input('info');
        $cuenta->save(); //INSERT


        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','cuenta','token'),201);
    }

    public function logout(){

        Auth::guard('api')->logout();
        $success = 'Sesión cerrada';
        return compact('success');
    }
}
