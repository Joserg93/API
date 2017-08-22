<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    /*
        metodo para obtener el id del User
    */
    public function auth(Request $request)
    {
        $email = $request->only('email');
        try {
            $user = User::where('email', '=', $email)->first();
            return response()->json(($user->id), 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'email_not_found'], 500);
        }
    }
    /*
        metodo para verificar le existencia de un email en el sistema
    */
    public function auth_email(Request $request)
    {
        $email = $request->only('email');
        $email = str_ireplace('"','',$email);
        try {
            $user = User::where('email', '=', $email)->first();
            if($user==null){
                return response()->json(['No existe...'],200);
            }else{
                return response()->json(['error' => 'existe'],401);
            }
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'aplication'], 500);
        }
    }
    /*
        metodo para verificar la expiración de un token
    */
    public function getAuthUser(){
        return response()->json(['valid'],200);  
    }
    /*
        metodo para obtenr un token
    */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json($token);
    }
}
